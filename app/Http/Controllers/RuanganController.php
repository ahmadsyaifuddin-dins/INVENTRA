<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Tampilkan daftar ruangan.
     */
    public function index()
    {
        // Kita ambil data ruangan + hitung berapa kali ruangan ini dipakai di tabel penempatan
        // withCount('penempatans') akan otomatis membuat field 'penempatans_count'
        $ruangans = Ruangan::withCount('penempatans')->latest()->paginate(10);

        return view('ruangan.index', compact('ruangans'));
    }

    /**
     * Form tambah.
     */
    public function create()
    {
        $ruangan = new Ruangan; // Object kosong untuk _form

        return view('ruangan.create', compact('ruangan'));
    }

    /**
     * Simpan data.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:50',
            'penanggung_jawab' => 'required|string|max:100',
        ]);

        Ruangan::create($request->all());

        return redirect()->route('ruangan.index')
            ->with('success', 'Ruangan baru berhasil ditambahkan!');
    }

    /**
     * Form edit.
     */
    public function edit(Ruangan $ruangan)
    {
        return view('ruangan.edit', compact('ruangan'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:50',
            'penanggung_jawab' => 'required|string|max:100',
        ]);

        $ruangan->update($request->all());

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil diperbarui!');
    }

    /**
     * Hapus data.
     */
    public function destroy(Ruangan $ruangan)
    {
        // Cek apakah ruangan ini sedang dipakai menyimpan barang?
        if ($ruangan->penempatans()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Masih ada aset yang tersimpan di ruangan ini.');
        }

        $ruangan->delete();

        return redirect()->route('ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}
