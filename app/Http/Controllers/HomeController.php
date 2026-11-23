<?php

namespace App\Http\Controllers;

// Memanggil Eloquent Model 'Buku' untuk melakukan interaksi query ke database
use App\Models\Buku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | Catatan Pengamanan Route:
    | Konstruktor bawaan sengaja dihapus dari controller ini karena seluruh
    | perlindungan hak akses (autentikasi) sudah dipasang secara terpusat
    | menggunakan middleware 'auth' pada grup route di file `routes/web.php`.
    |
    */

    /**
     * Menampilkan dashboard utama (halaman home) setelah pengguna berhasil login.
     *
     * Penjelasan Alur Pemrosesan Data & Prinsip Arsitektur (MVC):
     * 1. Setelah proses login berhasil, sistem secara otomatis
     *    mengarahkan pengguna ke halaman utama (home).
     * 2. Baris `Buku::count()` mengeksekusi query untuk menghitung
     *    total jumlah baris data yang tersimpan pada tabel `bukus`.
     * 3. Baris `auth()->user()->notifications()->latest()->take(10)->get()`
     *    mengambil 10 notifikasi terbaru milik pengguna yang sedang login.
     * 4. Penerapan Konsep MVC (Model-View-Controller):
     *    Proses perhitungan data sengaja diletakkan penuh di dalam Controller (bukan di View/Blade)
     *    agar memenuhi prinsip pemisahan tanggung jawab (*separation of concerns*). Controller
     *    bertugas mengolah dan menyiapkan data, sedangkan View (tampilan) hanya fokus menampilkan
     *    hasilnya tanpa melakukan logika pemrosesan database.
     * 5. Pengiriman Data ke View: Metode `compact('jumlah_buku', 'notifikasi')` digunakan untuk
     *    mengirimkan hasil perhitungan variabel ke dalam file tampilan `resources/views/home.blade.php`.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Menghitung jumlah total baris pada tabel buku melalui Model
        $jumlah_buku = Buku::count();

        // Mengambil 10 notifikasi terbaru milik user yang sedang login
        $notifikasi = auth()->user()->notifications()->latest()->take(10)->get();

        // Mengirimkan hasil perhitungan dan notifikasi ke tampilan home.blade.php
        return view('home', compact('jumlah_buku', 'notifikasi'));
    }

    /**
     * Menandai seluruh notifikasi yang belum dibaca menjadi sudah dibaca (Tugas 4).
     */
    public function bacaSemua(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}