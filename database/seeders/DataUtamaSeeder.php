<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataUtamaSeeder extends Seeder
{
    public function run(): void
    {
        $kat_elk = DB::table('kategori')->insertGetId(['kode_kategori' => 'ELK', 'nama_kategori' => 'Elektronik', 'created_at' => now()]);
        $kat_mbl = DB::table('kategori')->insertGetId(['kode_kategori' => 'MBL', 'nama_kategori' => 'Mebel', 'created_at' => now()]);
        $kat_kdr = DB::table('kategori')->insertGetId(['kode_kategori' => 'KDR', 'nama_kategori' => 'Kendaraan', 'created_at' => now()]);

        $sub_laptop = DB::table('sub_kategori')->insertGetId(['kategori_id' => $kat_elk, 'kode_sub' => '01', 'nama_sub' => 'Laptop']);
        $sub_printer = DB::table('sub_kategori')->insertGetId(['kategori_id' => $kat_elk, 'kode_sub' => '02', 'nama_sub' => 'Printer']);
        $sub_kursi = DB::table('sub_kategori')->insertGetId(['kategori_id' => $kat_mbl, 'kode_sub' => '01', 'nama_sub' => 'Kursi']);
        $sub_lemari = DB::table('sub_kategori')->insertGetId(['kategori_id' => $kat_mbl, 'kode_sub' => '02', 'nama_sub' => 'Lemari']);
        $sub_motor = DB::table('sub_kategori')->insertGetId(['kategori_id' => $kat_kdr, 'kode_sub' => '01', 'nama_sub' => 'Motor']);

        $r_tu = DB::table('ruangan')->insertGetId([
            'kode_ruangan' => '01', 'nama_ruangan' => 'Ruang Tata Usaha', 'penanggung_jawab' => 'Ibu Kasaur', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $r_kajari = DB::table('ruangan')->insertGetId([
            'kode_ruangan' => '02', 'nama_ruangan' => 'Ruang Kajari', 'penanggung_jawab' => 'Bapak Kepala', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $r_gudang = DB::table('ruangan')->insertGetId([
            'kode_ruangan' => '03', 'nama_ruangan' => 'Gudang Utama', 'penanggung_jawab' => 'Pak Security', 'created_at' => now(), 'updated_at' => now(),
        ]);
        $r_rapat = DB::table('ruangan')->insertGetId([
            'kode_ruangan' => '04', 'nama_ruangan' => 'Ruang Rapat', 'penanggung_jawab' => 'Ibu Sekretaris', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $barangs = [
            // 6 Data dari sebelumnya (Bulan Juli)
            ['kat' => $kat_elk, 'sub' => $sub_laptop, 'urutan' => '01', 'nama' => 'Laptop ASUS TUF A15', 'merek' => 'ASUS', 'thn' => '2026', 'susut' => '2026-07-25', 'servis' => '2026-07-15'],
            ['kat' => $kat_elk, 'sub' => $sub_laptop, 'urutan' => '02', 'nama' => 'Laptop Lenovo ThinkPad', 'merek' => 'Lenovo', 'thn' => '2026', 'susut' => null, 'servis' => '2026-08-10'],
            ['kat' => $kat_elk, 'sub' => $sub_laptop, 'urutan' => '03', 'nama' => 'MacBook Pro M2', 'merek' => 'Apple', 'thn' => '2026', 'susut' => '2026-12-01', 'servis' => null],
            ['kat' => $kat_elk, 'sub' => $sub_printer, 'urutan' => '01', 'nama' => 'Printer Epson L3110', 'merek' => 'Epson', 'thn' => '2025', 'susut' => '2026-07-20', 'servis' => '2026-07-22'],
            ['kat' => $kat_elk, 'sub' => $sub_printer, 'urutan' => '02', 'nama' => 'Printer Canon Pixma', 'merek' => 'Canon', 'thn' => '2025', 'susut' => null, 'servis' => '2026-09-15'],

            ['kat' => $kat_mbl, 'sub' => $sub_kursi, 'urutan' => '01', 'nama' => 'Kursi Direktur Ergonomis', 'merek' => 'Informa', 'thn' => '2024', 'susut' => '2026-07-10', 'servis' => null],
            ['kat' => $kat_mbl, 'sub' => $sub_kursi, 'urutan' => '02', 'nama' => 'Kursi Hadap Rapat', 'merek' => 'IKEA', 'thn' => '2024', 'susut' => null, 'servis' => null],
            ['kat' => $kat_mbl, 'sub' => $sub_kursi, 'urutan' => '03', 'nama' => 'Kursi Tunggu Besi', 'merek' => 'Chitose', 'thn' => '2024', 'susut' => '2027-01-01', 'servis' => null],
            ['kat' => $kat_mbl, 'sub' => $sub_lemari, 'urutan' => '01', 'nama' => 'Lemari Arsip Kaca', 'merek' => 'Brother', 'thn' => '2022', 'susut' => '2026-07-28', 'servis' => null],

            ['kat' => $kat_kdr, 'sub' => $sub_motor, 'urutan' => '01', 'nama' => 'Honda Vario 160cc', 'merek' => 'Honda', 'thn' => '2023', 'susut' => '2028-01-01', 'servis' => '2026-07-18'],
            ['kat' => $kat_kdr, 'sub' => $sub_motor, 'urutan' => '02', 'nama' => 'Yamaha NMAX', 'merek' => 'Yamaha', 'thn' => '2023', 'susut' => null, 'servis' => '2026-07-25'],

            // TAMBAHAN: 4 Data ekstra untuk memenuhi kuota Laporan Bulan Juli 2026
            ['kat' => $kat_elk, 'sub' => $sub_printer, 'urutan' => '03', 'nama' => 'Scanner Brother MFC', 'merek' => 'Brother', 'thn' => '2025', 'susut' => '2026-07-05', 'servis' => null],
            ['kat' => $kat_elk, 'sub' => $sub_laptop, 'urutan' => '04', 'nama' => 'Laptop HP Pavilion', 'merek' => 'HP', 'thn' => '2026', 'susut' => null, 'servis' => '2026-07-28'],
            ['kat' => $kat_mbl, 'sub' => $sub_lemari, 'urutan' => '02', 'nama' => 'Lemari Kayu Jati', 'merek' => 'Jepara', 'thn' => '2021', 'susut' => '2026-07-30', 'servis' => null],
            ['kat' => $kat_kdr, 'sub' => $sub_motor, 'urutan' => '03', 'nama' => 'Honda Beat FI', 'merek' => 'Honda', 'thn' => '2024', 'susut' => null, 'servis' => '2026-07-12'],
        ];

        foreach ($barangs as $b) {
            $kategori_kode = DB::table('kategori')->where('id', $b['kat'])->value('kode_kategori');
            $sub_kode = DB::table('sub_kategori')->where('id', $b['sub'])->value('kode_sub');

            $kode_final = "{$kategori_kode}.{$sub_kode}.{$b['thn']}.{$b['urutan']}.00";

            DB::table('barang')->insert([
                'kategori_id' => $b['kat'],
                'sub_kategori_id' => $b['sub'],
                'kode_barang' => $kode_final,
                'nama_barang' => $b['nama'],
                'merek' => $b['merek'],
                'tahun_perolehan' => $b['thn'],
                'satuan' => 'Unit',
                'tgl_penyusutan_habis' => $b['susut'],
                'tgl_servis_berikutnya' => $b['servis'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
