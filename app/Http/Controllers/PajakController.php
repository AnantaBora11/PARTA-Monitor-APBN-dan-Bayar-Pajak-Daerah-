<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PajakController extends Controller
{
    public function index()
    {
        $savedVehicles = auth()->user()->savedVehicles()->with(['pajak' => function ($query) {
            $query->latest('tahun_pajak');
        }])->get();

        foreach($savedVehicles as $v) {
            if($v->pajak->isNotEmpty()) {
                $this->checkAndApplyFine($v->pajak->first());
            }
        }

        $userNopols = $savedVehicles->pluck('nomor_polisi');
        $userPajakIds = \App\Models\PajakKendaraan::whereIn('nomor_polisi', $userNopols)->pluck('id');
        
        $pendingHistories = \App\Models\PaymentHistory::whereIn('pajak_id', $userPajakIds)
                            ->where('status', 'pending')
                            ->get();

        if ($pendingHistories->isNotEmpty()) {
            $this->configureMidtrans();
            foreach ($pendingHistories as $history) {
                try {
                    $status = \Midtrans\Transaction::status($history->order_id);
                    $transactionStatus = $status->transaction_status;
                    $pajak = $history->pajak;

                    if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                        $history->status = 'success';
                        $history->save();

                        if ($pajak) {
                            $pajak->status_pembayaran = 'Lunas';
                            $pajak->tanggal_bayar = now();
                            $pajak->save();
                        }
                    } elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                        // Mark as Failed
                        $history->status = 'failed';
                        $history->save();

                        if ($pajak) {
                            $pajak->snap_token = null;
                            $pajak->save();
                        }
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        $savedVehicles = auth()->user()->savedVehicles()->with(['pajak' => function ($query) {
            $query->latest('tahun_pajak');
        }])->get();

        // Get Payment History
        $vehicleNopols = $savedVehicles->pluck('nomor_polisi');
        $pajakIds = \App\Models\PajakKendaraan::whereIn('nomor_polisi', $vehicleNopols)->pluck('id');
        $paymentHistories = \App\Models\PaymentHistory::whereIn('pajak_id', $pajakIds)
                            ->with('pajak.kendaraan')
                            ->latest()
                            ->get();

        return view('user.pajak', compact('savedVehicles', 'paymentHistories'));
    }

    public function checkKendaraan(Request $request)
    {
        try {
            $nopol = $request->query('nopol');

            if (!$nopol) {
                return response()->json(['success' => false, 'message' => 'Nomor polisi harus diisi.'], 400);
            }

            $kendaraan = \App\Models\Kendaraan::with(['pajak' => function ($query) {
                $query->latest('tahun_pajak');
            }])->find($nopol);

            if (!$kendaraan) {
                return response()->json(['success' => false, 'message' => 'Data kendaraan tidak ditemukan.'], 404);
            }

            // Apply fine check
            if($kendaraan->pajak->isNotEmpty()) {
                $this->checkAndApplyFine($kendaraan->pajak->first());
            }

            $kendaraan->load(['pajak' => function ($query) {
                $query->latest('tahun_pajak');
            }]);

            return response()->json([
                'success' => true,
                'data' => $kendaraan
            ]);
        } catch (\Exception $e) {
            \Log::error('Error checking kendaraan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
        }
    }

    public function storeSavedVehicle(Request $request)
    {
        $request->validate([
            'nopol' => 'required|exists:kendaraan,nomor_polisi'
        ]);

        $user = auth()->user();
        if (!$user->savedVehicles()->where('kendaraan.nomor_polisi', $request->nopol)->exists()) {
            $user->savedVehicles()->attach($request->nopol);
        }

        return response()->json(['success' => true, 'message' => 'Kendaraan berhasil disimpan.']);
    }

    public function removeSavedVehicle($nopol)
    {
        $user = auth()->user();
        $user->savedVehicles()->detach($nopol);

        return response()->json(['success' => true, 'message' => 'Kendaraan dihapus dari daftar.']);
    }

    private function checkAndApplyFine($pajak)
    {
        if ($pajak->status_pembayaran == 'Belum Bayar' && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($pajak->tanggal_jatuh_tempo))) {
            
            if ($pajak->denda == 0) {
                 $denda = $pajak->jumlah_pajak * 0.25;
                 $pajak->denda = $denda;
                 $pajak->save();
            }
        }
    }

    private function configureMidtrans()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    public function getSnapToken(Request $request)
    {
        try {
            $this->configureMidtrans();

            $pajakId = $request->pajak_id;
            $pajak = \App\Models\PajakKendaraan::with('kendaraan')->find($pajakId);

            if (!$pajak) {
                return response()->json(['error' => 'Data pajak tidak ditemukan'], 404);
            }

            // Check existing token validity if it exists
            if ($pajak->snap_token && $pajak->status_pembayaran == 'Belum Bayar') {
                // Find latest payment history to get order_id
                $latestHistory = \App\Models\PaymentHistory::where('pajak_id', $pajak->id)
                                ->latest()
                                ->first();
                                
                if ($latestHistory) {
                    try {
                        // Check status to Midtrans
                        $status = \Midtrans\Transaction::status($latestHistory->order_id);
                        
                        if ($status->transaction_status == 'expire' || $status->transaction_status == 'cancel' || $status->transaction_status == 'deny') {
                            $latestHistory->status = 'failed';
                            $latestHistory->save();
                            $pajak->snap_token = null;
                            $pajak->save();

                            return response()->json(['status' => 'expired']);
                        } else {
                            return response()->json(['token' => $pajak->snap_token]);
                        }
                    } catch (\Exception $e) {
                         $pajak->snap_token = null;
                         $pajak->save();
                         return response()->json(['status' => 'expired']);
                    }
                }
            }

            // Calculate total with fine
            $total = $pajak->jumlah_pajak + $pajak->denda;
            $orderId = 'TAX-' . $pajak->id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $total,
                ],
                'customer_details' => [
                    'first_name' => $pajak->kendaraan->nama_pemilik,
                    'phone' => auth()->user()->phone ?? '08123456789', // Fallback if no phone
                ],
                'item_details' => [
                    [
                        'id' => 'PJ-' . $pajak->id,
                        'price' => (int) $pajak->jumlah_pajak,
                        'quantity' => 1,
                        'name' => 'Pajak Kendaraan ' . $pajak->kendaraan->nomor_polisi
                    ]
                ]
            ];

            if ($pajak->denda > 0) {
                $params['item_details'][] = [
                    'id' => 'DD-' . $pajak->id,
                    'price' => (int) $pajak->denda,
                    'quantity' => 1,
                    'name' => 'Denda Keterlambatan'
                ];
            }

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $pajak->snap_token = $snapToken;
            $pajak->save();

            \App\Models\PaymentHistory::create([
                'pajak_id' => $pajak->id,
                'order_id' => $orderId,
                'snap_token' => $snapToken,
                'amount' => $total,
                'status' => 'pending'
            ]);

            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            $transactionStatus = $request->transaction_status;
            $orderId = $request->order_id;
            
            // Find Log
            $history = \App\Models\PaymentHistory::where('order_id', $orderId)->first();
            
            $orderIdParts = explode('-', $orderId);
            $pajakId = (count($orderIdParts) >= 2) ? $orderIdParts[1] : null;
            $pajak = $pajakId ? \App\Models\PajakKendaraan::find($pajakId) : null;

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                if ($pajak) {
                    $pajak->status_pembayaran = 'Lunas';
                    $pajak->tanggal_bayar = now();
                    $pajak->save();
                }
                if ($history) {
                    $history->status = 'success';
                    $history->save();
                }
            } elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                if ($pajak) {
                    $pajak->snap_token = null;
                    $pajak->save();
                }
                if ($history) {
                    $history->status = 'failed';
                    $history->save();
                }
            } elseif ($transactionStatus == 'pending') {
            }
        }
    }
}
