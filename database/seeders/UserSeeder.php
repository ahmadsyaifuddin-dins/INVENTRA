<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Administrator
        DB::table('pengguna')->insert([
            'username' => 'admin',
            'nama_lengkap' => 'Administrator Sistem',
            'password' => Hash::make('password'), // Password default: password
            'role' => 'Administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Akun Pegawai (Tata Usaha)
        DB::table('pengguna')->insert([
            'username' => 'pegawai',
            'nama_lengkap' => 'Haliza',
            'password' => Hash::make('password'),
            'role' => 'Pegawai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Akun Gudang (Lapangan)
        DB::table('pengguna')->insert([
            'username' => 'gudang',
            'nama_lengkap' => 'Petugas Gudang',
            'password' => Hash::make('password'),
            'role' => 'Gudang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Akun Pimpinan (Kajari/Kasi)
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
