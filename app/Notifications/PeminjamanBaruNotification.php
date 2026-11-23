<?php

namespace App\Notifications;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeminjamanBaruNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Peminjaman $peminjaman) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengajuan Peminjaman Baru')
            ->line('Ada pengajuan peminjaman baru untuk buku: ' . $this->peminjaman->buku->judul)
            ->line('Peminjam: ' . $this->peminjaman->user->name)
            ->line('Berkas: ' . asset('storage/' . $this->peminjaman->berkas))
            ->action('Lihat Pengajuan', route('peminjaman.index'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'peminjaman_id' => $this->peminjaman->id,
            'pesan' => 'Pengajuan peminjaman baru: ' . $this->peminjaman->buku->judul
                       . ' oleh ' . $this->peminjaman->user->name,
        ];
    }
}