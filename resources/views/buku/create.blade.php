{{-- Menginduk ke tata letak master aplikasi (layouts/master.blade.php) --}}
@extends('layouts.master')

{{-- Mengatur judul halaman pada tab peramban --}}
@section('title', 'Tambah Buku')

@section('content')
<div class="container-fluid px-0">

    {{-- Judul Halaman Utama & Navigasi Breadcrumb --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h2 class="fw-bold text-dark m-0">Tambah Data Buku</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('buku.index') }}" class="text-decoration-none text-primary">Data Buku</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Buku</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Kartu Utama Formulir Tambah Buku --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        
        {{-- Header Kartu --}}
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded me-2">
                <i class="fas fa-plus fs-5"></i>
            </div>
            <h5 class="m-0 fw-bold text-dark">Formulir Tambah Buku</h5>
        </div>

        {{-- Badan Kartu & Isian Formulir --}}
        <div class="card-body p-4">

            {{-- Menampilkan Alert Notifikasi Jika Ada Kesalahan Validasi Input --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                        <strong>Terdapat kesalahan pada inputan Anda:</strong>
                    </div>
                    <ul class="mb-0 ps-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            {{-- Atribut novalidate ditambahkan agar browser tidak memblokir pengiriman saat uji PDF --}}
            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                
                {{-- Input 1: Judul Buku --}}
                <div class="form-floating mb-3">
                    <input type="text" 
                           class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" 
                           name="judul" 
                           placeholder="Judul Buku"
                           value="{{ old('judul', 'Laskar Pelangi') }}" 
                           required 
                           autofocus>
                    <label for="judul"><i class="fas fa-book me-1 text-muted"></i> Judul Buku</label>
                </div>

                {{-- Input 2: Nama Penulis --}}
                <div class="form-floating mb-3">
                    <input type="text" 
                           class="form-control @error('penulis') is-invalid @enderror" 
                           id="penulis" 
                           name="penulis" 
                           placeholder="Penulis"
                           value="{{ old('penulis', 'Andrea Hirata') }}" 
                           required>
                    <label for="penulis"><i class="fas fa-user-edit me-1 text-muted"></i> Penulis</label>
                </div>

                {{-- Input 3: Harga Buku --}}
                <div class="form-floating mb-3">
                    <input type="number" 
                           class="form-control @error('harga') is-invalid @enderror" 
                           id="harga" 
                           name="harga" 
                           placeholder="Harga (Rp)"
                           value="{{ old('harga', '90000') }}" 
                           required>
                    <label for="harga"><i class="fas fa-tag me-1 text-muted"></i> Harga (Rp)</label>
                </div>

                {{-- Input 4: Tanggal Terbit --}}
                <div class="form-floating mb-3">
                    <input type="date" 
                           class="form-control @error('tgl_terbit') is-invalid @enderror" 
                           id="tgl_terbit" 
                           name="tgl_terbit" 
                           value="{{ old('tgl_terbit', '2005-09-25') }}" 
                           required>
                    <label for="tgl_terbit"><i class="fas fa-calendar-alt me-1 text-muted"></i> Tanggal Terbit</label>
                </div>

                {{-- Input 5: Jenis Buku --}}
                <div class="form-floating mb-3">
                    <select class="form-select @error('jenis_buku') is-invalid @enderror" id="jenis_buku" name="jenis_buku" required>
                        <option value="" disabled>-- Pilih Jenis Buku --</option>
                        <option value="Fiksi" {{ old('jenis_buku', 'Fiksi') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                        <option value="Nonfiksi" {{ old('jenis_buku') == 'Nonfiksi' ? 'selected' : '' }}>Nonfiksi</option>
                    </select>
                    <label for="jenis_buku"><i class="fas fa-layer-group me-1 text-muted"></i> Jenis Buku</label>
                </div>

                {{-- Input 6: File Sampul (Tanpa accept agar PDF bisa diklik) --}}
                <div class="mb-4">
                    <label for="cover" class="form-label text-muted small fw-bold mb-1">
                        <i class="fas fa-image me-1"></i> Sampul Buku (Opsional)
                    </label>
                    <input type="file" 
                           class="form-control @error('cover') is-invalid @enderror" 
                           id="cover" 
                           name="cover">
                    <div class="form-text text-muted small">
                        Format berkas yang diizinkan: JPG, JPEG, PNG (Maksimal 2 MB).
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i> Simpan Buku
                    </button>
                    
                    <a href="{{ route('buku.index') }}" class="btn btn-secondary px-4 shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Batal
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection