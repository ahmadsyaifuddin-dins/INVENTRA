<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_opname');
            // Relasi ke User (Petugas Pemeriksa)
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade');
            // Relasi ke Ruangan (Lokasi Cek)
            $table->foreignId('ruangan_id')->constrained('ruangan')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};
