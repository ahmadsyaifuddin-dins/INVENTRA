<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengguna')->insert([
            'username' => 'admin',
            'email' => 'lizainventra@gmail.com',
            'nama_lengkap' => 'Administrator Sistem',
            'password' => Hash::make('password'),
            'role' => 'Administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // KITA BUAT 10 PEGAWAI AGAR LAPORAN STATISTIK PENUH
        $pegawais = [
            ['username' => 'haliza', 'nama' => 'Haliza Sabila Halim'],
            ['username' => 'udin', 'nama' => 'Syaifuddin'],
            ['username' => 'budi', 'nama' => 'Budi Santoso'],
            ['username' => 'citra', 'nama' => 'Citra Kirana'],
            ['username' => 'dewi', 'nama' => 'Dewi Lestari'],
            ['username' => 'eko', 'nama' => 'Eko Prasetyo'],
            ['username' => 'fajar', 'nama' => 'Fajar Nugraha'],
            ['username' => 'gina', 'nama' => 'Gina Sonia'],
            ['username' => 'hendra', 'nama' => 'Hendra Setiawan'],
            ['username' => 'intan', 'nama' => 'Intan Permata'],
        ];

        foreach ($pegawais as $p) {
            DB::table('pengguna')->insert([
                'username' => $p['username'],
                'nama_lengkap' => $p['nama'],
                'password' => Hash::make('password'),
                'role' => 'Pegawai',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('pengguna')->insert([
            'username' => 'gudang',
            'nama_lengkap' => 'Petugas Gudang',
            'password' => Hash::make('password'),
            'role' => 'Gudang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pengguna')->insert([
            'username' => 'pimpinan',
            'nama_lengkap' => 'Kepala Kejaksaan',
            'password' => Hash::make('password'),
            'role' => 'Pimpinan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
