<?php

namespace App\Http\Controllers;

use App\Jobs\KirimEmailPeminjaman;
use App\Mail\StatusPeminjamanMail;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use App\Notifications\PeminjamanBaruNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $peminjaman = $user->isAdmin()
            ? Peminjaman::with(['user', 'buku'])->latest()->get()
            : Peminjaman::with(['user', 'buku'])->where('user_id', $user->id)->latest()->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $daftarBuku = Buku::orderBy('judul')->get();
        return view('peminjaman.create', compact('daftarBuku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'berkas'  => 'required|mimes:pdf|max:2048',
            'catatan' => 'nullable|string|max:500',
        ]);

        $path = $request->file('berkas')->store('berkas_peminjaman', 'public');

        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'berkas'  => $path,
            'catatan' => $request->catatan,
            'status'  => 'menunggu',
        ]);

        KirimEmailPeminjaman::dispatch($peminjaman);

        $admins = User::where('level', 'admin')->get();
        Notification::send($admins, new PeminjamanBaruNotification($peminjaman));

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan berhasil dikirim! Cek email Anda.');
    }

    public function updateStatus(Request $request, Peminjaman $peminjaman)
    {
        abort_unless($request->user()->isAdmin(), 403);

        $request->validate(['status' => 'required|in:disetujui,ditolak']);

        $peminjaman->update(['status' => $request->status]);

        Mail::to($peminjaman->user->email)->queue(new StatusPeminjamanMail($peminjaman));

        return back()->with('success', 'Status pengajuan diperbarui dan email dikirim.');
    }
}