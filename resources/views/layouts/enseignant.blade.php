<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Plateforme d'enseignement en ligne E-Taalim" />
    <meta name="author" content="E-Taalim" />
    <title>@yield('title') - E-Taalim</title>
    <link href="{{ asset('css/modern-purple.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    @yield('styles')
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-purple">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('enseignant.dashboard') }}">
            <strong>E-Taalim</strong>
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        
        <!-- Navbar Search-->
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Rechercher..." aria-label="Rechercher..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </div>
        
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('storage/profile_photos/default-teacher.jpg') }}" alt="Photo de profil" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Mon profil</a></li>
                    <li><a class="dropdown-item" href="#!">Paramu00e8tres</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Du00e9connexion</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark bg-purple" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Interface Enseignant</div>
                        <a class="nav-link" href="{{ route('enseignant.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Tableau de bord
                        </a>
                        
                        <a class="nav-link" href="{{ route('enseignant.modules.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Mes modules
                        </a>
                        
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                            Devoirs & Examens
                        </a>
                        
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                            Mes u00e9tudiants
                        </a>
                        
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                            Emploi du temps
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Communication</div>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                            Messages
                            <span class="badge bg-danger ms-2">3</span>
                        </a>
                        
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                            Notifications
                            <span class="badge bg-warning ms-2">5</span>
                        </a>
                        
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                            Annonces
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Connectu00e9 en tant que:</div>
                    Enseignant
                </div>
            </nav>
        </div>
        
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; E-Taalim 2025</div>
                        <div>
                            <a href="#">Politique de confidentialitu00e9</a>
                            &middot;
                            <a href="#">Conditions d'utilisation</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    @yield('scripts')
</body>
</html>
