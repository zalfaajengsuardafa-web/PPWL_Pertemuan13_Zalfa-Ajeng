{{-- Memakai layout master hasil templat SB Admin --}}
@extends('layouts.master')

{{-- Menentukan judul dinamis pada tab browser --}}
@section('title', 'Dashboard')

@section('content')
    <h1 class="mt-2">Dashboard</h1>

    {{-- Breadcrumb sebagai penanda navigasi hierarki posisi halaman --}}
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    {{-- Alert Pesan Sukses (misalnya setelah berhasil Login via Google SSO atau menandai notifikasi dibaca) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-4 col-md-6">
            {{-- 
                Kartu Ringkasan Statistik (Card Summary):
                Angka jumlah buku dikirim dari HomeController melalui metode Buku::count()
                dan dikirim menggunakan compact('jumlah_buku'). Tampilan hanya menerima
                dan menampilkan variabel $jumlah_buku tanpa melakukan olah data query.
            --}}
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="fs-2 fw-bold">{{ $jumlah_buku }}</div>
                    Jumlah Buku
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    {{-- Utility class 'stretched-link' dari Bootstrap membuat seluruh area kartu dapat diklik --}}
                    <a class="small text-white stretched-link" href="{{ route('buku.index') }}">Lihat Data Buku</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- 
        Kartu Sapaan Dinamis Autentikasi Pengguna:
        Sapaan pada komponen ini menggunakan sintaks Blade {{ Auth::user()->name }}.
        Sintaks ini mengambil properti nama secara langsung dari objek pengguna yang sedang aktif/login melalui session.
        Ini membuktikan bahwa Laravel secara dinamis memverifikasi dan mengenali sesi autentikasi akun pengguna yang masuk,
        sehingga teks sapaan bersifat dinamis berbasis data autentikasi dan bukan teks statis (hardcoded).
    --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>Selamat datang, {{ Auth::user()->name }}</h5>
            <p class="mb-0">Anda berhasil masuk ke sistem pengelolaan data buku.</p>
        </div>
    </div>

    {{-- Panel Daftar Notifikasi Database (menerima variabel $notifikasi dari HomeController) --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-bell me-1"></i> Notifikasi
        </div>
        <ul class="list-group list-group-flush">
            @forelse ($notifikasi as $n)
                <li class="list-group-item d-flex justify-content-between align-items-center {{ $n->read_at ? '' : 'fw-semibold bg-light' }}">
                    <span>{{ $n->data['pesan'] ?? 'Notifikasi baru' }}</span>
                    <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
                </li>
            @empty
                <li class="list-group-item text-muted">Belum ada notifikasi.</li>
            @endforelse
        </ul>
    </div>
@endsection