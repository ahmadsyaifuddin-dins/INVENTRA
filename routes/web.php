<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PenempatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Halaman Depan (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// GROUP UTAMA: Harus Login & Email Terverifikasi
Route::middleware(['auth', 'verified'])->group(function () {

    // ====================================================
    // 1. AKSES UMUM (BISA DIAKSES PEGAWAI & PIMPINAN)
    // ====================================================

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Notifikasi (Tandai sudah dibaca)
    Route::get('/notifikasi/{id}/cek', [NotificationController::class, 'markAsRead'])->name('notifikasi.cek');
    Route::get('/notifikasi/baca-semua', [NotificationController::class, 'markAllRead'])->name('notifikasi.readAll');

    // Profile Bawaan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pusat Laporan
    // (Pimpinan WAJIB bisa akses ini, PDF digabung di logic controller pakai ?download_pdf=1)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/barang', [LaporanController::class, 'barang'])->name('barang');
        Route::get('/distribusi', [LaporanController::class, 'distribusi'])->name('distribusi');
        Route::get('/kondisi', [LaporanController::class, 'kondisi'])->name('kondisi');
        Route::get('/mutasi', [LaporanController::class, 'mutasi'])->name('mutasi');
        Route::get('/kategori', [LaporanController::class, 'perKategori'])->name('per_kategori');
    });

    // Read-Only Access (Hanya Lihat Tabel Index)
    // Pimpinan perlu lihat data master, tapi tidak boleh edit.
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('/penempatan', [PenempatanController::class, 'index'])->name('penempatan.index');

    // ====================================================
    // 2. AKSES KHUSUS (HANYA PEGAWAI)
    // Middleware 'role:Pegawai' menjaga route ini
    // ====================================================
    Route::middleware('role:Pegawai')->group(function () {

        // Manajemen User (Hanya Pegawai yang boleh kelola akun)
        Route::resource('users', UserController::class);

        // CRUD Master Data (Create, Store, Edit, Update, Destroy)
        // Kita gunakan except(['index']) karena 'index' sudah didefinisikan di atas (untuk umum)

        Route::resource('kategori', KategoriController::class)->except(['index', 'show']);
        Route::resource('ruangan', RuanganController::class)->except(['index', 'show']);
        Route::resource('barang', BarangController::class)->except(['index', 'show']);

        // CRUD Transaksi
        Route::resource('penempatan', PenempatanController::class)->except(['index', 'show']);
    });

});

require __DIR__.'/auth.php';
