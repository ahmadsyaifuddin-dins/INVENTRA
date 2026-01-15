<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pegawai (Admin)
        DB::table('pengguna')->insert([
            'username' => 'pegawai',
            'password' => Hash::make('password'),
            'nama_lengkap' => 'Liza Anak Magang',
            'role' => 'Pegawai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Akun Pimpinan (Kasubag Pembinaan)
        DB::table('pengguna')->insert([
            'username' => 'pimpinan',
            'password' => Hash::make('password'),
            'nama_lengkap' => 'Bapak Kasubag',
            'role' => 'Pimpinan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
