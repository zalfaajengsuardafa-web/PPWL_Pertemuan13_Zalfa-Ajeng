{{-- Menggunakan layouts.master sebagai kerangka utama halaman. --}}
@extends('layouts.master')

{{-- Mengisi judul halaman pada layout dengan teks "Gallery". --}}
@section('title', 'Gallery')

{{-- Memulai bagian konten utama halaman. --}}
@section('content')

    {{-- Judul halaman. Class mt-2 memberi jarak di bagian atas. --}}
    <h1 class="mt-2">Gallery</h1>

    {{-- Breadcrumb menunjukkan posisi halaman saat ini.
         Dashboard dapat diklik, sedangkan Gallery adalah halaman aktif. --}}
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Gallery</li>
    </ol>

    {{-- Menampilkan pesan sukses yang dikirim melalui session,
         misalnya setelah foto berhasil ditambah, diedit, atau dihapus. --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card menjadi wadah daftar foto pada galeri. --}}
    <div class="card mb-4">

        {{-- Header card menampilkan judul galeri dan tombol tambah foto.
             Class d-flex mengatur keduanya agar berada dalam satu baris. --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-images me-1"></i> Galeri Foto
            </span>

            {{-- Membuka halaman form tambah foto. --}}
            <a href="{{ route('gallery.create') }}"
               class="btn btn-primary btn-sm">
                Tambah Foto
            </a>
        </div>

        <div class="card-body">

            {{-- Row menjadi wadah kolom-kolom foto. --}}
            <div class="row">

                {{-- Jika terdapat data, tampilkan setiap foto.
                     Jika tidak, tampilkan pesan "Tidak ada data.". --}}
                @if (count($galleries) > 0)

                    {{-- Mengulang seluruh data galeri pada halaman saat ini. --}}
                    @foreach ($galleries as $gallery)

                        {{-- Ukuran kolom berubah sesuai lebar layar agar
                             tampilan galeri tetap responsif. --}}
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4 text-center">

                            {{-- Tautan membungkus gambar agar saat diklik
                                 gambar dapat dibuka melalui lightbox.
                                 href menunjuk ke file gambar yang akan dibuka.
                                 data-lightbox="galeri" mengelompokkan foto
                                 dalam satu rangkaian lightbox.
                                 data-title menjadi keterangan pada lightbox. --}}
                            <a class="example-image-link"
                               href="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                               data-lightbox="galeri"
                               data-title="{{ $gallery->description }}">

                                {{-- Menampilkan gambar sebagai thumbnail.
                                     src membentuk URL dari nama file pada
                                     kolom picture. alt menggunakan judul foto
                                     sebagai teks alternatif.

                                     object-fit:cover menjaga ukuran thumbnail
                                     tetap seragam dengan memotong bagian
                                     gambar yang melebihi area tampilan. --}}
                                <img class="example-image img-fluid rounded mb-2"
                                     src="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                                     alt="{{ $gallery->title }}"
                                     style="width:100%;height:150px;object-fit:cover;">
                            </a>

                            {{-- Menampilkan judul foto di bawah thumbnail. --}}
                            <div class="fw-bold">
                                {{ $gallery->title }}
                            </div>

                            {{-- Wadah tombol Edit dan Hapus. --}}
                            <div class="d-flex justify-content-center gap-2 mt-2">

                                {{-- Membuka form edit untuk data galeri
                                     berdasarkan ID foto yang dipilih. --}}
                                <a href="{{ route('gallery.edit', $gallery->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                {{-- Mengirim permintaan untuk menghapus
                                     data galeri berdasarkan ID-nya. --}}
                                <form action="{{ route('gallery.destroy', $gallery->id) }}"
                                      method="POST">

                                    {{-- Token untuk memvalidasi permintaan form. --}}
                                    @csrf

                                    {{-- Form HTML menggunakan POST, lalu Laravel
                                         menafsirkannya sebagai method DELETE. --}}
                                    @method('DELETE')

                                    {{-- Meminta konfirmasi sebelum form dikirim.
                                         Jika pengguna memilih Batal pada dialog,
                                         return false mencegah pengiriman form. --}}
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus foto ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                    @endforeach

                @else

                    {{-- Ditampilkan ketika tidak ada data galeri
                         pada hasil yang diterima view. --}}
                    <h3>Tidak ada data.</h3>

                @endif
            </div>

            {{-- Menampilkan tautan navigasi halaman jika $galleries
                 merupakan hasil pagination dari controller. --}}
            <div class="d-flex">
                {{ $galleries->links() }}
            </div>
        </div>
    </div>

{{-- Mengakhiri bagian konten utama. --}}
@endsection