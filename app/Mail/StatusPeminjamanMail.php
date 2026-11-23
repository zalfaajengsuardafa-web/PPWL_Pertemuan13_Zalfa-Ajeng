<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusPeminjamanMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Peminjaman $peminjaman) {}

    public function envelope(): Envelope
    {
        $status = $this->peminjaman->status === 'disetujui' ? 'Disetujui' : 'Ditolak';

        return new Envelope(
            subject: 'Pengajuan Peminjaman ' . $status . ': ' . $this->peminjaman->buku->judul,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.status_peminjaman',
            with: ['peminjaman' => $this->peminjaman],
        );
    }
}