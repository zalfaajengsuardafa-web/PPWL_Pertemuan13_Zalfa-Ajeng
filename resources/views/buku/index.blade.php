{{-- Menginduk ke berkas tata letak utama aplikasi --}}
@extends('layouts.master')

{{-- Menetapkan judul halaman berdasarkan level akun --}}
@section('title', Auth::check() && Auth::user()->level == 'admin' ? 'Data Buku (Admin)' : 'Katalog Buku')

@section('content')
@php
    // Penentu tampilan: true bila akun yang login berlevel admin
    $isAdmin = Auth::check() && Auth::user()->level == 'admin';
@endphp

<div class="container-fluid px-0">

    {{-- Header Halaman, Navigasi Breadcrumb, dan Tombol Tambah (khusus admin) --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h2 class="fw-bold text-dark m-0">{{ $isAdmin ? 'Data Buku' : 'Katalog Buku' }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $isAdmin ? 'Data Buku' : 'Katalog Buku' }}
                    </li>
                </ol>
            </nav>
        </div>

        @if ($isAdmin)
            <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded-2">
                <i class="fas fa-plus me-1"></i> Tambah Buku
            </a>
        @endif
    </div>

    {{-- Notifikasi Sukses dari Controller saat Tambah/Edit/Hapus Data --}}
    @if (Session::has('pesan'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ Session::get('pesan') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Grid Card Buku (dipakai bersama oleh admin dan user) --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
        @forelse ($data_buku as $buku)
            <div class="col">
                <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">

                    {{-- Sampul buku (hasil upload) atau placeholder bila belum ada --}}
                    @if ($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}" class="card-img-top"
                             alt="Sampul {{ $buku->judul }}" style="height: 260px; object-fit: cover;">
                    @else
                        <div class="bg-primary bg-opacity-10 text-primary d-flex flex-column align-items-center justify-content-center"
                             style="height: 260px;">
                            <i class="fas fa-book-open display-4 mb-2"></i>
                            <small>Belum ada sampul</small>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column p-3">
                        {{-- Lencana jenis buku --}}
                        <div class="mb-2">
                            @if ($buku->jenis_buku)
                                <span class="badge {{ $buku->jenis_buku == 'Fiksi' ? 'bg-primary' : 'bg-success' }}">
                                    {{ $buku->jenis_buku }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Belum dikategorikan</span>
                            @endif
                        </div>

                        <h5 class="card-title fw-bold text-dark fs-6 text-truncate mb-2" title="{{ $buku->judul }}">
                            {{ $buku->judul }}
                        </h5>

                        <p class="card-text mb-2">
                            <span class="badge bg-light text-dark border fw-normal px-2 py-1">
                                <i class="fas fa-user-edit me-1 text-muted"></i>{{ $buku->penulis }}
                            </span>
                        </p>

                        <p class="card-text fw-bold text-success m-0 fs-6">
                            Rp {{ number_format($buku->harga, 0, ',', '.') }}
                        </p>

                        <small class="text-muted mt-2">
                            Terbit: {{ $buku->tgl_terbit ? $buku->tgl_terbit->format('d/m/Y') : '-' }}
                        </small>
                    </div>

                    @if ($isAdmin)
                        {{-- Tombol pengelolaan: hanya tampil untuk admin --}}
                        <div class="card-footer bg-white border-top d-flex gap-2">
                            <a href="{{ route('buku.edit', $buku->id) }}"
                               class="btn btn-warning btn-sm text-dark px-2 shadow-sm" title="Edit">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>

                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm px-2 shadow-sm"
                                        onclick="return confirm('Yakin mau dihapus?')" title="Hapus">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- Tombol tampilan untuk user (belum memiliki fungsi lanjutan) --}}
                        <div class="card-footer bg-light border-0 d-grid gap-2 p-3">
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-2">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </button>
                            <button type="button" class="btn btn-primary btn-sm rounded-2">
                                <i class="fas fa-shopping-cart me-1"></i> Pinjam / Beli
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 bg-white rounded-3 shadow-sm">
                <i class="fas fa-inbox display-4 text-secondary d-block mb-3"></i>
                <p class="text-muted fw-bold mb-0">Belum ada data buku yang tersimpan.</p>
            </div>
        @endforelse
    </div>

    {{-- Footer: Informasi Jumlah Buku & Pagination --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-4">
        <div class="small text-muted">
            <strong>Jumlah Buku:</strong>
            <span class="badge bg-primary rounded-pill px-3 py-2 ms-1">{{ $jumlah_buku }}</span>
        </div>

        <div>
            {{ $data_buku->links() }}
        </div>
    </div>

</div>
@endsection