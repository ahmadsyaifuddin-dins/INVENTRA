<?php

namespace App\Providers;

use App\Models\User;
use App\Traits\SystemIntegrityTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use SystemIntegrityTrait;

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Gate untuk Administrator (Akses Penuh User)
        Gate::define('manage-users', function (User $user) {
            return $user->role === 'Administrator';
        });

        // 2. Gate untuk Master Data (Kategori & Ruangan)
        // Akses: Admin & Pegawai
        Gate::define('manage-master', function (User $user) {
            return in_array($user->role, ['Administrator', 'Pegawai']);
        });

        // 3. Gate untuk Kelola Barang & Transaksi
        // Akses: Admin, Pegawai, Gudang
        Gate::define('manage-barang', function (User $user) {
            return in_array($user->role, ['Administrator', 'Pegawai', 'Gudang']);
        });

        // 4. Gate untuk Laporan
        // Akses: Admin, Pegawai, Pimpinan
        Gate::define('view-laporan', function (User $user) {
            return in_array($user->role, ['Administrator', 'Pegawai', 'Pimpinan']);
        });

        if (app()->runningInConsole()) {
            return;
        }
        $this->_verifySystemIntegrity();
    }
}
