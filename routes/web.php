<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenempatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Grup Route yang butuh Login
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User
    Route::resource('users', UserController::class);

    // Master Data (Resource otomatis bikin route index, create, store, edit, update, destroy)
    Route::resource('kategori', KategoriController::class);
    Route::resource('ruangan', RuanganController::class);
    Route::resource('barang', BarangController::class);

    // Transaksi
    Route::resource('penempatan', PenempatanController::class);

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/barang', [LaporanController::class, 'barang'])->name('laporan.barang');
    Route::get('laporan/barang/pdf', [LaporanController::class, 'barangPdf'])->name('laporan.barang.pdf');
    Route::get('laporan/distribusi', [LaporanController::class, 'distribusi'])->name('laporan.distribusi');
    Route::get('laporan/distribusi/pdf', [LaporanController::class, 'distribusiPdf'])->name('laporan.distribusi.pdf');
    Route::get('laporan/kondisi', [LaporanController::class, 'kondisi'])->name('laporan.kondisi');
    Route::get('laporan/kondisi/pdf', [LaporanController::class, 'kondisiPdf'])->name('laporan.kondisi.pdf');
    Route::get('laporan/mutasi', [LaporanController::class, 'mutasi'])->name('laporan.mutasi');
    Route::get('laporan/mutasi/pdf', [LaporanController::class, 'mutasiPdf'])->name('laporan.mutasi.pdf');
    Route::get('laporan/per_kategori', [LaporanController::class, 'perKategori'])->name('laporan.per_kategori');
    Route::get('laporan/per_kategori/pdf', [LaporanController::class, 'perKategoriPdf'])->name('laporan.per_kategori.pdf');

    // Profile Bawaan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
