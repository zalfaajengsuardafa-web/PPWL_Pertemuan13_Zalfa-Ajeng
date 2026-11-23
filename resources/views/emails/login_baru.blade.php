<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Login Baru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;">
        <h2 style="color: #0d6efd;">Halo, {{ $user->name }}!</h2>
        <p>Kami mendeteksi adanya aktivitas login baru pada akun <strong>Daftar Buku</strong> Anda dengan detail berikut:</p>
        <ul>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Waktu Login:</strong> {{ $waktuLogin }}</li>
            <li><strong>Alamat IP:</strong> {{ $ipAddress }}</li>
        </ul>
        <p>Jika ini adalah Anda, silakan abaikan email ini. Jika Anda merasa tidak melakukan aktivitas login tersebut, segera amankan akun Google Anda.</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777;">Email otomatis dari Sistem Daftar Buku (Praktikum Pemrograman Web 2).</p>
    </div>
</body>
</html>