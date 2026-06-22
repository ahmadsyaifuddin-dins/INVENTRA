<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Tampilkan daftar peminjaman.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['barang', 'user'])->latest();

        // Logika Role: Pegawai hanya melihat pengajuannya sendiri
        if (auth()->user()->role === 'Pegawai') {
            $query->where('user_id', auth()->id());
        }

        $peminjamans = $query->paginate(10)->withQueryString();

        return view('peminjaman.index', compact('peminjamans'));
    }

    /**
     * Tampilkan form pengajuan baru.
     */
    public function create()
    {
        $peminjaman = new Peminjaman;
        // Mengambil semua barang untuk dipilih
        $barangs = Barang::orderBy('nama_barang', 'asc')->get();

        return view('peminjaman.create', compact('peminjaman', 'barangs'));
    }

    /**
     * Simpan pengajuan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string',
        ]);

        // LOGIKA CEK BENTROK JADWAL
        $bentrok = Peminjaman::where('barang_id', $request->barang_id)
            ->whereIn('status', ['Menunggu ACC', 'Dipinjam'])
            ->where('tanggal_pinjam', '<=', $request->tanggal_kembali)
            ->where('tanggal_kembali', '>=', $request->tanggal_pinjam)
            ->exists();

        if ($bentrok) {
            return back()->withInput()->with('error', 'Gagal! Aset ini sudah dipesan atau dipinjam pada rentang tanggal tersebut. Silakan pilih tanggal/aset lain.');
        }

        Peminjaman::create([
            'barang_id' => $request->barang_id,
            'user_id' => auth()->id(),
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu ACC',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman berhasil dibuat dan menunggu persetujuan Administrator.');
    }

    /**
     * Tampilkan form edit/ACC.
     */
    public function edit(Peminjaman $peminjaman)
    {
        // Proteksi: Pegawai tidak boleh mengubah form jika status sudah diproses Admin
        if (auth()->user()->role === 'Pegawai' && $peminjaman->status !== 'Menunggu ACC') {
            return redirect()->route('peminjaman.index')->with('error', 'Data tidak dapat diubah karena sudah diproses oleh Administrator.');
        }

        $barangs = Barang::orderBy('nama_barang', 'asc')->get();

        // Menyiapkan opsi status untuk dropdown (murni teks)
        $statuses = [
            'Menunggu ACC' => 'Menunggu ACC',
            'Dipinjam' => 'Dipinjam',
            'Ditolak' => 'Ditolak',
            'Dikembalikan' => 'Dikembalikan',
            'Terlambat' => 'Terlambat',
        ];

        return view('peminjaman.edit', compact('peminjaman', 'barangs', 'statuses'));
    }

    /**
     * Update data / Proses ACC.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $rules = [
            'barang_id' => 'required|exists:barang,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string',
        ];

        if (auth()->user()->role === 'Administrator') {
            $rules['status'] = 'required|in:Menunggu ACC,Dipinjam,Ditolak,Dikembalikan,Terlambat';
            // Jika status mau diubah ke Dikembalikan, Wajib isi kondisi
            if ($request->status === 'Dikembalikan') {
                $rules['kondisi_kembali'] = 'required|in:Baik,Rusak Ringan,Rusak Berat';
            }
        }

        $request->validate($rules);

        // LOGIKA CEK BENTROK JADWAL (Abaikan data peminjaman yang sedang diedit ini)
        $bentrok = Peminjaman::where('barang_id', $request->barang_id)
            ->where('id', '!=', $peminjaman->id)
            ->whereIn('status', ['Menunggu ACC', 'Dipinjam'])
            ->where('tanggal_pinjam', '<=', $request->tanggal_kembali)
            ->where('tanggal_kembali', '>=', $request->tanggal_pinjam)
            ->exists();

        if ($bentrok) {
            return back()->withInput()->with('error', 'Gagal! Terdapat bentrok jadwal dengan peminjam lain pada rentang tanggal tersebut.');
        }

        $data = $request->only(['barang_id', 'tanggal_pinjam', 'tanggal_kembali', 'keterangan']);

        if (auth()->user()->role === 'Administrator' && $request->has('status')) {
            $data['status'] = $request->status;

            // Catat waktu kembali aktual dan kondisi jika dikembalikan
            if ($request->status === 'Dikembalikan') {
                $data['kondisi_kembali'] = $request->kondisi_kembali;
                $data['tanggal_kembali_aktual'] = now()->format('Y-m-d');
            } else {
                $data['kondisi_kembali'] = null;
                $data['tanggal_kembali_aktual'] = null;
            }
        }

        $peminjaman->update($data);

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    /**
     * Hapus data peminjaman.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data riwayat peminjaman berhasil dihapus.');
    }

    /**
     * Kirim pengingat manual untuk 1 peminjaman (Satuan)
     */
    public function remindSingle(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Dipinjam') {
            return back()->with('error', 'Gagal: Hanya aset berstatus "Dipinjam" yang dapat diberi pengingat.');
        }

        if (! $peminjaman->user->no_wa) {
            return back()->with('error', "Gagal: Peminjam ({$peminjaman->user->nama_lengkap}) tidak memiliki nomor WA.");
        }

        $this->kirimPesanWa($peminjaman);

        return back()->with('success', "Pengingat WA berhasil dikirim ke {$peminjaman->user->nama_lengkap}.");
    }

    /**
     * Kirim pengingat massal (Bulking) untuk semua H-2 sampai Telat
     */
    public function remindBulk()
    {
        $now = now()->startOfDay();
        $target = $now->copy()->addDays(2); // Batas maksimal H-2

        // Cari peminjaman berstatus 'Dipinjam' yang tanggal kembalinya <= H-2
        $peminjamans = Peminjaman::with(['user', 'barang'])
            ->where('status', 'Dipinjam')
            ->where('tanggal_kembali', '<=', $target->format('Y-m-d'))
            ->get();

        $berhasil = 0;
        foreach ($peminjamans as $p) {
            if ($p->user->no_wa) {
                $this->kirimPesanWa($p);
                $berhasil++;
            }
        }

        if ($berhasil === 0) {
            return back()->with('info', 'Tidak ada data peminjaman yang perlu diingatkan saat ini, atau peminjam belum mendaftarkan nomor WA.');
        }

        return back()->with('success', "Pengingat WA massal berhasil dikirim ke $berhasil peminjam.");
    }

    /**
     * Helper logic untuk mengirim WA
     */
    private function kirimPesanWa($peminjaman)
    {
        $tglKembali = Carbon::parse($peminjaman->tanggal_kembali)->startOfDay();
        $now = now()->startOfDay();
        $diff = $now->diffInDays($tglKembali, false); // false agar nilai telat jadi minus (-)

        // Format waktu dinamis di pesan WA
        if ($diff < 0) {
            $waktu = '*TELAH LEWAT BATAS WAKTU* ('.abs($diff).' hari yang lalu)';
        } elseif ($diff == 0) {
            $waktu = '*HARI INI* sebelum jam kantor berakhir';
        } else {
            $waktu = "*$diff HARI LAGI* (".$tglKembali->format('d M Y').')';
        }

        $pesan = "*[PENGINGAT PENGEMBALIAN ASET]*\n\n";
        $pesan .= "Halo, *{$peminjaman->user->nama_lengkap}* 👋\n";
        $pesan .= "Mengingatkan bahwa batas waktu peminjaman aset Anda adalah $waktu.\n\n";
        $pesan .= "📦 *Aset:* {$peminjaman->barang->nama_barang}\n";
        $pesan .= "🔢 *Kode:* {$peminjaman->barang->kode_barang}\n";
        $pesan .= '📅 *Tgl Pinjam:* '.Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y')."\n\n";
        $pesan .= 'Mohon segera dikembalikan ke Administrator / Bagian Gudang agar status peminjaman dapat diperbarui. Terima kasih!';

        $token = env('FONNTE_TOKEN');
        \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $peminjaman->user->no_wa,
            'message' => $pesan,
            'countryCode' => '62',
        ]);
    }
}
