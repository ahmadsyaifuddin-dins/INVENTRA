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
        Schema::create('stock_opname_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_opname_id')->constrained('stock_opnames')->onDelete('cascade');
            // Barang yang dicek
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
            // Status Fisik
            $table->enum('status_fisik', ['Ada', 'Hilang', 'Rusak', 'Pindah']);
            // Jumlah sistem vs fisik (jika barangnya banyak, misal kursi)
            $table->integer('jumlah_sistem');
            $table->integer('jumlah_fisik');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opname_details');
    }
};
