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
                        <a href="http://127.0.0.1:8000/login" class="main-btn btn rounded-pill px-4 py-2">Se connecter</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @auth
            @if(!request()->is('/'))
                <div class="container-fluid">
                    <div class="row">
                        <!-- Sidebar -->
                        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                            <div class="position-sticky pt-3">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}" href="{{ route('etudiant.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('etudiant.cours*') ? 'active' : '' }}" href="{{ route('etudiant.cours') }}">
                                            <i class="bi bi-book me-2"></i> Cours
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('etudiant.devoirs*') ? 'active' : '' }}" href="{{ route('etudiant.devoirs') }}">
                                            <i class="bi bi-file-earmark-text me-2"></i> Devoirs
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('etudiant.examens*') ? 'active' : '' }}" href="{{ route('etudiant.examens') }}">
                                            <i class="bi bi-calendar-event me-2"></i> Examens
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('etudiant.messages*') ? 'active' : '' }}" href="{{ route('etudiant.messages') }}">
                                            <i class="bi bi-envelope me-2"></i> Messages
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('etudiant.calendrier') ? 'active' : '' }}" href="{{ route('etudiant.calendrier') }}">
                                            <i class="bi bi-calendar3 me-2"></i> Calendrier
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('etudiant.notifications') ? 'active' : '' }}" href="{{ route('etudiant.notifications') }}">
                                            <i class="bi bi-bell me-2"></i> Notifications
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('etudiant.profil*') ? 'active' : '' }}" href="{{ route('etudiant.profil') }}">
                                            <i class="bi bi-person me-2"></i> Profil
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="nav-link border-0 bg-transparent">
                                                <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Main content area -->
                        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                            @yield('content')
                        </div>
                    </div>
                </div>
            @else
                @yield('content')
            @endif
        @else
            @yield('content')
        @endauth
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
