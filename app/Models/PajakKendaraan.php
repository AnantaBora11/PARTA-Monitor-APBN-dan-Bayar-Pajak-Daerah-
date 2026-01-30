<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PajakKendaraan extends Model
{
    use HasFactory;

    protected $table = 'pajak_kendaraan';

    protected $fillable = [
        'nomor_polisi',
        'tahun_pajak',
        'tanggal_jatuh_tempo',
        'jumlah_pajak',
        'status_pembayaran',
        'tanggal_bayar',
        'denda',
        'snap_token',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'nomor_polisi', 'nomor_polisi');
    }
}
