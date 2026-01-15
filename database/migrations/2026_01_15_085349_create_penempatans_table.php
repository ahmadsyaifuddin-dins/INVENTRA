<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nama tabel: penempatan
        Schema::create('penempatan', function (Blueprint $table) {
            $table->id();

            // PENTING: Sebutkan nama tabel tujuannya secara eksplisit
            $table->foreignId('barang_id')->constrained(table: 'barang')->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained(table: 'ruangan')->onDelete('cascade');

            $table->integer('jumlah');
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penempatan');
    }
};
