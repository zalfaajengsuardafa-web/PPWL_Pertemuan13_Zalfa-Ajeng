<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
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