<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BarangMasukNotification extends Notification
{
    use Queueable;

    public $barang;

    public $user;

    public function __construct($barang, $user)
    {
        $this->barang = $barang; // Data barang yang baru diinput
        $this->user = $user;     // Siapa yang input (Pegawai)
    }

    public function via($notifiable)
    {
        return ['database']; // Simpan ke database saja
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Aset Baru Ditambahkan',
            'message' => $this->user->nama_lengkap.' menambahkan barang: '.$this->barang->nama_barang,
            'url' => route('barang.index'), // Link kalau diklik
            'icon' => 'fas fa-box',
            'color' => 'bg-indigo-500',
        ];
    }
}
