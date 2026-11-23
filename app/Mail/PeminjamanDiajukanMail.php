<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PeminjamanDiajukanMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Peminjaman $peminjaman) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan Peminjaman: ' . $this->peminjaman->buku->judul,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.peminjaman_diajukan',
            with: ['peminjaman' => $this->peminjaman],
        );
    }
}