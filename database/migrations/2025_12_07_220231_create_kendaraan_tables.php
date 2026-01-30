<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->string('nomor_polisi')->primary();
            $table->string('nomor_rangka');
            $table->string('nomor_mesin');
            $table->string('merk');
            $table->string('tipe_model');
            $table->year('tahun_pembuatan');
            $table->string('warna');
            $table->string('jenis_kendaraan'); // Mobil, Motor, Truck, Bus
            $table->string('nama_pemilik');
            $table->text('alamat_pemilik');
            $table->timestamps();
        });

        Schema::create('pajak_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_polisi');
            $table->foreign('nomor_polisi')->references('nomor_polisi')->on('kendaraan')->onDelete('cascade');
            $table->year('tahun_pajak');
            $table->date('tanggal_jatuh_tempo');
            $table->decimal('jumlah_pajak', 12, 2);
            $table->enum('status_pembayaran', ['Lunas', 'Belum Bayar']);
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('denda', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pajak_kendaraan');
        Schema::dropIfExists('kendaraan');
    }
};
