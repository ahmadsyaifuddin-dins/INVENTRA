<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    public function index()
    {
        $subkategoris = SubKategori::with('kategori')->latest()->paginate(10);

        return view('subkategori.index', compact('subkategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::pluck('nama_kategori', 'id');
        $subkategori = new SubKategori;

        return view('subkategori.create', compact('subkategori', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'kode_sub' => 'required|string|max:10',
            'nama_sub' => 'required|string|max:255',
        ]);

        SubKategori::create($request->all());

        return redirect()->route('subkategori.index')->with('success', 'Sub Kategori berhasil ditambahkan.');
    }

    public function edit(SubKategori $subkategori)
    {
        $kategoris = Kategori::pluck('nama_kategori', 'id');

        return view('subkategori.edit', compact('subkategori', 'kategoris'));
    }

    public function update(Request $request, SubKategori $subkategori)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'kode_sub' => 'required|string|max:10',
            'nama_sub' => 'required|string|max:255',
        ]);

        $subkategori->update($request->all());

        return redirect()->route('subkategori.index')->with('success', 'Sub Kategori berhasil diperbarui.');
    }

    public function destroy(SubKategori $subkategori)
    {
        $subkategori->delete();

        return redirect()->route('subkategori.index')->with('success', 'Sub Kategori berhasil dihapus.');
    }
}
