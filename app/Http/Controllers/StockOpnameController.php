<?php

namespace App\Http\Controllers;

use App\Models\Penempatan;
use App\Models\Ruangan;
use App\Models\StockOpname;
use App\Models\StockOpnameDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    // 1. Halaman Utama (Riwayat Opname)
    public function index()
    {
        $opnames = StockOpname::with(['ruangan', 'user'])->latest()->paginate(10);

        return view('opname.index', compact('opnames'));
    }

    // 2. Langkah 1: Pilih Ruangan
    public function create()
    {
        $ruangans = Ruangan::all();

        return view('opname.create', compact('ruangans'));
    }

    // 3. Langkah 2: Form Ceklis (Worksheet)
    public function formulir(Request $request)
    {
        $request->validate(['ruangan_id' => 'required', 'tanggal' => 'required']);

        $ruangan = Ruangan::findOrFail($request->ruangan_id);
        $tanggal = $request->tanggal;

        // Ambil data barang yang ada di ruangan tersebut menurut Sistem
        $dataBarang = Penempatan::with('barang')
            ->where('ruangan_id', $ruangan->id)
            ->get();

        return view('opname.form', compact('ruangan', 'tanggal', 'dataBarang'));
    }

    // 4. Simpan Hasil Opname
    public function store(Request $request)
    {
        // Simpan Header
        $opname = StockOpname::create([
            'tanggal_opname' => $request->tanggal,
            'ruangan_id' => $request->ruangan_id,
            'user_id' => auth()->id(),
            'catatan' => $request->catatan_umum,
        ]);

        // Simpan Detail per Barang
        if ($request->details) {
            foreach ($request->details as $barang_id => $detail) {
                StockOpnameDetail::create([
                    'stock_opname_id' => $opname->id,
                    'barang_id' => $barang_id,
                    'jumlah_sistem' => $detail['jumlah_sistem'],
                    'jumlah_fisik' => $detail['jumlah_fisik'],
                    'status_fisik' => $detail['status'],
                    'keterangan' => $detail['ket'] ?? null,
                ]);
            }
        }

        return redirect()->route('opname.index')->with('success', 'Stock Opname berhasil disimpan!');
    }

    // 5. Lihat Detail Hasil
    public function show(StockOpname $opname)
    {
        $opname->load(['details.barang', 'ruangan', 'user']);

        return view('opname.show', compact('opname'));
    }

    // 6. Cetak PDF Laporan
    public function print(StockOpname $opname)
    {
        $opname->load(['details.barang', 'ruangan', 'user']);
        $pdf = Pdf::loadView('opname.print_pdf', compact('opname'));

        return $pdf->download('Berita_Acara_Opname_'.$opname->id.'.pdf');
    }
}
