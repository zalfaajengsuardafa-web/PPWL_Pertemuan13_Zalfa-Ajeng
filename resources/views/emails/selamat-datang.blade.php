<x-mail::message>
# Halo {{ $user->name }},

Terima kasih telah mendaftar di **{{ config('app.name') }}** menggunakan akun Google
({{ $user->email }}).

Mulai sekarang Anda dapat login cukup dengan menekan tombol **Login dengan Google**
tanpa perlu mengingat kata sandi.

<x-mail::button :url="route('home')">
Buka Aplikasi
</x-mail::button>

Salam,<br>
{{ config('app.name') }}
</x-mail::message>