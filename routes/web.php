<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Pengaturan Rute Aplikasi Web)
|--------------------------------------------------------------------------
| File ini mengatur seluruh alur navigasi URL aplikasi Laravel. Setiap rute mengarahkan
| permintaan HTTP dari browser ke Controller dan metode yang sesuai.
|
*/

// =========================================================================
// 1. RUTE AUTENTIKASI (LOGIN, REGISTER, FORGOT PASSWORD, LOGOUT)
// =========================================================================
Auth::routes([
    'register' => false,
    'reset'    => false,
]);

// Login Google SSO (Hanya untuk tamu / belum login)
Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

// =========================================================================
// 2. RUTE NAVIGASI UTAMA & HALAMAN PUBLIK
// =========================================================================
Route::redirect('/', '/home');

// Halaman Portofolio Publik (dapat diakses tanpa login)
Route::get('/portofolio', [PortofolioController::class, 'index'])->name('portofolio');

// =========================================================================
// 3. RUTE TERPROTEKSI (WAJIB LOGIN / AUTHENTICATED)
// =========================================================================
Route::middleware('auth')->group(function () {

    // Dashboard Utama
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Tugas 4: Tandai Semua Notifikasi Dibaca
    Route::post('/notifikasi/baca-semua', [HomeController::class, 'bacaSemua'])->name('notifikasi.baca');

    // ---------------------------------------------------------------------
    // LATIHAN 1 - 4: PENGAJUAN PEMINJAMAN BUKU (PeminjamanController)
    // ---------------------------------------------------------------------
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::patch('/peminjaman/{peminjaman}/status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.status');

    // ---------------------------------------------------------------------
    // CRUD DATA BUKU (BukuController)
    // ---------------------------------------------------------------------
    Route::resource('buku', BukuController::class)->except('show');

    // ---------------------------------------------------------------------
    // MODUL SEO BUKU (BukuController)
    // ---------------------------------------------------------------------
    Route::get('/list-buku', [BukuController::class, 'listBuku'])->name('buku.list');
    Route::get('/detail-buku/{title}', [BukuController::class, 'galbuku'])->name('galeri.buku');

    // ---------------------------------------------------------------------
    // MODUL GALLERY (GalleryController)
    // ---------------------------------------------------------------------
    Route::resource('gallery', GalleryController::class)->except('show');

    // ---------------------------------------------------------------------
    // CRUD DATA USER (UserController)
    // ---------------------------------------------------------------------
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});