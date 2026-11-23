@extends('layouts.master')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Ajukan Peminjaman Buku</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('peminjaman.index') }}">Pengajuan Peminjaman</a></li>
        <li class="breadcrumb-item active">Form Pengajuan</li>
    </ol>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-file-upload me-1"></i> Form Pengajuan Peminjaman Buku</div>
        <div class="card-body">
            <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="buku_id" class="form-label">Pilih Buku</label>
                    <select name="buku_id" id="buku_id" class="form-select" required>
                        <option value="">-- Pilih Judul Buku --</option>
                        @foreach ($daftarBuku as $buku)
                            <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="berkas" class="form-label">Berkas Pendukung (PDF, maks. 2MB)</label>
                    <input type="file" name="berkas" id="berkas" class="form-control" accept="application/pdf" required>
                </div>
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="3" class="form-control" placeholder="Keperluan peminjaman..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection