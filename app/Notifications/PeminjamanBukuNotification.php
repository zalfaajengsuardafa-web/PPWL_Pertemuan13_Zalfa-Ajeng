<?php

namespace App\Notifications;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PeminjamanBukuNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Peminjaman $peminjaman) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $namaUser = $this->peminjaman->user->name ?? 'Mahasiswa';

        return [
            'pesan' => "{$namaUser} mengajukan peminjaman buku: \"{$this->peminjaman->judul_buku}\".",
            'peminjaman_id' => $this->peminjaman->id,
        ];
    }
}