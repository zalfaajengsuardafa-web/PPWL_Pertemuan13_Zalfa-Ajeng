@extends('layouts.master')

@section('title', 'Daftar Buku')

@section('content')
<h1 class="mt-2">Daftar Buku</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Daftar Buku</li>
</ol>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach ($bukus as $buku)
        <div class="col">
            <div class="card h-100 shadow-sm text-center">
                @if ($buku->foto)
                    <img src="{{ asset('images/' . $buku->foto) }}" class="card-img-top"
                         alt="{{ $buku->judul }}" style="height:260px;object-fit:cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center text-secondary"
                         style="height:260px;">Tidak ada foto</div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $buku->judul }}</h5>
                    <p class="card-text text-muted">{{ $buku->penulis }}</p>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('galeri.buku', $buku->buku_seo) }}" class="btn btn-primary btn-sm">Lihat Galeri</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection