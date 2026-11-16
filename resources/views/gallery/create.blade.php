@extends('layouts.master')

@section('title', 'Tambah Foto')

@section('content')
<h1 class="mt-2">Tambah Foto</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Gallery</a></li>
    <li class="breadcrumb-item active">Tambah Foto</li>
</ol>

<div class="card mb-4">
    <div class="card-header"><i class="fas fa-plus me-1"></i> Form Upload Gambar</div>
    <div class="card-body">
        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                @error('title')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" rows="5" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="input-file" class="form-label">File input</label>
                <input type="file" class="form-control" id="input-file" name="picture">
                @error('picture')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection