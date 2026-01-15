<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penempatan;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class PenempatanController extends Controller
{
    /**
     * Tampilkan riwayat distribusi.
     */
    public function index()
    {
        // Eager loading barang & ruangan biar query cepat
        $penempatans = Penempatan::with(['barang', 'ruangan'])->latest()->paginate(10);

        return view('penempatan.index', compact('penempatans'));
    }

    /**
     * Form distribusi baru.
     */
    public function create()
    {
        // Siapkan data untuk Dropdown
        // Format: [id => "Kode - Nama Barang"]
        $barangs = Barang::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->kode_barang.' - '.$item->nama_barang];
        });

        $ruangans = Ruangan::pluck('nama_ruangan', 'id');

        $penempatan = new Penempatan;

        return view('penempatan.create', compact('penempatan', 'barangs', 'ruangans'));
    }

    /**
     * Simpan transaksi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        Penempatan::create($request->all());

        return redirect()->route('penempatan.index')
            ->with('success', 'Aset berhasil didistribusikan ke ruangan!');
    }

    /**
     * Form edit transaksi (Misal: Pindah ruangan atau update kondisi).
     */
    public function edit(Penempatan $penempatan)
    {
        $barangs = Barang::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->kode_barang.' - '.$item->nama_barang];
        });

        $ruangans = Ruangan::pluck('nama_ruangan', 'id');

        return view('penempatan.edit', compact('penempatan', 'barangs', 'ruangans'));
    }

    /**
     * Update transaksi.
     */
    public function update(Request $request, Penempatan $penempatan)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        $penempatan->update($request->all());

        return redirect()->route('penempatan.index')
            ->with('success', 'Data distribusi berhasil diperbarui!');
    }

    /**
     * Hapus / Batalkan distribusi.
     */
    public function destroy(Penempatan $penempatan)
    {
        $penempatan->delete();

        return redirect()->route('penempatan.index')
            ->with('success', 'Data distribusi berhasil dihapus (Aset ditarik kembali).');
    }
}
