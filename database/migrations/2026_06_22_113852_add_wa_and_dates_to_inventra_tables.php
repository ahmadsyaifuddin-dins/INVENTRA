<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom no_wa di tabel pengguna
        Schema::table('pengguna', function (Blueprint $table) {
            $table->string('no_wa', 20)->nullable()->after('email');
        });

        // 2. Tambah kolom tanggal di tabel barang
        Schema::table('barang', function (Blueprint $table) {
            $table->date('tgl_penyusutan_habis')->nullable()->after('tahun_perolehan');
            $table->date('tgl_servis_berikutnya')->nullable()->after('tgl_penyusutan_habis');
        });
    }

    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn('no_wa');
        });

        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn(['tgl_penyusutan_habis', 'tgl_servis_berikutnya']);
        });
    }
};
