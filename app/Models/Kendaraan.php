<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';
    protected $primaryKey = 'nomor_polisi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nomor_polisi',
        'nomor_rangka',
        'nomor_mesin',
        'merk',
        'tipe_model',
        'tahun_pembuatan',
        'warna',
        'jenis_kendaraan',
        'nama_pemilik',
        'alamat_pemilik',
    ];

    public function pajak()
    {
        return $this->hasMany(PajakKendaraan::class, 'nomor_polisi', 'nomor_polisi');
    }
}
