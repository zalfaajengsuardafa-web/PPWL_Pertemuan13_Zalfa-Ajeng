{{-- Menggunakan layouts.master sebagai kerangka utama halaman. --}}
@extends('layouts.master')

{{-- Mengisi judul halaman pada layout. --}}
@section('title', 'Edit Foto')

{{-- Memulai bagian konten utama halaman. --}}
@section('content')

    {{-- Menampilkan judul halaman dengan sedikit jarak di bagian atas. --}}
    <h1 class="mt-2">Edit Foto</h1>

    {{-- Breadcrumb menunjukkan posisi halaman dan menyediakan
         tautan kembali ke Dashboard serta daftar Gallery. --}}
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('gallery.index') }}">Gallery</a>
        </li>
        <li class="breadcrumb-item active">Edit Foto</li>
    </ol>

    {{-- Card digunakan sebagai wadah form edit gambar. --}}
    <div class="card mb-4">

        {{-- Header card berisi ikon dan nama form. --}}
        <div class="card-header">
            <i class="fas fa-pen me-1"></i> Form Edit Gambar
        </div>

        <div class="card-body">

            {{-- Form mengirim perubahan ke route gallery.update untuk
                 postingan dengan ID milik $post.

                 method="POST" digunakan pada form HTML, sedangkan
                 @method('PUT') di bawah memberi tahu Laravel bahwa
                 permintaan ini ditujukan untuk proses update.

                 enctype="multipart/form-data" diperlukan karena form
                 menyediakan pilihan untuk mengunggah gambar baru. --}}
            <form action="{{ route('gallery.update', $post->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                {{-- Token keamanan untuk memvalidasi pengiriman form. --}}
                @csrf

                {{-- Mengarahkan permintaan POST ke route update bermethod PUT. --}}
                @method('PUT')

                {{-- Bagian untuk mengubah judul. --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>

                    {{-- Jika validasi gagal, tampilkan kembali input sebelumnya.
                         Jika belum ada input sebelumnya, tampilkan judul
                         yang sudah tersimpan pada $post. --}}
                    <input type="text"
                           class="form-control"
                           id="title"
                           name="title"
                           value="{{ old('title', $post->title) }}">

                    {{-- Menampilkan pesan jika validasi title gagal. --}}
                    @error('title')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Bagian untuk mengubah deskripsi. --}}
                <div class="mb-3">
                    <label for="description" class="form-label">
                        Description
                    </label>

                    {{-- Mengutamakan input sebelumnya jika validasi gagal.
                         Jika tidak ada, tampilkan deskripsi dari $post. --}}
                    <textarea class="form-control"
                              id="description"
                              rows="5"
                              name="description">{{ old('description', $post->description) }}</textarea>

                    {{-- Menampilkan pesan jika validasi description gagal. --}}
                    @error('description')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Bagian untuk melihat gambar saat ini dan memilih
                     gambar pengganti jika pengguna ingin mengubahnya. --}}
                <div class="mb-3">
                    <label for="input-file" class="form-label">
                        File input
                    </label>

                    {{-- Pratinjau hanya ditampilkan jika kolom picture
                         pada $post memiliki nilai. --}}
                    @if ($post->picture)
                        <div class="mb-2">

                            {{-- Membentuk URL gambar dari folder
                                 storage/posts_image dan nama file pada
                                 $post->picture. Judul dipakai sebagai
                                 teks alternatif gambar. --}}
                            <img src="{{ asset('storage/posts_image/' . $post->picture) }}"
                                 alt="{{ $post->title }}"
                                 width="160"
                                 class="rounded border">
                        </div>
                    @endif

                    {{-- Input file untuk memilih gambar baru.
                         name="picture" harus sesuai dengan nama field
                         yang diproses pada controller. --}}
                    <input type="file"
                           class="form-control"
                           id="input-file"
                           name="picture">

                    {{-- Memberi tahu pengguna bahwa mengganti gambar
                         bersifat opsional. --}}
                    <div class="form-text">
                        Kosongkan bila tidak ingin mengganti gambar.
                    </div>

                    {{-- Menampilkan pesan jika file baru tidak memenuhi
                         aturan validasi, misalnya tipe atau ukuran file. --}}
                    @error('picture')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Mengirim perubahan untuk disimpan. --}}
                <button type="submit" class="btn btn-primary">
                    Update
                </button>

                {{-- Kembali ke daftar Gallery tanpa mengirim perubahan. --}}
                <a href="{{ route('gallery.index') }}"
                   class="btn btn-secondary">
                    Batal
                </a>

            </form>
        </div>
    </div>

{{-- Mengakhiri bagian konten utama. --}}
@endsection