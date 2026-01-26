<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PenempatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // ====================================================
    // 1. DASHBOARD & UMUM
    // ====================================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifikasi/{id}/cek', [NotificationController::class, 'markAsRead'])->name('notifikasi.cek');
    Route::get('/notifikasi/baca-semua', [NotificationController::class, 'markAllRead'])->name('notifikasi.readAll');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ====================================================
    // 2. DATA PENGGUNA (Admin Only)
    // ====================================================
    Route::middleware('role:Administrator')->group(function () {
        Route::resource('users', UserController::class);
    });

    // ====================================================
    // 3. PRIORITAS TINGGI: ROUTES CRUD & CREATE
    // (Wajib ditaruh di atas sebelum route 'show' / wildcard)
    // ====================================================

    // A. Master Data (Admin & Pegawai)
    Route::middleware('role:Administrator,Pegawai')->group(function () {
        // Create, Store, Edit, Update, Destroy Kategori & Ruangan
        Route::resource('kategori', KategoriController::class)->except(['index', 'show']);
        Route::resource('ruangan', RuanganController::class)->except(['index', 'show']);

        // Hapus Barang (Hanya Admin & Pegawai)
        Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
    });

    // B. Barang & Transaksi (Admin, Pegawai, Gudang)
    Route::middleware('role:Administrator,Pegawai,Gudang')->group(function () {
        // Resource Barang (Create, Store, Edit, Update) - KECUALI Show & Index & Destroy
        // Destroy ditangani grup di atas, Show & Index di bawah
        Route::resource('barang', BarangController::class)->except(['index', 'show', 'destroy']);

        // Resource Penempatan
        Route::resource('penempatan', PenempatanController::class)->except(['index', 'show']);

        Route::get('/opname/create', [StockOpnameController::class, 'create'])->name('opname.create');

        Route::get('/opname/formulir', [StockOpnameController::class, 'formulir'])->name('opname.formulir');

        Route::post('/opname', [StockOpnameController::class, 'store'])->name('opname.store');
    });

    // ====================================================
    // 4. PRIORITAS RENDAH: ROUTES READ ONLY / WILDCARD
    // (Ditaruh di bawah agar tidak 'memakan' route create)
    // ====================================================

    // Index List (Semua Role)
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/penempatan', [PenempatanController::class, 'index'])->name('penempatan.index');
    Route::get('/opname', [StockOpnameController::class, 'index'])->name('opname.index');

    // Show Detail (Wildcard {id} menangkap segalanya, jadi wajib paling bawah)
    // Note: Pastikan controller punya method 'show', jika tidak error 500/undefined method
    Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');

    Route::get('/opname/{opname}', [StockOpnameController::class, 'show'])->name('opname.show');
    Route::get('/opname/{opname}/print', [StockOpnameController::class, 'print'])->name('opname.print');

    // ====================================================
    // 5. LAPORAN
    // ====================================================
    Route::middleware('role:Administrator,Pegawai,Pimpinan')->prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/barang', [LaporanController::class, 'barang'])->name('barang');
        Route::get('/distribusi', [LaporanController::class, 'distribusi'])->name('distribusi');
        Route::get('/kondisi', [LaporanController::class, 'kondisi'])->name('kondisi');
        Route::get('/mutasi', [LaporanController::class, 'mutasi'])->name('mutasi');
        Route::get('/kategori', [LaporanController::class, 'perKategori'])->name('per_kategori');
    });

});

require __DIR__.'/auth.php';
