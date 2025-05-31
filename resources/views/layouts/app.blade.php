<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'E-Taalim | Plateforme educative')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logoe-taalim.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logoe-taalim.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logoe-taalim.png') }}">
    <link rel="mask-icon" href="{{ asset('images/logoe-taalim.png') }}" color="#7B57F9">
    <meta name="theme-color" content="#7B57F9">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/logoe-taalim.png') }}" alt="Logo E-Taalim" style="height:40px; width:auto; margin-right:10px;">
                <span class="gradient-text fw-bold">E-Taalim</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Accueil</a>
                    </li>
                    @if (!request()->routeIs('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="#fonctionnalites">Fonctionnalités</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contactez-nous</a>
                    </li>
                    @if (!request()->routeIs('login'))
                    <li class="nav-item ms-lg-2">
                        <a class="main-btn btn rounded-pill px-4 py-2" href="{{ route('login') }}">Se connecter</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
