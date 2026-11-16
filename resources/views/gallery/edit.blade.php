@extends('layouts.master')

@section('title', 'Edit Foto')

@section('content')
<h1 class="mt-2">Edit Foto</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Gallery</a></li>
    <li class="breadcrumb-item active">Edit Foto</li>
</ol>

<div class="card mb-4">
    <div class="card-header"><i class="fas fa-pen me-1"></i> Form Edit Gambar</div>
    <div class="card-body">
        <form action="{{ route('gallery.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
                @error('title')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" rows="5" name="description">{{ old('description', $post->description) }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="input-file" class="form-label">File input</label>
                @if ($post->picture)
                    <div class="mb-2">
                        <img src="{{ asset('storage/posts_image/' . $post->picture) }}" alt="{{ $post->title }}"
                             width="160" class="rounded border">
                    </div>
                @endif
                <input type="file" class="form-control" id="input-file" name="picture">
                <div class="form-text">Kosongkan bila tidak ingin mengganti gambar.</div>
                @error('picture')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection