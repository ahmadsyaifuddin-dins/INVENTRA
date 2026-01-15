<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nama tabel: barang
        Schema::create('barang', function (Blueprint $table) {
            $table->id();

            // PENTING: Karena nama tabel tujuannya 'kategori' (bukan kategoris),
            // kita harus sebutkan secara eksplisit table: 'kategori'
            $table->foreignId('kategori_id')->constrained(table: 'kategori')->onDelete('cascade');

            $table->string('kode_barang', 20)->unique();
            $table->string('nama_barang', 100);
            $table->string('merek', 50)->nullable();
            $table->year('tahun_perolehan');
            $table->string('satuan', 20);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
