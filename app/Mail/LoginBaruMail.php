<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginBaruMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $waktuLogin,
        public string $ipAddress
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Aktivitas Login Baru - Daftar Buku',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.login_baru',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}