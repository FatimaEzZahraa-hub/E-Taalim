<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/svg+xml">
  <title>{{ $title ?? 'E-Taalim' }}</title>
  
  <!-- le script qui active le menu responsive de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  @stack('styles')
  
  <style>
    :root {
      --primary: #8668FF;
      --primary-dark: #6A4EFF;
      --primary-light: #A28AFF;
      --secondary: #e1b300;
      --text-dark: #2d3436;
      --text-light: #636e72;
      --background: #f8f9fa;
      --white: #ffffff;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--background);
      color: var(--text-dark);
      padding-top: 76px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      margin: 0;
      line-height: 1.6;
    }

    main {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding-bottom: 0;
    }

    /* Navbar Styling */
    .navbar {
      background-color: var(--white);
      border-bottom: 1px solid rgba(0,0,0,0.05);
      padding: 1rem 0;
      transition: all 0.3s ease;
    }

    .navbar.scrolled {
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
      padding: 0.7rem 0;
    }

    .navbar-brand {
      font-weight: 800;
      font-size: 1.4rem;
      color: var(--primary) !important;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .navbar-brand img {
      transition: transform 0.3s ease;
    }

    .navbar-brand:hover img {
      transform: rotate(-5deg);
    }

    .nav-link {
      font-weight: 600;
      color: var(--text-dark) !important;
      padding: 0.5rem 1rem !important;
      position: relative;
      transition: all 0.3s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }

    .nav-link:hover {
      color: var(--primary) !important;
    }

    .nav-link:hover::after {
      width: 80%;
    }

    /* Buttons */
    .btn {
      padding: 0.6rem 1.5rem;
      border-radius: 8px;
      font-weight: 600;
      letter-spacing: 0.3px;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background: var(--primary);
      border-color: var(--primary);
      box-shadow: 0 4px 15px rgba(134, 104, 255, 0.2);
    }

    .btn-primary:hover {
      background: var(--primary-dark);
      border-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(134, 104, 255, 0.3);
    }

    .btn-outline-light {
      border: 2px solid var(--primary);
      color: var(--primary) !important;
    }

    .btn-outline-light:hover {
      background: var(--primary);
      color: var(--white) !important;
      transform: translateY(-2px);
    }

    /* Custom Navbar Toggler */
    .navbar-toggler {
      border: none;
      padding: 0;
      width: 30px;
      height: 30px;
      position: relative;
    }

    .navbar-toggler:focus {
      box-shadow: none;
    }

    .navbar-toggler-icon {
      background-image: none;
      background-color: var(--primary);
      height: 2px;
      width: 100%;
      position: absolute;
      top: 50%;
      transition: all 0.3s ease;
    }

    .navbar-toggler-icon::before,
    .navbar-toggler-icon::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 2px;
      background-color: var(--primary);
      transition: all 0.3s ease;
    }

    .navbar-toggler-icon::before {
      top: -8px;
    }

    .navbar-toggler-icon::after {
      bottom: -8px;
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
      background-color: transparent;
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
      transform: rotate(45deg);
      top: 0;
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
      transform: rotate(-45deg);
      bottom: 0;
    }

    /* Sections */
    section {
      padding: 5rem 0;
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--primary);
      margin-bottom: 1rem;
      position: relative;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 3px;
      background: var(--primary);
      border-radius: 2px;
    }

    /* Cards */
    .card {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    /* Content Wrapper (for sidebar) */
    .content-wrapper {
      margin-left: 220px;
      transition: all 0.3s ease;
      padding: 30px;
      min-height: calc(100vh - 76px);
    }

    .content-wrapper.collapsed {
      margin-left: 60px;
    }

    @media (max-width: 768px) {
      .content-wrapper {
        margin-left: 0;
        padding: 15px;
      }
      
      .content-wrapper.collapsed {
        margin-left: 0;
      }
    }
    
    /* Dashboard Stats */
    .stat-card {
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      height: 100%;
    }
    
    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
      font-size: 2.5rem;
      margin-bottom: 15px;
      color: var(--primary);
    }
    
    .stat-title {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--text-light);
      margin-bottom: 5px;
    }
    
    .stat-value {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 0;
    }
    
    /* Footer */
    footer {
      background-color: var(--primary);
      color: var(--white);
      padding: 4rem 0 2rem;
    }

    .footer-title {
      font-weight: 700;
      margin-bottom: 1.5rem;
      font-size: 1.2rem;
    }

    .footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-links li {
      margin-bottom: 0.8rem;
    }

    .footer-links a {
      color: rgba(255,255,255,0.8);
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .footer-links a:hover {
      color: var(--white);
      padding-left: 5px;
    }

    /* Animations */
    .fade-up {
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.6s ease;
    }

    .fade-up.visible {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
  @yield('styles')
  
  <style>
    /* Styles pour les boutons d'action */
    .btn-action {
      background-color: var(--primary);
      color: white;
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
      font-weight: 500;
      border: none;
      transition: all 0.3s ease;
    }
    
    .btn-action:hover, .btn-action:focus {
      background-color: var(--primary-dark);
      color: white;
      box-shadow: 0 4px 10px rgba(134, 104, 255, 0.3);
      transform: translateY(-2px);
    }
    
    /* Styles pour la messagerie */
    .message-item {
      transition: all 0.2s ease;
      position: relative;
    }
    
    .message-item:hover {
      background-color: rgba(134, 104, 255, 0.05);
    }
    
    .message-unread {
      background-color: rgba(134, 104, 255, 0.08);
    }
    
    .message-read {
      background-color: transparent;
    }
    
    .message-actions {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .delete-btn {
      opacity: 0.5;
      transition: all 0.2s ease;
    }
    
    .message-item:hover .delete-btn {
      opacity: 1;
    }
    
    /* Different layout styles for teacher vs public pages */
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
      min-height: 100vh;
    }
    
    /* Teacher layout - no top padding */
    body.teacher-layout {
      padding-top: 0 !important;
      display: flex;
    }
    
    /* Public layout - with top navbar */
    body.public-layout {
      padding-top: 76px;
    }
    
    /* Content wrapper for teacher pages */
    .teacher-content {
      margin-left: 250px;
      width: calc(100% - 250px);
      min-height: 100vh;
      padding: 20px 30px;
      background-color: #f8f9fa;
    }
    
    /* Header styles */
    .teacher-header {
      margin-bottom: 25px;
    }
    
    .teacher-header .page-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #333;
      margin: 0;
    }
    
    .notification-bell a {
      font-size: 1.2rem;
      color: #555;
      transition: all 0.3s ease;
    }
    
    .notification-bell a:hover {
      color: #8668FF;
    }
    
    .user-avatar {
      border: 2px solid #8668FF;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .user-info {
      font-size: 0.9rem;
    }
    
    /* Content wrapper for public pages */
    .public-content {
      width: 100%;
      min-height: calc(100vh - 76px);
    }
  </style>
</head>

@if(request()->is('enseignant*'))
<!-- Teacher Layout - No top navbar, only sidebar -->
<body class="teacher-layout">
  <!-- Sidebar Component -->
  <x-sidebar activeRoute="{{ request()->route()->getName() }}" />
  
  <!-- Main Content -->
  <div class="teacher-content">
    <!-- Header -->
    <div class="teacher-header mb-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div class="header-title">
              <h1 class="page-title mb-0">@yield('title', 'Tableau de bord')</h1>
            </div>
            <div class="header-actions d-flex align-items-center">
              <div class="notification-bell me-4 position-relative">
                <a href="#" class="text-dark">
                  <i class="bi bi-bell-fill fs-5"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    2
                  </span>
                </a>
              </div>
              <div class="user-profile">
                <a href="{{ route('enseignant.profil') }}" class="user-avatar rounded-circle overflow-hidden d-block" style="width: 40px; height: 40px;">
                  <img src="{{ asset('images/user-placeholder.jpg') }}" alt="User Profile" class="w-100 h-100" style="object-fit: cover;" onerror="this.src='https://ui-avatars.com/api/?name=US&background=8668FF&color=fff'">
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Flash Messages -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    <!-- Main Content -->
    @yield('content')
  </div>
@else
<!-- Public Layout - With top navbar -->
<body class="public-layout">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="35" height="35" onerror="this.src='{{ asset('images/logo-placeholder.jpg') }}'">
        E-Taalim
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavbar" aria-controls="menuNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNavbar">
        <ul class="navbar-nav ms-auto">
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">
                <i class="bi bi-person-plus me-1"></i>Inscription
              </a>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
              </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          @endguest
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Main Content -->
  <div class="public-content container py-4">
    <!-- Flash Messages -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    <!-- Main Content -->
    @yield('content')
  </div>
@endif
        
  <!-- JavaScript pour animations -->
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (navbar && window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else if (navbar) {
        navbar.classList.remove('scrolled');
      }
    });

    // Fade up animation
    document.addEventListener("DOMContentLoaded", function() {
      const fadeElements = document.querySelectorAll('.fade-up');
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });
      
      fadeElements.forEach(element => {
        observer.observe(element);
      });
    });
  </script>

  @stack('scripts')
  <!-- Scripts additionnels -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  @yield('scripts')
</body>
</html>
