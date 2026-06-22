<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel barang
            $table->foreignId('barang_id')->constrained(table: 'barang')->onDelete('cascade');

            // Relasi ke tabel pengguna (Peminjam)
            $table->foreignId('user_id')->constrained(table: 'pengguna')->onDelete('cascade');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali'); // Batas waktu pengembalian

            // Status peminjaman (Teks bersih tanpa emotikon)
            $table->enum('status', [
                'Menunggu ACC',
                'Dipinjam',
                'Ditolak',
                'Dikembalikan',
                'Terlambat',
            ])->default('Menunggu ACC');

            $table->text('keterangan')->nullable(); // Alasan meminjam (misal: Dinas luar kota)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
