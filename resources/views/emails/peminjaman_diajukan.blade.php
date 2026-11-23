<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo {{ $peminjaman->user->name }},</h2>
    <p>Terima kasih telah mengajukan peminjaman buku <strong>{{ $peminjaman->buku->judul }}</strong>. Pengajuan Anda sedang diproses oleh petugas.</p>
    <p>Berkas yang Anda lampirkan:
        <a href="{{ asset('storage/' . $peminjaman->berkas) }}" style="color: #0d6efd; font-weight: bold;">Unduh berkas pengajuan</a>
    </p>
    <p>Salam,<br><strong>Tim {{ config('app.name') }}</strong></p>
</body>
</html>