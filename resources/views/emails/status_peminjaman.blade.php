<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo {{ $peminjaman->user->name }},</h2>

    @if ($peminjaman->status === 'disetujui')
        <div style="background:#d1e7dd;color:#0f5132;padding:12px;border-radius:6px;margin-bottom:12px;">
            <b>Pengajuan Anda DISETUJUI.</b>
        </div>
        <p>Pengajuan peminjaman buku <b>{{ $peminjaman->buku->judul }}</b> telah disetujui. Silakan datang ke perpustakaan untuk mengambil buku.</p>
    @else
        <div style="background:#f8d7da;color:#842029;padding:12px;border-radius:6px;margin-bottom:12px;">
            <b>Pengajuan Anda DITOLAK.</b>
        </div>
        <p>Mohon maaf, pengajuan peminjaman buku <b>{{ $peminjaman->buku->judul }}</b> belum dapat kami setujui.</p>
    @endif

    <p>Salam,<br><b>Tim {{ config('app.name') }}</b></p>
</body>
</html>