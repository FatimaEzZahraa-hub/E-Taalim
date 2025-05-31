@props(['activeRoute' => ''])

<style>
    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #8668FF;
        color: white;
        position: fixed;
        transition: all 0.3s ease;
        z-index: 1030;
        left: 0;
        top: 0;
        padding-top: 0;
        display: flex;
        flex-direction: column;
    }

    .sidebar .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        margin-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar .logo img {
        height: 30px;
        margin-right: 10px;
    }

    .sidebar .logo span {
        font-size: 20px;
        font-weight: 700;
        color: white;
    }

    .sidebar .subtitle {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.7);
        text-align: center;
        margin-top: -5px;
        margin-bottom: 20px;
    }

    .sidebar a {
        color: white;
        display: flex;
        align-items: center;
        padding: 12px 20px;
        text-decoration: none;
        transition: all 0.3s ease;
        margin: 5px 10px;
        border-radius: 10px;
    }

    .sidebar a i {
        margin-right: 15px;
        width: 20px;
        text-align: center;
        font-size: 18px;
    }

    .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar a.active {
        background-color: white;
        color: #8668FF;
        font-weight: 600;
    }

    .sidebar-links {
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    


    @media (max-width: 768px) {
        .sidebar {
            width: 70px;
        }

        .sidebar .logo span,
        .sidebar .subtitle,
        .sidebar a span {
            display: none;
        }

        .sidebar a {
            justify-content: center;
            padding: 15px;
        }

        .sidebar a i {
            margin-right: 0;
        }

        .content-wrapper {
            margin-left: 70px;
        }
    }
</style>

<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo-placeholder.jpg') }}" alt="E-Taalim Logo" width="35" height="35" class="me-2">
        <span>E-Taalim</span>
    </div>
    <div class="subtitle">Interface Enseignant</div>
    
    <div class="sidebar-links">
        <a href="{{ route('enseignant.dashboard') }}" class="{{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> <span>Tableau de bord</span>
        </a>
        <a href="{{ route('enseignant.cours') }}" class="{{ request()->routeIs('enseignant.cours') ? 'active' : '' }}">
            <i class="bi bi-book"></i> <span>Cours</span>
        </a>
        <a href="{{ route('enseignant.etudiants') }}" class="{{ request()->routeIs('enseignant.etudiants') ? 'active' : '' }}">
            <i class="bi bi-mortarboard"></i> <span>Étudiants</span>
        </a>
        <a href="{{ route('enseignant.calendrier') }}" class="{{ request()->routeIs('enseignant.calendrier') ? 'active' : '' }}">
            <i class="bi bi-calendar-event"></i> <span>Événements</span>
        </a>
        <a href="{{ route('enseignant.messages') }}" class="{{ request()->routeIs('enseignant.messages') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> <span>Messages</span>
        </a>
        <a href="{{ route('enseignant.notifications') }}" class="{{ request()->routeIs('enseignant.notifications') ? 'active' : '' }}">
            <i class="bi bi-bell"></i> <span>Notifications</span>
        </a>
        <a href="{{ route('enseignant.profil') }}" class="{{ request()->routeIs('enseignant.profil') ? 'active' : '' }}">
            <i class="bi bi-person"></i> <span>Profil</span>
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> <span>Déconnexion</span>
        </a>
    </div>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const contentWrapper = document.getElementById('content-wrapper');
        const toggleBtn = document.querySelector('.toggle-btn i');
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            if (contentWrapper) {
                contentWrapper.classList.add('collapsed');
            }
            toggleBtn.classList.remove('fa-chevron-left');
            toggleBtn.classList.add('fa-chevron-right');
        }
    });
</script>
