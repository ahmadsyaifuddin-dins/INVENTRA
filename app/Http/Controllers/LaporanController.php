<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penempatan;
use App\Models\Ruangan;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use PDF; // Alias dari DOMPDF (Pastikan config/app.php sudah diatur jika perlu, atau use Barryvdh\DomPDF\Facade\Pdf;)

class LaporanController extends Controller
{
    /**
     * Halaman Menu Utama Laporan
     */
    public function index()
    {
        return view('laporan.index');
    }

    /**
     * 1: Laporan Barang Masuk (Filter Tanggal)
     */
    public function barang(Request $request)
    {
        // 1. Ambil Input Tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // 2. Query Data dengan Filter Tanggal (jika ada)
        $query = Barang::with('kategori');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        }

        // Action: Apakah hanya Filter (View HTML) atau Download (PDF)?
        if ($request->has('download_pdf')) {
            $barangs = $query->get(); // Ambil semua data tanpa paginasi untuk PDF

            // Generate PDF
            $pdf = FacadePdf::loadView('laporan.pdf.barang_pdf', [
                'barangs' => $barangs,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);

            return $pdf->download('Laporan_Barang_'.date('YmdHis').'.pdf');
        }

        // Tampilan Web (dengan Pagination)
        $barangs = $query->latest()->paginate(10)->withQueryString();

        return view('laporan.barang', compact('barangs', 'startDate', 'endDate'));
    }

    /**
     * LAPORAN 2: Distribusi Aset per Ruangan (Kartu Inventaris Ruangan / KIR)
     */
    public function distribusi(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $ruanganId = $request->input('ruangan_id');

        // Query Dasar ke Tabel Penempatan
        $query = Penempatan::with(['barang', 'ruangan']);

        // Filter Tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        }

        // Filter Ruangan (Opsional)
        $namaRuangan = 'Semua Ruangan';
        if ($ruanganId) {
            $query->where('ruangan_id', $ruanganId);
            $ruangan = Ruangan::find($ruanganId);
            $namaRuangan = $ruangan->nama_ruangan;
        }

        // --- LOGIK DOWNLOAD PDF ---
        if ($request->has('download_pdf')) {
            $data = $query->get();

            $pdf = FacadePdf::loadView('laporan.pdf.distribusi_pdf', [
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'namaRuangan' => $namaRuangan,
            ]);

            // Set Paper Landscape agar muat banyak kolom
            return $pdf->setPaper('a4', 'landscape')->download('Laporan_Distribusi_'.date('YmdHis').'.pdf');
        }

        // --- TAMPILAN WEB ---
        $distribusi = $query->latest()->paginate(10)->withQueryString();
        $ruangans = Ruangan::all(); // Untuk dropdown filter

        return view('laporan.distribusi', compact('distribusi', 'ruangans', 'startDate', 'endDate', 'ruanganId'));
    }

    /**
     * LAPORAN 3: Kondisi Aset (Baik / Rusak)
     */
    public function kondisi(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kondisi = $request->input('kondisi'); // Baik, Rusak Ringan, Rusak Berat

        $query = Penempatan::with(['barang', 'ruangan']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        }

        if ($kondisi) {
            $query->where('kondisi', $kondisi);
        }

        // --- LOGIK DOWNLOAD PDF ---
        if ($request->has('download_pdf')) {
            $data = $query->get();

            $pdf = FacadePdf::loadView('laporan.pdf.kondisi_pdf', [
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'kondisi' => $kondisi ?? 'Semua Kondisi',
            ]);

            return $pdf->download('Laporan_Kondisi_'.date('YmdHis').'.pdf');
        }

        // --- TAMPILAN WEB ---
        $dataKondisi = $query->latest()->paginate(10)->withQueryString();

        return view('laporan.kondisi', compact('dataKondisi', 'startDate', 'endDate', 'kondisi'));
    }

    /**
     * LAPORAN 4: Riwayat Mutasi / Transaksi (Wajib Filter Tanggal)
     */
    public function mutasi(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query Riwayat (Urutkan dari yang terbaru atau terlama)
        $query = Penempatan::with(['barang', 'ruangan'])->orderBy('created_at', 'desc');

        // Filter Tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        }

        // --- DOWNLOAD PDF ---
        if ($request->has('download_pdf')) {
            $data = $query->get();
            $pdf = FacadePdf::loadView('laporan.pdf.mutasi_pdf', [
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);

            return $pdf->download('Laporan_Mutasi_'.date('YmdHis').'.pdf');
        }

        // --- WEB VIEW ---
        $mutasi = $query->paginate(10)->withQueryString();

        return view('laporan.mutasi', compact('mutasi', 'startDate', 'endDate'));
    }

    /**
     * LAPORAN 5: Aset per Kategori
     */
    public function perKategori(Request $request)
    {
        $kategoriId = $request->input('kategori_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Barang::with('kategori');

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        }

        // --- DOWNLOAD PDF ---
        if ($request->has('download_pdf')) {
            $data = $query->get();
            // Ambil nama kategori untuk judul
            $namaKategori = $kategoriId ? Kategori::find($kategoriId)->nama_kategori : 'Semua Kategori';

            $pdf = FacadePdf::loadView('laporan.pdf.per_kategori_pdf', [
                'data' => $data,
                'namaKategori' => $namaKategori,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);

            return $pdf->download('Laporan_Kategori_'.date('YmdHis').'.pdf');
        }

        // --- WEB VIEW ---
        $barangs = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::all(); // Untuk dropdown

        return view('laporan.per_kategori', compact('barangs', 'kategoris', 'kategoriId', 'startDate', 'endDate'));
    }
}
