@'
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Data Buku') - Praktikum PPWL</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('sbadmin/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link href="{{ asset('lightbox2/dist/css/lightbox.min.css') }}" rel="stylesheet">

    <style>
        html { font-size: 16px; }
        body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; font-size: 1rem; overflow-x: hidden; }
        .sb-topnav { height: 56px; font-size: 1rem; z-index: 1039; }
        .sb-topnav .navbar-brand { width: 225px; font-size: 1.125rem; font-weight: 600; margin-right: 0; flex-shrink: 0; }
        #sidebarToggle { color: rgba(255, 255, 255, .85); text-decoration: none; }
        #sidebarToggle:hover { color: #fff; }
        #layoutSidenav { display: flex; width: 100%; }
        #layoutSidenav #layoutSidenav_nav { flex-basis: 225px; flex-shrink: 0; width: 225px; z-index: 1038; transition: transform .15s ease-in-out; transform: translateX(-225px); }
        #layoutSidenav #layoutSidenav_content { position: relative; display: flex; flex-direction: column; justify-content: space-between; flex: 1 1 auto; min-width: 0; width: 100%; min-height: calc(100vh - 56px); margin-left: -225px; transition: margin .15s ease-in-out; }
        #layoutSidenav_content main { flex-grow: 1; min-width: 0; width: 100%; }
        #layoutSidenav_content main > .container-fluid { width: 100%; max-width: 100%; }
        .sb-sidenav { display: flex; flex-direction: column; width: 225px; height: 100%; background-color: #212529; color: #fff; }
        .sb-sidenav-menu { flex-grow: 1; }
        .sb-sidenav-menu .nav { display: flex; flex-direction: column; flex-wrap: nowrap; }
        .sb-sidenav-menu-heading { padding: 1.75rem 1rem .75rem; font-size: .75rem; font-weight: 700; text-transform: uppercase; color: rgba(255, 255, 255, .5); }
        .sb-sidenav .nav-link { display: flex; align-items: center; padding: .75rem 1rem; font-size: .95rem; color: rgba(255, 255, 255, .65); text-decoration: none; }
        .sb-sidenav .nav-link:hover { color: #fff; background-color: rgba(255, 255, 255, .05); }
        .sb-sidenav .nav-link.active { color: #fff; background-color: rgba(255, 255, 255, .08); }
        .sb-nav-link-icon { margin-right: .65rem; color: rgba(255, 255, 255, .5); }
        .sb-sidenav .nav-link.active .sb-nav-link-icon { color: #fff; }
        .sb-sidenav-footer { padding: .75rem; background-color: #343a40; color: #fff; font-size: .875rem; overflow-wrap: anywhere; }
        .sb-sidenav-footer .small { color: rgba(255, 255, 255, .6); }
        .card { width: 100%; min-width: 0; border-radius: .5rem; }
        .card-body { min-width: 0; }
        .table-responsive { display: block; width: 100%; max-width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table th, .table td { vertical-align: middle; }
        body.sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav { transform: translateX(0); }

        @media (min-width: 992px) {
            #layoutSidenav #layoutSidenav_nav { position: relative; transform: translateX(0); }
            #layoutSidenav #layoutSidenav_content { margin-left: 0; width: auto; }
            body.sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav { transform: translateX(-225px); }
            body.sb-sidenav-toggled #layoutSidenav #layoutSidenav_content { margin-left: -225px; }
        }

        @media (max-width: 991.98px) {
            .sb-topnav .navbar-brand { width: auto; max-width: 55%; font-size: 1rem; margin-right: .5rem; }
            #layoutSidenav { display: block; width: 100%; }
            #layoutSidenav #layoutSidenav_nav { position: fixed; top: 56px; left: 0; bottom: 0; width: 225px; height: calc(100vh - 56px); transform: translateX(-225px); z-index: 1038; }
            body.sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav { transform: translateX(0); }
            #layoutSidenav #layoutSidenav_content, body.sb-sidenav-toggled #layoutSidenav #layoutSidenav_content { margin-left: 0 !important; width: 100%; min-width: 0; }
            #layoutSidenav_content main { width: 100%; min-width: 0; }
            #layoutSidenav_content main > .container-fluid { width: 100%; max-width: 100%; padding: 16px !important; }
            h1 { font-size: 1.5rem; }
            .card, .card-body { min-width: 0; }
            .card { width: 100%; }
            .card-header { flex-wrap: wrap; gap: .5rem; }
            .table-responsive { width: 100%; max-width: 100%; overflow-x: auto; }
            .table-responsive .table { min-width: 600px; font-size: .875rem; }
            .pagination { flex-wrap: wrap; }
            footer .container-fluid { padding: 1rem !important; }
        }

        @media (max-width: 575.98px) {
            .sb-topnav .navbar-brand { font-size: .95rem; }
            .sb-topnav .navbar-brand i { margin-right: .25rem !important; }
            #layoutSidenav_content main > .container-fluid { padding: 12px !important; }
            h1 { font-size: 1.35rem; }
            .breadcrumb { font-size: .85rem; }
            .card-header h5 { font-size: 1rem; }
            .card-body { padding: 12px; }
            .btn-sm { font-size: .8rem; }
            .table { font-size: .8rem; }
        }
    </style>

    @stack('styles')
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="{{ route('home') }}">
            <i class="fas fa-book-open me-2"></i>Data Buku
        </a>

        <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0" id="sidebarToggle" type="button"
                aria-label="Buka atau tutup sidebar" aria-controls="layoutSidenav_nav" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            @auth
            {{-- Tugas 4: Badge & Tombol Tandai Semua Dibaca pada Navbar Admin --}}
            @if (Auth::user()?->isAdmin())
            <li class="nav-item dropdown me-2">
                <a class="nav-link dropdown-toggle" id="notifDropdown" href="#" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    @if (Auth::user()->unreadNotifications->count())
                        <span class="badge bg-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notifDropdown" style="min-width: 210px;">
                    <form action="{{ route('notifikasi.baca') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                            Tandai semua dibaca
                        </button>
                    </form>
                </div>
            </li>
            @endif

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" class="rounded-circle me-1" width="24" height="24" alt="avatar" referrerpolicy="no-referrer">
                    @else
                        <i class="fas fa-user-circle me-1"></i>
                    @endif
                    <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <span class="dropdown-item-text small text-muted">{{ Auth::user()->name }}</span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            @endauth
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>

                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <a class="nav-link {{ request()->routeIs('buku.*') && !request()->routeIs('buku.list') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Data Buku
                        </a>

                        <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-images"></i></div>
                            Gallery
                        </a>

                        <a class="nav-link {{ request()->routeIs('buku.list') || request()->routeIs('galeri.buku') ? 'active' : '' }}" href="{{ route('buku.list') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Daftar Buku
                        </a>

                        {{-- Latihan 1: Menu Sidebar Pengajuan Peminjaman --}}
                        <a class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-reader"></i></div>
                            Pengajuan Peminjaman
                        </a>

                        @if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->level == 'admin'))
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Data User
                        </a>
                        @endif
                    </div>
                </div>

                <div class="sb-sidenav-footer">
                    <div class="small">Masuk sebagai:</div>
                    @auth
                        {{ Auth::user()->name }} ({{ Auth::user()->role ?? Auth::user()->level ?? 'user' }})
                    @endauth
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-4">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="small text-muted">
                        Praktikum Pemrograman Web 2 - Zalfa Ajeng Suardafa
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lightbox2/dist/js/lightbox-plus-jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');

            if (sidebarToggle) {
                const updateSidebarState = function () {
                    const isMobile = window.innerWidth < 992;
                    const isToggled = document.body.classList.contains('sb-sidenav-toggled');
                    const isOpen = isMobile ? isToggled : !isToggled;
                    sidebarToggle.setAttribute('aria-expanded', String(isOpen));
                };

                sidebarToggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    updateSidebarState();
                });

                window.addEventListener('resize', updateSidebarState);
                updateSidebarState();
            }

            if (window.jQuery && typeof jQuery.fn.datepicker === 'function') {
                $('.date').datepicker({
                    format: 'yyyy/mm/dd',
                    autoclose: true
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
'@ | Set-Content -Path "resources\views\layouts\master.blade.php" -Encoding UTF8