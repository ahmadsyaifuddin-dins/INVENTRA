<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. SEED KATEGORI ---
        $kat_elektronik = DB::table('kategori')->insertGetId([
            'kode_kategori' => 'ELK',
            'nama_kategori' => 'Elektronik',
            'deskripsi' => 'Barang elektronik kantor seperti Laptop, Printer, AC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $kat_mebel = DB::table('kategori')->insertGetId([
            'kode_kategori' => 'MBL',
            'nama_kategori' => 'Mebel',
            'deskripsi' => 'Perabotan kantor seperti Meja, Kursi, Lemari',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $kat_kendaraan = DB::table('kategori')->insertGetId([
            'kode_kategori' => 'KDR',
            'nama_kategori' => 'Kendaraan Dinas',
            'deskripsi' => 'Kendaraan operasional roda 2 dan roda 4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- 2. SEED RUANGAN ---
        $ruang_tu = DB::table('ruangan')->insertGetId([
            'nama_ruangan' => 'Ruang Tata Usaha',
            'penanggung_jawab' => 'Ibu Kasaur',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ruang_kajari = DB::table('ruangan')->insertGetId([
            'nama_ruangan' => 'Ruang Kajari',
            'penanggung_jawab' => 'Bapak Kepala',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ruang_gudang = DB::table('ruangan')->insertGetId([
            'nama_ruangan' => 'Gudang Aset',
            'penanggung_jawab' => 'Pak Security',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- 3. SEED BARANG ---
        $brg_laptop = DB::table('barang')->insertGetId([
            'kategori_id' => $kat_elektronik,
            'kode_barang' => '3.01.02.01',
            'nama_barang' => 'Laptop ASUS ROG',
            'merek' => 'ASUS',
            'tahun_perolehan' => '2023',
            'satuan' => 'Unit',
            'foto' => null, // Nanti diupload manual
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $brg_kursi = DB::table('barang')->insertGetId([
            'kategori_id' => $kat_mebel,
            'kode_barang' => '2.05.01.04',
            'nama_barang' => 'Kursi Kerja Eselon',
            'merek' => 'Informa',
            'tahun_perolehan' => '2022',
            'satuan' => 'Buah',
            'foto' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- 4. SEED PENEMPATAN (DISTRIBUSI) ---
        // Laptop ada di Ruang TU
        DB::table('penempatan')->insert([
            'barang_id' => $brg_laptop,
            'ruangan_id' => $ruang_tu,
            'jumlah' => 1,
            'kondisi' => 'Baik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kursi ada di Ruang Kajari
        DB::table('penempatan')->insert([
            'barang_id' => $brg_kursi,
            'ruangan_id' => $ruang_kajari,
            'jumlah' => 1,
            'kondisi' => 'Baik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
