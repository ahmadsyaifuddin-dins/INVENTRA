<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\SubKategori;
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
            'sub_kategori_id' => 'required|exists:sub_kategori,id',
            'merek' => 'nullable|string|max:50',
            'tahun_perolehan' => 'required|digits:4|integer|min:2000|max:'.(date('Y') + 1),
            'satuan' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tgl_penyusutan_habis' => 'nullable|date',
            'tgl_servis_berikutnya' => 'nullable|date',
        ]);

        $data = $request->all();

        // LOGIC UPLOAD FOTO (Public Folder)
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/barang'), $filename);
            $data['foto'] = $filename;
        }

        // Simpan Barang
        $barang = Barang::create($data); // Langsung tampung ke variabel $barang

        // TARGET NOTIFIKASI: Administrator, Pegawai, Pimpinan
        $recipients = User::whereIn('role', ['Administrator', 'Pegawai', 'Pimpinan'])->get();

        // Kirim Notifikasi (Email & Database)
        // Pastikan user penerima punya email yang valid di database!
        Notification::send($recipients, new BarangMasukNotification($barang, auth()->user()));

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan. Notifikasi email telah dikirim ke pihak terkait.');
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
            'sub_kategori_id' => 'required|exists:sub_kategori,id',
            'tahun_perolehan' => 'required|digits:4',
            'satuan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tgl_penyusutan_habis' => 'nullable|date',
            'tgl_servis_berikutnya' => 'nullable|date',
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

    public function show(Barang $barang)
    {
        // Pastikan view-nya nanti bernama 'barang.show'
        return view('barang.show', compact('barang'));
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

    public function sendManualReminder(Barang $barang)
    {
        $admins = User::where('role', 'Administrator')->whereNotNull('no_wa')->get();

        if ($admins->isEmpty()) {
            return back()->with('error', 'Gagal! Tidak ada Administrator yang memiliki nomor WA.');
        }

        // 1. Cek status urgensi (Apakah ini Servis atau Penyusutan?)
        $now = now()->startOfDay();
        $servis = $barang->tgl_servis_berikutnya ? \Carbon\Carbon::parse($barang->tgl_servis_berikutnya)->startOfDay() : null;
        $susut = $barang->tgl_penyusutan_habis ? \Carbon\Carbon::parse($barang->tgl_penyusutan_habis)->startOfDay() : null;

        $isServis = $servis && $servis->greaterThanOrEqualTo($now) && $now->diffInDays($servis) <= 7;
        $isSusut = $susut && $susut->greaterThanOrEqualTo($now) && $now->diffInDays($susut) <= 7;

        // Bikin kalimat alasan
        $alasan = [];
        if ($isServis) {
            $alasan[] = '🛠️ *Jadwal Servis Berkala* ('.$servis->format('d M Y').')';
        }
        if ($isSusut) {
            $alasan[] = '📉 *Batas Masa Penyusutan* ('.$susut->format('d M Y').')';
        }
        $teksAlasan = implode(' dan ', $alasan);

        // Jika diklik manual tapi ternyata bukan H-7 (Mungkin admin iseng pencet)
        if (empty($alasan)) {
            $teksAlasan = 'Pengecekan / Tindak Lanjut Umum';
        }

        $token = env('FONNTE_TOKEN');
        $berhasil = 0;

        foreach ($admins as $admin) {
            // 2. Rangkai pesan di DALAM loop agar nama penerima dinamis
            $pesan = "*[PENGINGAT SISTEM INVENTRA]*\n\n";
            $pesan .= "Halo, *{$admin->nama_lengkap}* 👋\n";
            $pesan .= "Sistem mendeteksi bahwa aset berikut memerlukan perhatian Anda karena mendekati $teksAlasan:\n\n";

            $pesan .= "📦 *Nama Aset:* {$barang->nama_barang}\n";
            $pesan .= "🔢 *Kode Aset:* {$barang->kode_barang}\n";
            $pesan .= '🏷️ *Kategori:* '.($barang->kategori->nama_kategori ?? '-')."\n\n";

            $pesan .= "💡 *Tindak Lanjut yang Disarankan:*\n";
            if ($isServis) {
                $pesan .= "✔️ Segera jadwalkan pemeliharaan/servis dengan teknisi agar kondisi aset tetap prima.\n";
            }
            if ($isSusut) {
                $pesan .= "✔️ Lakukan cek fisik (Stok Opname) untuk menilai kelayakan aset untuk dihapuskan atau diperpanjang.\n";
            }
            if (empty($alasan)) {
                $pesan .= "✔️ Mohon segera cek detail kondisi aset ini di aplikasi.\n";
            }

            $pesan .= "\n_Pesan ini dikirim secara manual via Aplikasi INVENTRA._";

            // 3. Tembak ke Fonnte
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $admin->no_wa,
                'message' => $pesan,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                $berhasil++;
            }
        }

        return back()->with('success', "Pengingat WA manual berhasil dikirim ke $berhasil Administrator.");
    }

    // =========================================================================
    // FITUR AJAX: OTOMATISASI KODE BARANG
    // =========================================================================

    public function getSubKategori(Request $request)
    {
        $kategoriId = $request->kategori_id;
        $subKategoris = SubKategori::where('kategori_id', $kategoriId)->get();

        return response()->json($subKategoris);
    }

    public function generateKodeAjax(Request $request)
    {
        $kategoriId = $request->kategori_id;
        $subKategoriId = $request->sub_kategori_id;
        $tahun = $request->tahun;

        if (! $kategoriId || ! $subKategoriId || ! $tahun) {
            return response()->json(['kode' => '']);
        }

        $kategori = Kategori::find($kategoriId);
        $subKategori = SubKategori::find($subKategoriId);

        // Ambil kode dari tabel, jika kosong fallback ke 3 huruf pertama kategori
        $kodeKat = $kategori->kode_kategori ?? strtoupper(substr($kategori->nama_kategori, 0, 3));
        $kodeSub = $subKategori->kode_sub ?? '00';

        // 1. Buat prefix dasar pencarian (Contoh: ELK.02.2026)
        $prefix = "{$kodeKat}.{$kodeSub}.{$tahun}";

        // 2. CARI AMAN: Ambil kode_barang terakhir di database yang memiliki awalan prefix tsb
        $barangTerakhir = Barang::where('kode_barang', 'like', "{$prefix}.%")
            ->orderByRaw('LENGTH(kode_barang) DESC') // Jaga-jaga kalau urutan tembus > 99 (jadi 3 digit)
            ->orderBy('kode_barang', 'desc')
            ->first();

        if ($barangTerakhir) {
            // Pecah kode "ELK.02.2026.02" berdasarkan titik
            $parts = explode('.', $barangTerakhir->kode_barang);

            // Ambil bagian urutan (Index ke-3) lalu jadikan angka (integer)
            $urutanTerakhir = isset($parts[3]) ? (int) $parts[3] : 0;
            $urutanBaru = $urutanTerakhir + 1;
        } else {
            // Jika belum ada barang sama sekali dengan prefix tersebut
            $urutanBaru = 1;
        }

        // 3. Format urutan kembali jadi minimal 2 digit (1 -> 01, 12 -> 12)
        $urutan = str_pad($urutanBaru, 2, '0', STR_PAD_LEFT);

        // Gabungkan jadi kode final sesuai format baru
        $kode = "{$prefix}.{$urutan}";

        return response()->json(['kode' => $kode]);
    }
}
