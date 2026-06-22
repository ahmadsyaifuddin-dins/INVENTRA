<?php

namespace App\Console\Commands;

use App\Models\Barang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendAssetReminder extends Command
{
    protected $signature = 'app:send-asset-reminder';

    protected $description = 'Kirim notifikasi WA otomatis via Fonnte untuk aset yang H-7 Servis/Penyusutan';

    public function handle()
    {
        $targetDate = Carbon::now()->addDays(7)->format('Y-m-d');

        // Cari barang yang H-7 servis ATAU H-7 penyusutan
        $barangs = Barang::where('tgl_servis_berikutnya', $targetDate)
            ->orWhere('tgl_penyusutan_habis', $targetDate)
            ->get();

        if ($barangs->isEmpty()) {
            $this->info('Tidak ada jadwal servis atau penyusutan untuk H-7.');

            return;
        }

        // Ambil admin yang punya nomor WA
        $admins = User::where('role', 'Administrator')->whereNotNull('no_wa')->get();

        if ($admins->isEmpty()) {
            $this->warn('Tidak ada Administrator dengan nomor WA yang valid.');

            return;
        }

        $token = env('FONNTE_TOKEN');

        foreach ($barangs as $b) {
            $jenisAlert = ($b->tgl_servis_berikutnya == $targetDate) ? 'Servis Berkala' : 'Batas Penyusutan';
            $tanggal = ($b->tgl_servis_berikutnya == $targetDate) ? $b->tgl_servis_berikutnya : $b->tgl_penyusutan_habis;

            $pesan = "*⚠️ PERINGATAN SISTEM INVENTRA*\n\n";
            $pesan .= "Aset berikut mendekati jadwal *$jenisAlert* (H-7):\n\n";
            $pesan .= "📦 *Nama Aset:* {$b->nama_barang}\n";
            $pesan .= "🔢 *Kode:* {$b->kode_barang}\n";
            $pesan .= '📅 *Tanggal:* '.Carbon::parse($tanggal)->translatedFormat('d F Y')."\n\n";
            $pesan .= 'Mohon segera lakukan tindak lanjut.';

            foreach ($admins as $admin) {
                // Tembak API Fonnte
                Http::withHeaders([
                    'Authorization' => $token,
                ])->post('https://api.fonnte.com/send', [
                    'target' => $admin->no_wa,
                    'message' => $pesan,
                    'countryCode' => '62', // Pastikan format Indonesia
                ]);
            }
        }

        $this->info('Notifikasi pengingat aset berhasil dikirim ke Administrator!');
    }
}
