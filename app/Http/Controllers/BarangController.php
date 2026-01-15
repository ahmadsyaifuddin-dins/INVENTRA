<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use App\Notifications\BarangMasukNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

class BarangController extends Controller
{
    public function index()
    {
        // Filterable Trait akan menangani semua request('search'), request('sort'), dll
        $barangs = Barang::with('kategori')
            ->filter(request()->all())
            ->paginate(10)
            ->withQueryString();

        // Kita butuh list kategori buat Filter Dropdown
        $kategoris = Kategori::all();

        return view('barang.index', compact('barangs', 'kategoris'));
    }

    public function create()
    {
        // Ambil list kategori buat dropdown (id => nama_kategori)
        $kategoris = Kategori::pluck('nama_kategori', 'id');
        $barang = new Barang;

        return view('barang.create', compact('barang', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|unique:barang,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategori,id',
            'merek' => 'nullable|string|max:50',
            'tahun_perolehan' => 'required|digits:4|integer|min:2000|max:'.(date('Y') + 1),
            'satuan' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // LOGIC UPLOAD FOTO (Public Folder)
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/barang'), $filename);
            $data['foto'] = $filename;
        }

        Barang::create($data);
        $barangBaru = Barang::where('kode_barang', $request->kode_barang)->first();

        // Ambil semua user Pimpinan
        $pimpimans = User::where('role', 'Pimpinan')->get();

        // Kirim Notifikasi
        Notification::send($pimpimans, new BarangMasukNotification($barangBaru, auth()->user()));

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan dan Notifikasi dikirim ke Pimpinan!');
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::pluck('nama_kategori', 'id');

        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang' => 'required|string|unique:barang,kode_barang,'.$barang->id,
            'nama_barang' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategori,id',
            'merek' => 'nullable|string|max:50',
            'tahun_perolehan' => 'required|digits:4',
            'satuan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        // LOGIC GANTI FOTO
        if ($request->hasFile('foto')) {
            // 1. Hapus foto lama jika ada
            if ($barang->foto && File::exists(public_path('uploads/barang/'.$barang->foto))) {
                File::delete(public_path('uploads/barang/'.$barang->foto));
            }

            // 2. Upload foto baru
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/barang'), $filename);
            $data['foto'] = $filename;
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        // Hapus file fisik foto sebelum hapus data
        if ($barang->foto && File::exists(public_path('uploads/barang/'.$barang->foto))) {
            File::delete(public_path('uploads/barang/'.$barang->foto));
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
