<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BarangMasukNotification extends Notification
{
    use Queueable;

    public $barang;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($barang, $user)
    {
        $this->barang = $barang; // Data barang yang baru diinput
        $this->user = $user;     // Siapa yang input
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        // Kirim ke Database (Lonceng Web) DAN Mail (Email SMTP)
        // Tanpa Queue, jadi langsung kirim saat itu juga.
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Aset Baru: '.$this->barang->nama_barang) // Judul Email
            ->greeting('Halo, '.$notifiable->nama_lengkap) // Menyapa nama penerima
            ->line('Informasi Aset Baru:')
            ->line('Sistem INVENTRA mencatat penambahan aset baru oleh '.$this->user->nama_lengkap.'.')
            ->line('📝 Detail Barang:')
            ->line('• Nama: '.$this->barang->nama_barang)
            ->line('• Kode: '.$this->barang->kode_barang)
            ->line('• Merek: '.($this->barang->merek ?? '-'))
            ->action('Lihat Detail di Aplikasi', route('barang.show', $this->barang->id)) // Tombol
            ->line('Terima kasih, Kejaksaan Negeri Banjarmasin.');
    }

    /**
     * Get the array representation of the notification.
     * (Ini yang masuk ke tabel 'notifications' untuk lonceng di web)
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Aset Baru Ditambahkan',
            'message' => $this->user->nama_lengkap.' menambahkan barang: '.$this->barang->nama_barang,
            'url' => route('barang.show', $this->barang->id), // Arahkan ke detail barang
            'icon' => 'fas fa-box',
            'color' => 'bg-indigo-500',
        ];
    }
}
