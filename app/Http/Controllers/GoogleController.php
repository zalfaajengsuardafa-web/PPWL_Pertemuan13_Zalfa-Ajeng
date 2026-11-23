<?php

namespace App\Http\Controllers;

use App\Jobs\KirimEmailSelamatDatang;
use App\Mail\LoginBaruMail;
use App\Models\User;
use App\Notifications\UserBaruNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // 1) Arahkan user ke halaman login Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2) Google mengembalikan user ke sini setelah login berhasil
    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal atau dibatalkan. Silakan coba lagi.');
        }

        // 2b) Batasi hanya email kampus (@mail.ugm.ac.id)
        if (! str_ends_with(strtolower($googleUser->getEmail()), '@mail.ugm.ac.id')) {
            return redirect()->route('login')
                ->with('error', 'Hanya email kampus (@mail.ugm.ac.id) yang diperbolehkan.');
        }

        // 3) Cari user berdasarkan google_id, atau email (jika dulu daftar manual)
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        $userBaru = false;

        if (! $user) {
            // 4a) Belum terdaftar -> buat akun baru
            $user = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'avatar'            => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]);
            $userBaru = true;
        } else {
            // 4b) Sudah terdaftar -> perbarui data Google-nya
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);
        }

        // 5) Login-kan user ke aplikasi Laravel
        Auth::login($user, remember: true);
        $request->session()->regenerate();

        // 6) Kirim email & notifikasi lewat queue sesuai status user
        if ($userBaru) {
            KirimEmailSelamatDatang::dispatch($user);
            $admin = User::where('level', 'admin')->first();
            $admin?->notify(new UserBaruNotification($user));
        } else {
            Mail::to($user->email)->queue(
                new LoginBaruMail($user, now()->format('d M Y H:i:s'), $request->ip() ?? '127.0.0.1')
            );
        }

        return redirect()->intended(route('home'))
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }
}