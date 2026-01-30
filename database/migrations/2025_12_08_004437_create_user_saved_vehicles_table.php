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
        Schema::create('user_saved_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nomor_polisi');
            $table->foreign('nomor_polisi')->references('nomor_polisi')->on('kendaraan')->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicates
            $table->unique(['user_id', 'nomor_polisi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_saved_vehicles');
    }
};
