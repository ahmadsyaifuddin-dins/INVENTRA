<?php

namespace App\Console\Commands;

use App\Http\Controllers\PeminjamanController;
use App\Models\Peminjaman;
use Illuminate\Console\Command;

class SendPeminjamanReminder extends Command
{
    protected $signature = 'app:send-peminjaman-reminder';

    protected $description = 'Kirim notifikasi WA otomatis untuk aset yang mendekati batas waktu peminjaman (H-2)';

    public function handle()
    {
        // 1. AUTO-UPDATE STATUS TERLAMBAT
        $telatCount = Peminjaman::where('status', 'Dipinjam')
            ->where('tanggal_kembali', '<', now()->format('Y-m-d'))
            ->update(['status' => 'Terlambat']);

        if ($telatCount > 0) {
            $this->info("$telatCount peminjaman otomatis diubah menjadi Terlambat.");
        }

        // 2. JALANKAN LOGIKA PENGINGAT WA
        $controller = new PeminjamanController;
        try {
            $controller->remindBulk();
            $this->info('Notifikasi pengingat pengembalian aset berhasil dieksekusi!');
        } catch (\Exception $e) {
            $this->error('Gagal mengirim pengingat: '.$e->getMessage());
        }
    }
}
