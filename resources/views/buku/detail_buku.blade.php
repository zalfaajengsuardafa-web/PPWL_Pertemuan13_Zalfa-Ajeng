@extends('layouts.master')

@section('title', 'Detail Buku')

@section('content')
<h1 class="mt-2">Detail Buku</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('buku.list') }}">Daftar Buku</a></li>
    <li class="breadcrumb-item active">{{ $bukus->judul }}</li>
</ol>

<section id="album" class="py-1 text-center bg-light rounded">
    <div class="container">
        <h2>Buku: {{ $bukus->judul }}</h2>
        <hr>
        <div class="row">
            @forelse ($galeris as $data)
                <div class="col-md-4 mb-3">
                    <a href="{{ asset('images/' . $data->foto) }}"
                       data-lightbox="image-1" data-title="{{ $data->keterangan }}">
                        <img src="{{ asset('images/' . $data->foto) }}"
                             style="width:200px; height:150px; object-fit:cover;" class="rounded">
                    </a>
                    <h5 class="mt-2">{{ $data->nama_galeri }}</h5>
                </div>
            @empty
                <p class="text-muted">Buku ini belum memiliki galeri.</p>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">{{ $galeris->links() }}</div>
    </div>
</section>

<a href="{{ route('buku.list') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection