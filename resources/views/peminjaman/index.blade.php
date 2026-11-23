@extends('layouts.master')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengajuan Peminjaman Buku</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengajuan Peminjaman</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-book-reader me-1"></i> Daftar Pengajuan Peminjaman</span>
            @if (! auth()->user()->isAdmin())
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Ajukan Peminjaman
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Buku</th>
                            <th>Peminjam</th>
                            <th>Berkas</th>
                            <th>Status</th>
                            @if (auth()->user()->isAdmin())
                                <th width="18%">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $p->buku->judul ?? '-' }}</strong></td>
                                <td>{{ $p->user->name ?? '-' }}</td>
                                <td>
                                    @if ($p->berkas)
                                        <a href="{{ asset('storage/' . $p->berkas) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-file-pdf me-1"></i> Unduh Berkas
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($p->status === 'menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif ($p->status === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                @if (auth()->user()->isAdmin())
                                    <td>
                                        @if ($p->status === 'menunggu')
                                            <form action="{{ route('peminjaman.status', $p->id) }}" method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="disetujui">
                                                <button class="btn btn-success btn-sm">Setujui</button>
                                            </form>
                                            <form action="{{ route('peminjaman.status', $p->id) }}" method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="ditolak">
                                                <button class="btn btn-danger btn-sm">Tolak</button>
                                            </form>
                                        @else
                                            <span class="text-muted small">Sudah diproses</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="text-center text-muted">
                                    Belum ada data pengajuan peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection