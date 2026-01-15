<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Tampilkan daftar kategori.
     */
    public function index()
    {
        $kategoris = Kategori::withCount('barangs') // Tetap pakai withCount
            ->filter(request()->all())      // Tambah filter
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        $kategori = new Kategori; // Object kosong untuk _form

        return view('kategori.create', compact('kategori'));
    }

    /**
     * Simpan data.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:10|unique:kategori,kode_kategori',
            'nama_kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Form edit kategori.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:10|unique:kategori,kode_kategori,'.$kategori->id,
            'nama_kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')
            ->with('success', 'Data kategori berhasil diperbarui!');
    }

    /**
     * Hapus data.
     */
    public function destroy(Kategori $kategori)
    {
        // Cek apakah kategori ini punya barang? Kalau ada sebaiknya jangan dihapus (Opsional)
        if ($kategori->barangs()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Masih ada barang yang menggunakan kategori ini.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
