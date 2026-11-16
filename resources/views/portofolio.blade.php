<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portofolio - Zalfa Ajeng Suardafa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/lux/bootstrap.min.css">
    <link href="{{ asset('lightbox2/dist/css/lightbox.min.css') }}" rel="stylesheet">
    <style>
        .hero { background: linear-gradient(135deg, #1a1a1a 0%, #4b4b4b 100%); color: #fff; padding: 110px 0; }
        .foto-galeri { width: 100%; height: 190px; object-fit: cover; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#beranda">Portofolio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuUtama">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="#buku">Buku</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
            </ul>
        </div>
    </div>
</nav>

<header id="beranda" class="hero text-center">
    <div class="container">
        <h1 class="display-4">Zalfa Ajeng Suardafa</h1>
        <p class="lead mb-4">Mahasiswa D-IV Teknologi Rekayasa Perangkat Lunak, Sekolah Vokasi UGM</p>
        <a href="#galeri" class="btn btn-light btn-lg">Lihat Galeri</a>
    </div>
</header>

<section id="galeri" class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center">Galeri</h2>
        <div class="row g-3">
            @forelse ($galleries as $gallery)
                <div class="col-6 col-md-3">
                    <a href="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                       data-lightbox="portofolio" data-title="{{ $gallery->title }}">
                        <img class="foto-galeri rounded shadow-sm"
                             src="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                             alt="{{ $gallery->title }}">
                    </a>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada foto.</p>
            @endforelse
        </div>
    </div>
</section>

<section id="buku" class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 text-center">Buku</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse ($bukus as $buku)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $buku->judul }}</h5>
                            <p class="card-text text-muted mb-0">{{ $buku->penulis }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada buku.</p>
            @endforelse
        </div>
    </div>
</section>

<footer class="py-4 bg-dark text-white text-center small">
    Praktikum Pemrograman Web 2
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('lightbox2/dist/js/lightbox-plus-jquery.min.js') }}"></script>
</body>
</html>