@extends('layouts.user')

@section('content')
<div class="max-w-7xl mx-auto pt-10"> 
    
    <!-- Main Card Container -->
    <div class="relative mt-12">
        <div class="absolute -top-7 left-0 w-full flex justify-center z-10 px-4">
            <div class="flex p-1 bg-slate-900/90 backdrop-blur-xl border border-white/10 rounded-2xl shadow-xl">
                 <button onclick="switchMainTab('cek')" id="tab-btn-cek" class="main-tab-btn px-6 py-3 rounded-xl text-sm font-bold text-white transition-all shadow-lg shadow-blue-500/20 bg-blue-600">
                    Cek Pajak
                 </button>
                 <button onclick="switchMainTab('status')" id="tab-btn-status" class="main-tab-btn px-6 py-3 rounded-xl text-sm font-bold text-slate-400 hover:text-white transition-all">
                    Status Pajak
                 </button>
                 <button onclick="switchMainTab('riwayat')" id="tab-btn-riwayat" class="main-tab-btn px-6 py-3 rounded-xl text-sm font-bold text-slate-400 hover:text-white transition-all">
                    Riwayat Pajak
                 </button>
            </div>
        </div>

        <!-- Big Card Content -->
        <div class="glass-panel min-h-[500px] p-8 md:p-12 relative pt-16">
            <!-- Background Blob -->
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

            @php
                $paidVehicles = $savedVehicles->filter(function($v) {
                    $latest = $v->pajak->first();
                    return $latest && $latest->status_pembayaran == 'Lunas';
                });
            @endphp

            <!-- TAB 1: CEK PAJAK -->
            <div id="content-cek" class="main-tab-content animate-fade-in">
                <div class="text-center max-w-2xl mx-auto">
                    <h3 class="text-2xl font-bold text-white mb-2 font-manrope">Cek Pajak Kendaraan</h3>
                    <p class="text-slate-400 mb-8">Cek tagihan pajak kendaraan anda dengan mudah dan cepat. Masukkan nomor polisi kendaraan anda dibawah ini.</p>
                
                    <!-- Type Switcher (Internal) -->
                    <div class="inline-flex gap-2 p-1 bg-white/5 rounded-xl border border-white/5 mb-8">
                        <button onclick="showSubTab('kendaraan')" class="sub-tab-btn px-4 py-2 rounded-lg text-sm font-medium bg-white/10 text-white shadow-sm transition-all" id="sub-btn-kendaraan">Kendaraan</button>
                        <button onclick="showSubTab('bangunan')" class="sub-tab-btn px-4 py-2 rounded-lg text-sm font-medium text-slate-400 hover:text-white transition-all" id="sub-btn-bangunan">Bangunan</button>
                        <button onclick="showSubTab('bumi')" class="sub-tab-btn px-4 py-2 rounded-lg text-sm font-medium text-slate-400 hover:text-white transition-all" id="sub-btn-bumi">Pajak Bumi</button>
                    </div>

                    <!-- Input Form (Kendaraan) -->
                    <div id="sub-content-kendaraan" class="sub-tab-content">
                        <form id="checkKendaraanForm" class="flex flex-col gap-6 items-center justify-center max-w-lg mx-auto" onsubmit="handleCheckKendaraan(event)">
                            <div class="flex gap-3 items-center w-full justify-center">
                                <input type="text" id="nopolArea" placeholder="AB" maxlength="2" class="w-24 md:w-28 p-5 bg-white/5 border border-white/10 rounded-2xl text-white text-center text-3xl font-bold uppercase placeholder-slate-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all shadow-inner">
                                <input type="text" id="nopolNumber" placeholder="1234" maxlength="4" class="flex-1 max-w-[240px] p-5 bg-white/5 border border-white/10 rounded-2xl text-white text-center text-3xl font-bold uppercase placeholder-slate-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all shadow-inner">
                                <input type="text" id="nopolSuffix" placeholder="XY" maxlength="3" class="w-24 md:w-28 p-5 bg-white/5 border border-white/10 rounded-2xl text-white text-center text-3xl font-bold uppercase placeholder-slate-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all shadow-inner">
                            </div>
                            <button type="submit" class="w-full max-w-sm bg-blue-600 hover:bg-blue-500 text-white font-bold py-5 rounded-2xl transition-all hover:scale-105 shadow-xl shadow-blue-600/20 flex items-center justify-center gap-2 text-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                <span>Cek Sekarang</span>
                            </button>
                        </form>
                    </div>

                    <!-- Placeholders for others -->
                    <div id="sub-content-bangunan" class="sub-tab-content hidden p-8 border border-dashed border-white/10 rounded-2xl bg-white/5">
                        <div class="text-4xl mb-2">🏗️</div>
                        <p class="text-slate-400">Layanan Pajak Bangunan segera hadir.</p>
                    </div>
                    <div id="sub-content-bumi" class="sub-tab-content hidden p-8 border border-dashed border-white/10 rounded-2xl bg-white/5">
                        <div class="text-4xl mb-2">🌍</div>
                        <p class="text-slate-400">Layanan Pajak Bumi segera hadir.</p>
                    </div>

                </div>
            </div>

            <!-- TAB 2: STATUS PAJAK (All Saved Vehicles) -->
            <div id="content-status" class="main-tab-content hidden animate-fade-in">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-white font-manrope">Status Pajak Kendaraan</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($savedVehicles as $v)
                    <div class="glass-panel p-6 relative group hover:-translate-y-1 transition-all duration-300 bg-white/5 border border-white/10 rounded-2xl">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-blue-400 border border-white/10">
                                @if($v->jenis_kendaraan == 'Mobil')
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M3 13h18M5 13v7a2 2 0 002 2h2a2 2 0 002-2v-4h2v4a2 2 0 002 2h2a2 2 0 002-2v-7m-2 0h-2m-2-5h-4M3 13l1-8h16l1 8" /></svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19c-4.286 0-4.286-6 0-6 2.857 0 4.287 4 8.287 4 3 0 4.286-4 0-4-3 0-3 3 0 3" /><circle cx="8" cy="19" r="3" /><circle cx="17" cy="19" r="3" /><path d="M12 15V8l-3-4" /></svg>
                                @endif
                            </div>
                            <button onclick="removeKendaraan('{{ $v->nomor_polisi }}')" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 mb-4 inline-block">
                            <h4 class="text-xl font-mono tracking-widest text-white font-bold">{{ $v->nomor_polisi }}</h4>
                        </div>
                        <h5 class="text-lg font-bold text-white mb-1">{{ $v->merk }} {{ $v->tipe_model }}</h5>
                        <div class="border-t border-white/10 pt-4 mt-4 flex flex-col gap-4">
                            <div class="flex justify-between items-end">
                                <div>
                                    <span class="text-xs text-slate-400">Total Tagihan</span>
                                    <div class="text-red-400 font-bold text-xl">
                                        @if($v->pajak->first() && $v->pajak->first()->status_pembayaran == 'Lunas')
                                            <span class="text-emerald-400">Lunas</span>
                                        @else
                                            Rp {{ number_format($v->pajak->first()->jumlah_pajak + $v->pajak->first()->denda, 0, ',', '.') }}
                                        @endif
                                    </div>
                                </div>
                                @if($v->pajak->first() && $v->pajak->first()->status_pembayaran == 'Lunas')
                                    <div class="px-3 py-1 bg-emerald-500/10 text-emerald-400 rounded-lg text-xs font-bold border border-emerald-500/20">
                                        Lunas
                                    </div>
                                @else
                                    <div class="px-3 py-1 bg-red-500/10 text-red-400 rounded-lg text-xs font-bold border border-red-500/20">
                                        Belum Lunas
                                    </div>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2">
                                <button onclick="checkSavedKendaraan('{{ $v->nomor_polisi }}')" class="py-3 bg-white/5 hover:bg-white/10 text-white text-sm rounded-xl font-medium transition-colors border border-white/10 w-full {{ ($v->pajak->first() && $v->pajak->first()->status_pembayaran == 'Lunas') ? 'col-span-2' : '' }}">Detail</button>
                                
                                @if($v->pajak->first() && $v->pajak->first()->status_pembayaran != 'Lunas')
                                    @if($v->pajak->first() && $v->pajak->first()->snap_token)
                                        <button id="btn-bayar-{{ $v->nomor_polisi }}" onclick="checkSavedKendaraan('{{ $v->nomor_polisi }}')" class="py-3 bg-yellow-500/20 hover:bg-yellow-500 text-yellow-400 hover:text-white border border-yellow-500/30 text-sm rounded-xl font-bold transition-all w-full leading-tight">Menunggu</button>
                                    @else
                                        <button id="btn-bayar-{{ $v->nomor_polisi }}" onclick="checkSavedKendaraan('{{ $v->nomor_polisi }}')" class="py-3 bg-emerald-600/20 hover:bg-emerald-600 text-emerald-400 hover:text-white border border-emerald-600/30 text-sm rounded-xl font-bold transition-all w-full">Bayar</button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-16 text-center border-2 border-dashed border-white/10 rounded-3xl">
                    <div class="col-span-full py-16 text-center border-2 border-dashed border-white/10 rounded-3xl">
                        <h4 class="text-xl font-bold text-white mb-2">Belum Ada Kendaraan Disimpan</h4>
                        <p class="text-slate-400">Silakan cek pajak kendaraan anda dan simpan untuk memantau statusnya di sini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 3: RIWAYAT (Paid) -->
            <div id="content-riwayat" class="main-tab-content hidden animate-fade-in">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-white font-manrope">Riwayat Pembayaran</h3>
                    <div class="relative">
                        <input type="text" id="searchRiwayat" onkeyup="searchTable()" placeholder="Cari Nopol / Merk..." class="pl-10 pr-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-blue-500 transition-colors w-64 shadow-md">
                        <svg class="absolute left-3 top-2.5 text-slate-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5 shadow-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-900/50 text-slate-300 uppercase text-xs tracking-wider font-bold">
                                <tr>
                                    <th class="p-4">Tanggal</th>
                                    <th class="p-4">Order ID</th>
                                    <th class="p-4">Kendaraan</th>
                                    <th class="p-4">Nominal</th>
                                    <th class="p-4 text-center">Status</th>
                                    <!-- <th class="p-4 text-center">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody id="riwayatTableBody" class="divide-y divide-white/5 text-sm">
                                @forelse($paymentHistories as $ph)
                                <tr class="hover:bg-white/5 transition-colors group">
                                    <td class="p-4 text-slate-300">
                                        {{ $ph->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="p-4 font-mono text-slate-400 text-xs">{{ $ph->order_id }}</td>
                                    <td class="p-4 text-slate-300">
                                        <div class="font-bold text-white">{{ $ph->pajak->kendaraan->nomor_polisi }}</div>
                                        <div class="text-xs opacity-70">{{ $ph->pajak->kendaraan->merk }}</div>
                                    </td>
                                    <td class="p-4 font-bold text-white">Rp {{ number_format($ph->amount, 0, ',', '.') }}</td>
                                    <td class="p-4 text-center">
                                        @if($ph->status == 'success')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Lunas</span>
                                        @elseif($ph->status == 'pending')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">Pending</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-400 border border-red-500/30">Gagal</span>
                                        @endif
                                    </td>
                                    <!-- <td class="p-4 text-center">
                                        <button class="p-2 hover:bg-blue-600/20 rounded-lg text-blue-400 transition-colors">
                                           Info
                                        </button>
                                    </td> -->
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-400">
                                        Belum ada riwayat transaksi.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Result Modal -->
<div id="resultModal" class="fixed inset-0 z-[9999] hidden items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeResultModal(event)"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-neutral-900/90 border border-white/10 w-full max-w-lg p-8 rounded-2xl shadow-2xl transform transition-all">
        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 mx-auto mb-4 border border-blue-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <h3 class="text-2xl font-bold text-white font-manrope">Detail Pajak Kendaraan</h3>
            <p class="text-slate-400 text-sm">Informasi tagihan pajak kendaraan anda.</p>
        </div>
    
        <div id="modalLoading" class="hidden text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
            <p class="mt-2 text-slate-400">Memuat data...</p>
        </div>
    
        <div id="modalData" class="hidden">
            <!-- Basic Info Grid -->
            <div class="grid grid-cols-2 gap-4 mb-6 bg-white/5 p-4 rounded-xl border border-white/5">
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider block mb-1">Nomor Polisi</label>
                    <p id="resNopol" class="text-white font-mono font-bold text-lg"></p>
                </div>
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider block mb-1">Merk / Tipe</label>
                    <p id="resMerkTipe" class="text-white font-bold"></p>
                </div>
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider block mb-1">Tahun / Warna</label>
                    <p id="resTahunWarna" class="text-slate-300"></p>
                </div>
                 <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider block mb-1">Nama Pemilik</label>
                    <p id="resPemilik" class="text-slate-300"></p>
                </div>
            </div>

            <!-- Receipt Details -->
            <div class="bg-black/20 rounded-xl p-6 mb-6 border border-white/5">
                <div class="flex justify-between mb-3 text-sm">
                    <span class="text-slate-400">Nomor Polisi</span>
                    <span id="detailNopol" class="text-white font-mono font-bold"></span>
                </div>
                <div class="flex justify-between mb-3 text-sm">
                    <span class="text-slate-400">Merek / Tipe</span>
                    <span id="detailMerk" class="text-white font-medium"></span>
                </div>
                <div class="flex justify-between mb-3 text-sm">
                    <span class="text-slate-400">Tahun / Warna</span>
                    <span id="detailTahun" class="text-white font-medium"></span>
                </div>
                
                <div class="h-px bg-white/10 my-4 border-dashed"></div>
                
                <div class="flex justify-between mb-3 text-sm">
                    <span class="text-slate-400">Pajak Pokok</span>
                    <span id="resPajak" class="text-white font-bold"></span>
                </div>
                <div class="flex justify-between mb-3 text-sm">
                    <span class="text-slate-400">Jatuh Tempo</span>
                    <span id="resJatuhTempo" class="text-white font-bold"></span>
                </div>
                <div class="flex justify-between mb-3 text-sm items-center">
                    <span class="text-slate-400">Status</span>
                    <span id="resStatus" class="px-3 py-1 rounded-full text-xs font-bold"></span>
                </div>
                <div id="resDendaRow" class="flex justify-between mb-3 text-sm">
                     <span class="text-slate-400">Denda</span>
                     <span id="resDenda" class="text-red-400 font-bold"></span>
                </div>
                
                <div class="mt-4 pt-4 border-t border-white/10 flex justify-between items-center">
                    <span class="font-bold text-white text-lg">Total Tagihan</span>
                    <span id="resTotal" class="font-bold text-blue-400 text-xl font-mono"></span>
                </div>
            </div>
            
             <div class="flex gap-4">
                <button type="button" id="payButton" onclick="payPajak()" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition-colors hidden shadow-lg shadow-emerald-600/20">Bayar Sekarang</button>
                <button type="button" id="saveButton" onclick="saveKendaraan()" class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-colors">Simpan Kendaraan</button>
                <button type="button" onclick="closeResultModal(event)" class="flex-1 py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold transition-colors">Tutup</button>
             </div>
        </div>
    </div>
</div>

<style>
    .glass-panel {
        background: rgba(15, 23, 42, 0.75); 
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }
    .tab-btn.active {
        background-color: rgba(56, 189, 248, 0.2);
        color: #38bdf8;
        font-weight: 800;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
    /* Input Styling Override */
    #checkKendaraanForm input {
        background-color: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.15);
        color: #fff;
    }
    #checkKendaraanForm input:focus {
        border-color: #38bdf8;
        background-color: rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
    }
    #checkKendaraanForm input::placeholder {
        color: #94a3b8;
    }
</style>

@endsection

@push('scripts')
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function switchMainTab(tab) {
        // Hide all
        document.querySelectorAll('.main-tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.main-tab-btn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
            btn.classList.add('text-slate-400');
        });

        // Show active
        document.getElementById('content-' + tab).classList.remove('hidden');
        
        // Style Active Button
        const activeBtn = document.getElementById('tab-btn-' + tab);
        activeBtn.classList.remove('text-slate-400');
        activeBtn.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
    }

    function showSubTab(tab) {
         document.querySelectorAll('.sub-tab-content').forEach(el => el.classList.add('hidden'));
         document.querySelectorAll('.sub-tab-btn').forEach(btn => {
            btn.classList.remove('bg-white/10', 'text-white', 'shadow-sm');
            btn.classList.add('text-slate-400');
         });

         document.getElementById('sub-content-' + tab).classList.remove('hidden');
         const activeBtn = document.getElementById('sub-btn-' + tab);
         activeBtn.classList.remove('text-slate-400');
         activeBtn.classList.add('bg-white/10', 'text-white', 'shadow-sm');
    }

    // Initialize
    switchMainTab('cek');
    showSubTab('kendaraan');

    // Auto-focus logic for License Plate inputs
    const inputs = ['nopolArea', 'nopolNumber', 'nopolSuffix'];
    
    inputs.forEach((id, index) => {
        const el = document.getElementById(id);
        
        el.addEventListener('input', function() {
            if (this.value.length === this.maxLength) {
                if (index < inputs.length - 1) {
                    document.getElementById(inputs[index + 1]).focus();
                }
            }
        });

        el.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value.length === 0) {
                if (index > 0) {
                    e.preventDefault();
                    document.getElementById(inputs[index - 1]).focus();
                }
            }
        });
    });

    let currentPajakId = null; // Store current checked pajak ID

    function handleCheckKendaraan(e) {
        e.preventDefault();
        
        const area = document.getElementById('nopolArea').value.trim();
        const number = document.getElementById('nopolNumber').value.trim();
        const suffix = document.getElementById('nopolSuffix').value.trim();

        if(!area || !number || !suffix) return alert('Mohon lengkapi nomor polisi.');

        const nopol = `${area} ${number} ${suffix}`;

        const modal = document.getElementById('resultModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.getElementById('modalLoading').classList.remove('hidden');
        document.getElementById('modalData').classList.add('hidden');
        document.getElementById('payButton').classList.add('hidden'); // Hide pay button initially
        document.getElementById('saveButton').style.display = 'block'; // Reset save button visibility

        fetch(`{{ route('pajak.check') }}?nopol=${encodeURIComponent(nopol)}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('modalLoading').classList.add('hidden');
                if(data.success && data.data) {
                    const k = data.data;
                    const p = k.pajak && k.pajak.length > 0 ? k.pajak[0] : null;

                    document.getElementById('modalData').classList.remove('hidden');
                    
                    document.getElementById('resNopol').textContent = k.nomor_polisi;
                    document.getElementById('resMerkTipe').textContent = `${k.merk} ${k.tipe_model}`;
                    document.getElementById('resTahunWarna').textContent = `${k.tahun_pembuatan} / ${k.warna}`;
                    document.getElementById('resPemilik').textContent = k.nama_pemilik;

                    document.getElementById('detailNopol').textContent = k.nomor_polisi;
                    document.getElementById('detailMerk').textContent = `${k.merk} ${k.tipe_model}`;
                    document.getElementById('detailTahun').textContent = `${k.tahun_pembuatan} / ${k.warna}`;

                    if(p) {
                         currentPajakId = p.id; // Store ID
                         document.getElementById('resJatuhTempo').textContent = p.tanggal_jatuh_tempo;
                         const statusEl = document.getElementById('resStatus');
                         statusEl.textContent = p.status_pembayaran;
                         
                         if(p.status_pembayaran === 'Lunas') {
                             statusEl.className = 'px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400';
                             document.getElementById('payButton').classList.add('hidden');
                             document.getElementById('saveButton').classList.remove('hidden');
                         } else {
                             statusEl.className = 'px-3 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-400';
                             document.getElementById('payButton').classList.remove('hidden');
                             // Show save button as well, or hide if we want to force pay first? Let's keep save.
                             document.getElementById('saveButton').classList.remove('hidden');
                         }

                         const pajak = parseFloat(p.jumlah_pajak);
                         const denda = parseFloat(p.denda);
                         const total = pajak + denda;

                         document.getElementById('resPajak').textContent = 'Rp ' + pajak.toLocaleString('id-ID');
                         document.getElementById('resDenda').textContent = 'Rp ' + denda.toLocaleString('id-ID');
                         document.getElementById('resTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
                    } else {
                         document.getElementById('resStatus').textContent = 'Data Pajak Belum Tersedia';
                         document.getElementById('resStatus').className = 'px-3 py-1 rounded-full text-xs font-bold bg-slate-500/20 text-slate-400';
                         document.getElementById('resPajak').textContent = '-';
                         document.getElementById('resDenda').textContent = '-';
                         document.getElementById('resTotal').textContent = '-';
                         document.getElementById('payButton').classList.add('hidden');
                    }

                } else {
                    alert(data.message || 'Data tidak ditemukan');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat menghubungi server.');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
    }

    function payPajak() {
        if(!currentPajakId) return;

        // Disable button
        const btn = document.getElementById('payButton');
        const originalText = btn.textContent;
        btn.textContent = 'Memproses...';
        btn.disabled = true;

        fetch("{{ route('pajak.pay') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ pajak_id: currentPajakId })
        })
        .then(res => res.json())
        .then(data => {
            btn.textContent = originalText;
            btn.disabled = false;

            if (data.status === 'expired') {
                alert('Sesi pembayaran sebelumnya telah kedaluwarsa. Silakan klik tombol Bayar lagi untuk membuat pembayaran baru.');
                
                window.location.reload(); 
                return;
            }

            if(data.token) {
                // Open Snap
                window.snap.pay(data.token, {
                    onSuccess: function(result){
                        alert("Pembayaran berhasil!");
                        window.location.reload();
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran!");
                        window.location.reload();
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!");
                        console.log(result);
                    },
                    onClose: function(){
                        console.log('Customer closed the popup without finishing the payment');
                    }
                });
            } else {
                alert(data.error || 'Gagal membuat transaksi');
            }
        })
        .catch(err => {
            console.error(err);
            btn.textContent = originalText;
            btn.disabled = false;
            alert('Terjadi kesalahan sistem');
        });
    }

    function closeResultModal(e) {
        if (e.target === e.currentTarget || e.target.tagName === 'BUTTON') {
             const modal = document.getElementById('resultModal');
             modal.classList.add('hidden');
             modal.classList.remove('flex');
        }
    }
    
    function saveKendaraan() {
        const nopol = document.getElementById('resNopol').textContent;
        if(!nopol) return;

        fetch("{{ route('pajak.save') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nopol: nopol })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert('Kendaraan berhasil disimpan!');
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menyimpan kendaraan');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan sistem');
        });
    }

    function removeKendaraan(nopol) {
        if(!confirm('Hapus kendaraan ' + nopol + ' dari daftar?')) return;

        fetch(`/pajak/remove/${encodeURIComponent(nopol)}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menghapus kendaraan');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan sistem');
        });
    }

    function checkSavedKendaraan(nopol) {
        // reuse the fetching logic but bypass the form input
        const modal = document.getElementById('resultModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.getElementById('modalLoading').classList.remove('hidden');
        document.getElementById('modalData').classList.add('hidden');
        document.getElementById('payButton').classList.add('hidden');

        fetch(`{{ route('pajak.check') }}?nopol=${encodeURIComponent(nopol)}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('modalLoading').classList.add('hidden');
                if(data.success && data.data) {
                    const k = data.data;
                    const p = k.pajak && k.pajak.length > 0 ? k.pajak[0] : null;

                    document.getElementById('modalData').classList.remove('hidden');
                    
                    document.getElementById('resNopol').textContent = k.nomor_polisi;
                    document.getElementById('resMerkTipe').textContent = `${k.merk} ${k.tipe_model}`;
                    document.getElementById('resTahunWarna').textContent = `${k.tahun_pembuatan} / ${k.warna}`;
                    document.getElementById('resPemilik').textContent = k.nama_pemilik;

                    document.getElementById('detailNopol').textContent = k.nomor_polisi;
                    document.getElementById('detailMerk').textContent = `${k.merk} ${k.tipe_model}`;
                    document.getElementById('detailTahun').textContent = `${k.tahun_pembuatan} / ${k.warna}`;

                    if(p) {
                         currentPajakId = p.id;
                         document.getElementById('resJatuhTempo').textContent = p.tanggal_jatuh_tempo;
                         const statusEl = document.getElementById('resStatus');
                         statusEl.textContent = p.status_pembayaran;
                         
                         if(p.status_pembayaran === 'Lunas') {
                             statusEl.className = 'px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400';
                             document.getElementById('payButton').classList.add('hidden');
                             document.getElementById('saveButton').classList.add('hidden'); // Already saved, hide or change text?
                         } else {
                             statusEl.className = 'px-3 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-400';
                             document.getElementById('payButton').classList.remove('hidden');
                             document.getElementById('saveButton').classList.add('hidden');
                         }

                         const pajak = parseFloat(p.jumlah_pajak);
                         const denda = parseFloat(p.denda);
                         const total = pajak + denda;

                         document.getElementById('resPajak').textContent = 'Rp ' + pajak.toLocaleString('id-ID');
                         document.getElementById('resDenda').textContent = 'Rp ' + denda.toLocaleString('id-ID');
                         document.getElementById('resTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
                    } else {
                         document.getElementById('resStatus').textContent = 'Data Pajak Belum Tersedia';
                         document.getElementById('resStatus').className = 'px-3 py-1 rounded-full text-xs font-bold bg-slate-500/20 text-slate-400';
                         document.getElementById('resPajak').textContent = '-';
                         document.getElementById('resDenda').textContent = '-';
                         document.getElementById('resTotal').textContent = '-';
                         document.getElementById('payButton').classList.add('hidden');
                         document.getElementById('saveButton').classList.add('hidden');
                    }
                    
                    document.getElementById('saveButton').style.display = 'none';

                } else {
                    alert(data.message || 'Data tidak ditemukan');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat menghubungi server.');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
    }

    function searchTable() {
        const input = document.getElementById('searchRiwayat');
        const filter = input.value.toUpperCase();
        const tbody = document.getElementById('riwayatTableBody');
        const rows = tbody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const tdOrderId = rows[i].getElementsByTagName('td')[1]; // Order ID
            const tdKendaraan = rows[i].getElementsByTagName('td')[2]; // Nopol & Merk
            
            if (tdOrderId || tdKendaraan) {
                const txtValueOrder = tdOrderId.textContent || tdOrderId.innerText;
                const txtValueKendaraan = tdKendaraan.textContent || tdKendaraan.innerText;
                
                if (txtValueOrder.toUpperCase().indexOf(filter) > -1 || txtValueKendaraan.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    }
</script>
@endpush
