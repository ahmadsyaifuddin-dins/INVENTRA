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
        // 1. Cek dan tambah kode_kategori JIKA belum ada
        if (! Schema::hasColumn('kategori', 'kode_kategori')) {
            Schema::table('kategori', function (Blueprint $table) {
                $table->string('kode_kategori', 10)->nullable()->after('nama_kategori');
            });
        }

        // 2. Cek dan tambah kode_ruangan JIKA belum ada
        if (! Schema::hasColumn('ruangan', 'kode_ruangan')) {
            Schema::table('ruangan', function (Blueprint $table) {
                $table->string('kode_ruangan', 10)->nullable()->after('nama_ruangan');
            });
        }

        // 3. Cek dan tambah sub_kategori_id JIKA belum ada
        if (! Schema::hasColumn('barang', 'sub_kategori_id')) {
            Schema::table('barang', function (Blueprint $table) {
                $table->foreignId('sub_kategori_id')->nullable()->after('kategori_id')->constrained('sub_kategori')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            if (Schema::hasColumn('kategori', 'kode_kategori')) {
                $table->dropColumn('kode_kategori');
            }
        });

        Schema::table('ruangan', function (Blueprint $table) {
            if (Schema::hasColumn('ruangan', 'kode_ruangan')) {
                $table->dropColumn('kode_ruangan');
            }
        });

        Schema::table('barang', function (Blueprint $table) {
            if (Schema::hasColumn('barang', 'sub_kategori_id')) {
                $table->dropForeign(['sub_kategori_id']);
                $table->dropColumn('sub_kategori_id');
            }
        });
    }
};
