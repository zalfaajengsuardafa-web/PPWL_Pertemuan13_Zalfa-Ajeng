@extends('layouts.master')

@section('title', 'Gallery')

@section('content')
<h1 class="mt-2">Gallery</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Gallery</li>
</ol>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-images me-1"></i> Galeri Foto</span>
        <a href="{{ route('gallery.create') }}" class="btn btn-primary btn-sm">Tambah Foto</a>
    </div>
    <div class="card-body">
        <div class="row">
            @if (count($galleries) > 0)
                @foreach ($galleries as $gallery)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4 text-center">
                        <a class="example-image-link"
                           href="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                           data-lightbox="galeri" data-title="{{ $gallery->description }}">
                            <img class="example-image img-fluid rounded mb-2"
                                 src="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                                 alt="{{ $gallery->title }}"
                                 style="width:100%;height:150px;object-fit:cover;">
                        </a>
                        <div class="fw-bold">{{ $gallery->title }}</div>
                        <div class="d-flex justify-content-center gap-2 mt-2">
                            <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus foto ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <h3>Tidak ada data.</h3>
            @endif
        </div>
        <div class="d-flex">{{ $galleries->links() }}</div>
    </div>
</div>
@endsection