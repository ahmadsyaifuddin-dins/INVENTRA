<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $barangs = DB::table('barang')->get();
        $ruangans = DB::table('ruangan')->pluck('id')->toArray();
        $pegawais = DB::table('pengguna')->where('role', 'Pegawai')->pluck('id')->toArray();

        // ----------------------------------------------------
        // 1. SEED PENEMPATAN
        // ----------------------------------------------------
        $kondisi_opsi = ['Baik', 'Baik', 'Baik', 'Rusak Ringan', 'Rusak Berat'];

        foreach ($barangs as $index => $b) {
            DB::table('penempatan')->insert([
                'barang_id' => $b->id,
                'ruangan_id' => $ruangans[$index % count($ruangans)],
                'jumlah' => 1,
                'kondisi' => $kondisi_opsi[array_rand($kondisi_opsi)],
                'created_at' => Carbon::now()->subDays(rand(1, 60)),
                'updated_at' => Carbon::now(),
            ]);
        }

        // ----------------------------------------------------
        // 2. SEED PEMINJAMAN (Menjamin Laporan 6 & 7 >= 10 Data)
        // ----------------------------------------------------
        // 10 transaksi dengan status 'Dipinjam' atau 'Terlambat' untuk 10 pegawai yang berbeda.
        $skenario_peminjaman = [
            ['user' => $pegawais[0], 'brg' => $barangs[0]->id, 'status' => 'Dipinjam', 'kembali' => '2026-07-25'],
            ['user' => $pegawais[1], 'brg' => $barangs[1]->id, 'status' => 'Terlambat', 'kembali' => '2026-07-10'],
            ['user' => $pegawais[2], 'brg' => $barangs[2]->id, 'status' => 'Dipinjam', 'kembali' => '2026-07-22'],
            ['user' => $pegawais[3], 'brg' => $barangs[3]->id, 'status' => 'Terlambat', 'kembali' => '2026-07-11'],
            ['user' => $pegawais[4], 'brg' => $barangs[4]->id, 'status' => 'Dipinjam', 'kembali' => '2026-07-28'],
            ['user' => $pegawais[5], 'brg' => $barangs[5]->id, 'status' => 'Terlambat', 'kembali' => '2026-07-14'],
            ['user' => $pegawais[6], 'brg' => $barangs[6]->id, 'status' => 'Dipinjam', 'kembali' => '2026-07-20'],
            ['user' => $pegawais[7], 'brg' => $barangs[7]->id, 'status' => 'Terlambat', 'kembali' => '2026-07-15'],
            ['user' => $pegawais[8], 'brg' => $barangs[8]->id, 'status' => 'Dipinjam', 'kembali' => '2026-07-29'],
            ['user' => $pegawais[9], 'brg' => $barangs[9]->id, 'status' => 'Terlambat', 'kembali' => '2026-07-12'],
            // Tambahan riwayat selesai agar grafiknya seimbang
            ['user' => $pegawais[0], 'brg' => $barangs[10]->id, 'status' => 'Dikembalikan', 'kembali' => '2026-07-05'],
            ['user' => $pegawais[1], 'brg' => $barangs[11]->id, 'status' => 'Dikembalikan', 'kembali' => '2026-07-08'],
        ];

        foreach ($skenario_peminjaman as $p) {
            DB::table('peminjaman')->insert([
                'user_id' => $p['user'],
                'barang_id' => $p['brg'],
                'tanggal_pinjam' => Carbon::parse($p['kembali'])->subDays(7),
                'tanggal_kembali' => $p['kembali'],
                'status' => $p['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ----------------------------------------------------
        // 3. SEED AUDIT STOK OPNAME (Menjamin Laporan 9 >= 10 Data)
        // ----------------------------------------------------
        $opname_id = DB::table('stock_opnames')->insertGetId([
            'ruangan_id' => $ruangans[0],
            'user_id' => DB::table('pengguna')->where('role', 'Administrator')->value('id'),
            'tanggal_opname' => '2026-07-10',
            'catatan' => 'Audit Rutin Semester Genap',
            'created_at' => '2026-07-10 10:00:00',
            'updated_at' => now(),
        ]);

        // Melakukan pengecekan audit terhadap 12 barang sekaligus (Memenuhi kuota > 10)
        for ($i = 0; $i < 12; $i++) {
            $stok_sistem = 1;
            $stok_fisik = ($i % 5 === 0) ? 0 : 1; // Barang ke-0, 5, dan 10 pura-puranya hilang/selisih

            DB::table('stock_opname_details')->insert([
                'stock_opname_id' => $opname_id,
                'barang_id' => $barangs[$i]->id,
                'jumlah_sistem' => $stok_sistem,
                'jumlah_fisik' => $stok_fisik,
                'keterangan' => ($stok_fisik < $stok_sistem) ? 'Barang tidak ditemukan' : 'Sesuai',
                'created_at' => '2026-07-10 10:00:00',
                'updated_at' => now(),
            ]);
        }
    }
}
