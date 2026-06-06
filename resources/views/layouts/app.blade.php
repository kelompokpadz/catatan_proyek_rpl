<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Catatan Proyek RPL')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; }
        .navbar { box-shadow: 0 4px 6px rgba(0,0,0,.1); }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,.05); }
    </style>
</head>
<body>

    <!-- Navbar hanya muncul jika user sudah login -->
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-journal-code"></i> Catatan Proyek RPL
            </a>
            <div class="collapse navbar-collapse">
               <ul class="navbar-nav ms-auto align-items-center">
    <!-- TAMBAHKAN LINK INI -->
    <li class="nav-item me-3">
        <a class="nav-link text-light fw-semibold" href="{{ route('proyek.index') }}">
            <i class="bi bi-list-task"></i> Proyek Saya
        </a>
    </li>

    <li class="nav-item me-3">
        <a class="nav-link text-light fw-semibold" href="{{ route('laporan') }}">
            <i class="bi bi-file-earmark-pdf"></i> Laporan
        </a>
    </li>
    
    <li class="nav-item me-3">
        <span class="text-light"><i class="bi bi-person-circle"></i> Halo, {{ Auth::user()->name }}</span>
    </li>
    <!-- ... dst (tombol logout) ... -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Konten Utama -->
    <main class="container pb-5">
        <!-- Notifikasi Sukses -->
               @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        {{-- TAMBAHKAN INI UNTUK PESAN ERROR --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>