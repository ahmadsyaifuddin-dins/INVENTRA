<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penempatan;
use App\Models\Ruangan;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Jenis Barang
        $totalJenisBarang = Barang::count();

        // 2. Hitung Total Ruangan
        $totalRuangan = Ruangan::count();

        // 3. Hitung Total Aset Fisik (Jumlah barang yang tersebar)
        $totalAsetFisik = Penempatan::sum('jumlah');

        // 4. Hitung Barang Rusak Berat (Untuk warning)
        $barangRusak = Penempatan::where('kondisi', 'Rusak Berat')->sum('jumlah');

        return view('dashboard', compact(
            'totalJenisBarang',
            'totalRuangan',
            'totalAsetFisik',
            'barangRusak'
        ));
    }
}
