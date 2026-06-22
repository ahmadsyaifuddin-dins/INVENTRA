<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Penempatan;
use App\Models\Ruangan; // Tambahan Model Baru
use App\Models\StockOpnameDetail;
// Tambahan Model Baru
use App\Models\User; // Tambahan Model Baru (Sesuaikan jika nama model di projekmu berbeda, misal: Opname)
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Barang::with('kategori');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        }

        if ($request->has('download_pdf')) {
            $barangs = $query->get();

            $pdf = FacadePdf::loadView('laporan.pdf.barang_pdf', [
                'barangs' => $barangs,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);

            return $pdf->download('Laporan_Barang_'.date('YmdHis').'.pdf');
        }

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

        $query = Penempatan::with(['barang', 'ruangan']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        }

        $namaRuangan = 'Semua Ruangan';
        if ($ruanganId) {
            $query->where('ruangan_id', $ruanganId);
            $ruangan = Ruangan::find($ruanganId);
            $namaRuangan = $ruangan->nama_ruangan;
        }

        if ($request->has('download_pdf')) {
            $data = $query->get();

            $pdf = FacadePdf::loadView('laporan.pdf.distribusi_pdf', [
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'namaRuangan' => $namaRuangan,
            ]);

            return $pdf->setPaper('a4', 'landscape')->download('Laporan_Distribusi_'.date('YmdHis').'.pdf');
        }

        $distribusi = $query->latest()->paginate(10)->withQueryString();
        $ruangans = Ruangan::all();

        return view('laporan.distribusi', compact('distribusi', 'ruangans', 'startDate', 'endDate', 'ruanganId'));
    }

    /**
     * LAPORAN 3: Kondisi Aset (Baik / Rusak)
     */
    public function kondisi(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kondisi = $request->input('kondisi');

        $query = Penempatan::with(['barang', 'ruangan']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        }

        if ($kondisi) {
            $query->where('kondisi', $kondisi);
        }

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

        $query = Penempatan::with(['barang', 'ruangan'])->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
        }

        if ($request->has('download_pdf')) {
            $data = $query->get();
            $pdf = FacadePdf::loadView('laporan.pdf.mutasi_pdf', [
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);

            return $pdf->download('Laporan_Mutasi_'.date('YmdHis').'.pdf');
        }

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

        if ($request->has('download_pdf')) {
            $data = $query->get();
            $namaKategori = $kategoriId ? Kategori::find($kategoriId)->nama_kategori : 'Semua Kategori';

            $pdf = FacadePdf::loadView('laporan.pdf.per_kategori_pdf', [
                'data' => $data,
                'namaKategori' => $namaKategori,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);

            return $pdf->download('Laporan_Kategori_'.date('YmdHis').'.pdf');
        }

        $barangs = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::all();

        return view('laporan.per_kategori', compact('barangs', 'kategoris', 'kategoriId', 'startDate', 'endDate'));
    }

    /* =========================================================================
     * LAUNCHING FITUR BARU: LAPORAN 6, 7, 8, DAN 9 (DENGAN REKAPITULASI DATA BARU)
     * ========================================================================= */

    /**
     * LAPORAN 6: Peminjaman Aktif & Keterlambatan
     * Memonitor aset bergerak yang sedang di luar dan melacak sisa waktu/durasi telat.
     */
    public function peminjaman(Request $request)
    {
        $statusFilter = $request->input('status'); // Pilihan: Dipinjam, Terlambat, atau Kosong (Semua Aktif)

        $query = Peminjaman::with(['barang', 'user']);

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        } else {
            // Default hanya memunculkan aset yang belum kembali ke gudang
            $query->whereIn('status', ['Dipinjam', 'Terlambat']);
        }

        if ($request->has('download_pdf')) {
            $data = $query->get();
            $pdf = FacadePdf::loadView('laporan.pdf.peminjaman_pdf', [
                'data' => $data,
                'statusFilter' => $statusFilter ?? 'Semua Peminjaman Aktif',
            ]);

            return $pdf->download('Laporan_Peminjaman_Aktif_'.date('YmdHis').'.pdf');
        }

        $peminjamans = $query->paginate(10)->withQueryString();

        return view('laporan.peminjaman', compact('peminjamans', 'statusFilter'));
    }

    /**
     * LAPORAN 7: Rekapitulasi Riwayat Per Pegawai (Rapor Kepatuhan Peminjam)
     * Mengompilasi data statistik per orang untuk memantau performa peminjaman.
     */
    public function perPegawai(Request $request)
    {
        $userId = $request->input('user_id');

        // Mengambil user dengan role Pegawai beserta agregasi hitungan kustom langsung dari Query DB
        $query = User::where('role', 'Pegawai')
            ->withCount([
                'peminjamans as total_pinjam',
                'peminjamans as total_selesai' => function ($q) {
                    $q->where('status', 'Dikembalikan');
                },
                'peminjamans as total_telat' => function ($q) {
                    $q->where('status', 'Terlambat');
                },
            ]);

        if ($userId) {
            $query->where('id', $userId);
        }

        if ($request->has('download_pdf')) {
            $data = $query->get();
            $pdf = FacadePdf::loadView('laporan.pdf.per_pegawai_pdf', [
                'data' => $data,
            ]);

            return $pdf->download('Laporan_Statistik_Pegawai_'.date('YmdHis').'.pdf');
        }

        $pegawais = $query->paginate(10)->withQueryString();
        $listPegawai = User::where('role', 'Pegawai')->get(); // Untuk dropdown filter

        return view('laporan.per_pegawai', compact('pegawais', 'listPegawai', 'userId'));
    }

    /**
     * LAPORAN 8: Prediksi Jadwal Maintenance & Batas Penyusutan
     * Mencari data perkiraan pemeliharaan berkala atau masa habis penyusutan berdasarkan bulan berjalan.
     */
    public function maintenance(Request $request)
    {
        $jenis = $request->input('jenis'); // 'Servis' atau 'Penyusutan'
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $query = Barang::with('kategori');

        // Filter dinamis berdasarkan jenis estimasi agenda
        if ($jenis === 'Servis') {
            $query->whereMonth('tgl_servis_berikutnya', $bulan)->whereYear('tgl_servis_berikutnya', $tahun);
        } elseif ($jenis === 'Penyusutan') {
            $query->whereMonth('tgl_penyusutan_habis', $bulan)->whereYear('tgl_penyusutan_habis', $tahun);
        } else {
            // Jika kosong, tampilkan berkas gabungan yang tgl servis ATAU susutnya jatuh pada bulan terpilih
            $query->where(function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tgl_servis_berikutnya', $bulan)->whereYear('tgl_servis_berikutnya', $tahun)
                    ->orWhereMonth('tgl_penyusutan_habis', $bulan)->whereYear('tgl_penyusutan_habis', $tahun);
            });
        }

        if ($request->has('download_pdf')) {
            $data = $query->get();
            $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

            $pdf = FacadePdf::loadView('laporan.pdf.maintenance_pdf', [
                'data' => $data,
                'jenis' => $jenis ?? 'Gabungan (Servis & Penyusutan)',
                'bulan' => $namaBulan,
                'tahun' => $tahun,
            ]);

            return $pdf->download('Laporan_Agenda_Aset_'.date('YmdHis').'.pdf');
        }

        $barangs = $query->paginate(10)->withQueryString();

        return view('laporan.maintenance', compact('barangs', 'jenis', 'bulan', 'tahun'));
    }

    /**
     * LAPORAN 9: Hasil Audit & Ringkasan Stok Opname
     * Menampilkan rangkuman audit inventaris fisik untuk melihat selisih berkas barang rusak/hilang.
     */
    public function audit(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // UBAH: Gunakan StockOpnameDetail agar stok_sistem & stok_fisik terbaca
        $query = \App\Models\StockOpnameDetail::with(['barang', 'opname']);

        if ($startDate && $endDate) {
            // Karena kita pakai model detail, filter tanggalnya harus tembus ke relasi opname (induk)
            $query->whereHas('opname', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
            });
        }

        if ($request->has('download_pdf')) {
            $data = $query->get();
            $pdf = FacadePdf::loadView('laporan.pdf.audit_pdf', [
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);

            return $pdf->download('Laporan_Hasil_Audit_Opname_'.date('YmdHis').'.pdf');
        }

        $audits = $query->latest()->paginate(10)->withQueryString();

        return view('laporan.audit', compact('audits', 'startDate', 'endDate'));
    }
}
