<?php

namespace App\Jobs;

use App\Mail\PeminjamanDiajukanMail;
use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class KirimEmailPeminjaman implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public function __construct(public Peminjaman $peminjaman) {}

    public function handle(): void
    {
        Mail::to($this->peminjaman->user->email)
            ->send(new PeminjamanDiajukanMail($this->peminjaman));
    }
}