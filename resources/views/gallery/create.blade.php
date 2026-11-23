{{-- Menggunakan layouts.master sebagai kerangka halaman.
     Bagian seperti navigasi dan struktur utama halaman mengikuti layout tersebut. --}}
@extends('layouts.master')

{{-- Mengisi bagian title pada layout dengan teks "Tambah Foto". --}}
@section('title', 'Tambah Foto')

{{-- Memulai konten utama yang akan ditampilkan pada bagian content di layout. --}}
@section('content')

    {{-- Judul halaman. Class mt-2 memberi jarak di bagian atas. --}}
    <h1 class="mt-2">Tambah Foto</h1>

    {{-- Breadcrumb menunjukkan posisi halaman saat ini dan menyediakan
         tautan untuk kembali ke Dashboard atau halaman Gallery. --}}
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('gallery.index') }}">Gallery</a>
        </li>
        <li class="breadcrumb-item active">Tambah Foto</li>
    </ol>

    {{-- Card digunakan sebagai wadah agar form upload tersusun rapi. --}}
    <div class="card mb-4">

        {{-- Bagian judul card beserta ikon tambah. --}}
        <div class="card-header">
            <i class="fas fa-plus me-1"></i> Form Upload Gambar
        </div>

        <div class="card-body">

            {{-- Form mengirim data ke route gallery.store dengan method POST.
                 enctype="multipart/form-data" diperlukan agar file gambar
                 dapat ikut dikirim bersama title dan description. --}}
            <form action="{{ route('gallery.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                {{-- Menambahkan token CSRF untuk memvalidasi pengiriman form. --}}
                @csrf

                {{-- Input judul foto/postingan. --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>

                    {{-- Atribut name="title" menentukan nama data yang diterima
                         controller. old('title') mengisi kembali nilai sebelumnya
                         jika validasi gagal dan pengguna kembali ke form. --}}
                    <input type="text"
                           class="form-control"
                           id="title"
                           name="title"
                           value="{{ old('title') }}">

                    {{-- Menampilkan pesan validasi khusus untuk input title,
                         jika controller menemukan kesalahan pada field tersebut. --}}
                    @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input deskripsi foto/postingan. --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>

                    {{-- Nilai deskripsi lama diletakkan di antara tag textarea
                         agar tidak perlu diketik ulang setelah validasi gagal. --}}
                    <textarea class="form-control"
                              id="description"
                              rows="5"
                              name="description">{{ old('description') }}</textarea>

                    {{-- Menampilkan pesan kesalahan validasi description. --}}
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input untuk memilih file gambar dari perangkat pengguna. --}}
                <div class="mb-3">
                    <label for="input-file" class="form-label">File input</label>

                    {{-- name="picture" harus sesuai dengan nama field file
                         yang diperiksa dan diproses pada controller. --}}
                    <input type="file"
                           class="form-control"
                           id="input-file"
                           name="picture">

                    {{-- Menampilkan pesan kesalahan jika file tidak memenuhi
                         aturan validasi, misalnya tipe atau ukuran file. --}}
                    @error('picture')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mengirim seluruh isi form untuk diproses oleh gallery.store. --}}
                <button type="submit" class="btn btn-primary">Submit</button>

                {{-- Kembali ke daftar Gallery tanpa mengirim form. --}}
                <a href="{{ route('gallery.index') }}"
                   class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>

{{-- Mengakhiri bagian content. --}}
@endsection