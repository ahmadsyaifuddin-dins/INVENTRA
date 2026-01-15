<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    // Saat klik satu notifikasi
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();

            // Redirect ke URL tujuan (misal: halaman barang)
            return redirect($notification->data['url']);
        }

        return back();
    }

    // Saat klik "Tandai semua sudah dibaca"
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    }
}
