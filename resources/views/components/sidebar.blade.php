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
        padding: 15px 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar .logo img {
        height: 30px;
        margin-right: 10px;
    }

    .sidebar .logo span {
        font-size: 18px;
        font-weight: 600;
        color: white;
    }

    .sidebar a {
        color: white;
        display: flex;
        align-items: center;
        padding: 15px 20px;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 5px;
    }

    .sidebar a i {
        margin-right: 15px;
        width: 20px;
        text-align: center;
        font-size: 20px;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: white;
        color: #8668FF;
        border-radius: 0 30px 30px 0;
    }

    .sidebar.collapsed {
        width: 70px;
    }

    .sidebar.collapsed .logo span {
        display: none;
    }

    .sidebar.collapsed a span {
        display: none;
    }

    .sidebar.collapsed a {
        justify-content: center;
        padding: 15px;
    }

    .sidebar.collapsed a i {
        margin-right: 0;
    }

    .content-wrapper {
        margin-left: 250px;
        transition: all 0.3s ease;
        padding: 20px;
        min-height: calc(100vh - 60px);
    }

    .content-wrapper.collapsed {
        margin-left: 70px;
    }

    .toggle-btn {
        position: absolute;
        right: -10px;
        top: 15px;
        background: white;
        color: #8668FF;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        z-index: 1100;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 70px;
        }

        .sidebar .logo span,
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
        <div class="d-flex align-items-center p-3 mb-3">
            <img src="{{ asset('images/logo-placeholder.jpg') }}" alt="E-Taalim Logo" width="35" height="35" class="me-2">
            <span class="fw-bold">E-Taalim</span>
        </div>
    </div>
    
    <div class="sidebar-links">
        <a href="{{ route('enseignant.dashboard') }}" class="{{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> <span>Ressources Pédagogiques</span>
        </a>
        <a href="{{ route('enseignant.dashboard') }}" class="{{ request()->routeIs('enseignant.calendar') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> <span>Calendrier</span>
        </a>
        <a href="{{ route('enseignant.messages') }}" class="{{ request()->routeIs('enseignant.messages') ? 'active' : '' }}">
            <i class="bi bi-chat"></i> <span>Messagerie</span>
        </a>
        <a href="{{ route('enseignant.dashboard') }}" class="{{ request()->routeIs('enseignant.students') ? 'active' : '' }}">
            <i class="bi bi-people"></i> <span>Etudiants</span>
        </a>
        <a href="{{ route('enseignant.profil') }}" class="{{ request()->routeIs('enseignant.profil') ? 'active' : '' }}">
            <i class="bi bi-person"></i> <span>Profil</span>
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> <span>Se Déconnecter</span>
        </a>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const contentWrapper = document.getElementById('content-wrapper');
        const toggleBtn = document.querySelector('.toggle-btn i');
        
        sidebar.classList.toggle('collapsed');
        if (contentWrapper) {
            contentWrapper.classList.toggle('collapsed');
        }
        
        // Change l'icône du bouton toggle
        if (sidebar.classList.contains('collapsed')) {
            toggleBtn.classList.remove('fa-chevron-left');
            toggleBtn.classList.add('fa-chevron-right');
        } else {
            toggleBtn.classList.remove('fa-chevron-right');
            toggleBtn.classList.add('fa-chevron-left');
        }
        
        // Sauvegarder l'état dans le localStorage
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }

    // Restaurer l'état de la sidebar au chargement de la page
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
