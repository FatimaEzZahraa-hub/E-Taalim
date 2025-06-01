<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Taalim Admin - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Nouveau design violet clair -->
    <link href="{{ asset('css/modern-purple.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #8668FF;
            --secondary-color: #7559e8;
            --accent-color: #9a81ff;
            --dark-color: #1a1b41;
            --light-color: #f8f9fa;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --danger-color: #ff4d6d;
            --text-color: #333;
            --gray-light: #e9ecef;
            --shadow-sm: 0 .125rem .25rem rgba(0,0,0,.075);
            --shadow-md: 0 .5rem 1rem rgba(0,0,0,.15);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f8fa;
            color: var(--text-color);
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            background: #5a43c5; /* Variante plus foncée de notre couleur principale */
            min-height: 100vh;
            transition: var(--transition);
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            box-shadow: var(--shadow-md);
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h3 {
            color: white;
            margin: 0;
            font-weight: 600;
        }
        
        .sidebar-header p {
            color: rgba(255,255,255,0.7);
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        .nav-menu {
            padding: 15px 0;
        }
        
        .nav-item {
            margin: 5px 15px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 15px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            transition: var(--transition);
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: var(--primary-color);
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            transition: var(--transition);
        }
        
        .top-bar {
            background-color: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            margin: 0;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }
        
        .notification-icon {
            margin-right: 20px;
            position: relative;
            cursor: pointer;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            margin-bottom: 20px;
        }
        
        .card:hover {
            box-shadow: var(--shadow-md);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--gray-light);
            padding: 15px 20px;
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Table Styles */
        .table {
            width: 100%;
            margin-bottom: 0;
        }
        
        .table th {
            font-weight: 600;
            color: var(--dark-color);
            border-top: none;
            vertical-align: middle;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        /* Button Styles */
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        /* Form Styles */
        .form-control {
            border-radius: 6px;
            padding: 10px 15px;
            border: 1px solid var(--gray-light);
        }
        
        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-color);
        }
        
        /* Alert Styles */
        .alert {
            border-radius: 8px;
            padding: 15px 20px;
        }
        
        /* Badge Styles */
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
        }
        
        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                width: 0;
                padding: 0;
            }
            
            .sidebar.active {
                width: 250px;
                padding: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .main-content.active {
                margin-left: 250px;
            }
            
            .toggle-btn {
                display: block;
            }
        }
    </style>
    @yield('styles')
</head>
<body @if(request()->is('admin/notifications') || request()->is('admin/notifications/*')) class="admin-notifications" @endif>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>E-Taalim</h3>
                <p>Interface Administrateur</p>
            </div>
            
            <ul class="nav-menu list-unstyled">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.classes.index') }}" class="nav-link {{ request()->routeIs('admin.classes*') ? 'active' : '' }}">
                        <i class="fas fa-school"></i> Classes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.modules.index') }}" class="nav-link {{ request()->routeIs('admin.modules*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Modules
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Utilisateurs
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.courses.pending') }}" class="nav-link {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i> Cours
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.complaints') }}" class="nav-link {{ request()->routeIs('admin.complaints*') ? 'active' : '' }}">
                        <i class="fas fa-comment-alt"></i> Plaintes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Événements</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.messages') }}" class="nav-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i> Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.notifications') }}" class="nav-link {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
                        <i class="fas fa-bell"></i> Notifications
                    </a>
                </li>
            </ul>
            
            <div class="text-center mt-4 mb-4">
                <a href="#" class="btn btn-outline-light btn-sm" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Messages flash -->
            <div class="container-fluid mt-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-check-circle"></i></strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-circle"></i></strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            
            <div class="top-bar">
                <button type="button" id="sidebarCollapse" class="btn btn-primary d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h4 class="page-title">@yield('page_title')</h4>
                
                <div class="d-flex align-items-center">
                    <div class="notification-icon" id="notificationIcon" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge" id="notificationBadge">0</span>
                    </div>
                    
                    <div class="dropdown">
                        <a href="#" class="text-dark d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @php
                                // Récupérer les informations de l'administrateur
                                $admin_id = auth()->id() ?? 1;
                                $admin = DB::table('users')
                                    ->where('id', $admin_id)
                                    ->select('id', 'email', 'name', 'meta_data')
                                    ->first();
                                    
                                // Extraire les métadonnées
                                if (is_string($admin->meta_data)) {
                                    $metaData = json_decode($admin->meta_data, true) ?: [];
                                } elseif (is_object($admin->meta_data)) {
                                    $metaData = (array) $admin->meta_data;
                                } else {
                                    $metaData = [];
                                }
                            @endphp
                            
                            @php
                                $photo = $metaData['photo'] ?? null;
                                $prenom = $metaData['prenom'] ?? '';
                                $nom = $metaData['nom'] ?? '';
                            @endphp
                            @if($photo)
                                <img src="{{ asset('storage/' . $photo) }}" alt="Admin" class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; font-size: 1rem;">
                                    {{ strtoupper(substr($prenom, 0, 1)) }}{{ strtoupper(substr($nom, 0, 1)) }}
                                </div>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user me-2"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fas fa-cog me-2"></i> Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <!-- Content -->
            @yield('content')
        </div>
    </div>

    <!-- Modal des notifications -->
    <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="notificationsList" class="list-group">
                        <div class="text-center p-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <form action="{{ route('admin.notifications.mark-as-read') }}" method="POST" id="markAllAsReadForm">
                        @csrf
                        <input type="hidden" name="notification_ids" id="notificationIdsInput" value="">
                        <button type="submit" class="btn btn-outline-secondary">Marquer tout comme lu</button>
                    </form>
                    <a href="{{ route('admin.notifications') }}" class="btn btn-primary">Voir toutes les notifications</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <!-- Script pour les notifications -->
    <script>
        // Configuration globale pour les requêtes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).ready(function() {
            // Charger les notifications au chargement de la page
            loadNotifications();
            
            // Charger les notifications lorsque la modal est ouverte
            $('#notificationsModal').on('show.bs.modal', function () {
                loadNotifications();
            });
            
            // Gérer la soumission du formulaire "Marquer tout comme lu"
            $('#markAllAsReadForm').on('submit', function(e) {
                // Récupérer les IDs de toutes les notifications affichées
                var notificationIds = [];
                
                $('.list-group-item').each(function() {
                    var notificationId = $(this).data('notification-id');
                    if (notificationId) {
                        notificationIds.push(notificationId);
                    }
                });
                
                // Si aucune notification, ne pas soumettre le formulaire
                if (notificationIds.length === 0) {
                    e.preventDefault();
                    return false;
                }
                
                // Remplir le champ caché avec les IDs des notifications
                $('#notificationIdsInput').val(JSON.stringify(notificationIds));
            });
            });
            
            // Fonction pour charger les notifications
            function loadNotifications() {
                $.ajax({
                    url: '{{ route("admin.notifications.get-latest") }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Mettre à jour le badge avec le nombre de notifications non lues
                        $('#notificationBadge').text(data.unread_count);
                        
                        // Si aucune notification, afficher un message
                        if (data.notifications.length === 0) {
                            $('#notificationsList').html('<div class="text-center p-3">Aucune notification</div>');
                            return;
                        }
                        
                        // Construire la liste des notifications
                        var notificationsHtml = '';
                        
                        $.each(data.notifications, function(index, notification) {
                            var badgeClass = '';
                            
                            // Définir la classe du badge selon le type de notification
                            if (notification.type === 'maintenance') {
                                badgeClass = 'bg-warning text-dark';
                            } else if (notification.type === 'information') {
                                badgeClass = 'bg-info';
                            } else if (notification.type === 'evenement') {
                                badgeClass = 'bg-primary';
                            } else {
                                badgeClass = 'bg-secondary';
                            }
                            
                            // Créer l'élément de notification
                            notificationsHtml += '<a href="' + notification.url + '" class="list-group-item list-group-item-action' + (notification.est_lu ? '' : ' fw-bold') + '" data-notification-id="' + notification.id + '">';
                            notificationsHtml += '<div class="d-flex justify-content-between align-items-center">';
                            notificationsHtml += '<h6 class="mb-1">' + notification.titre + '</h6>';
                            notificationsHtml += '<span class="badge ' + badgeClass + ' rounded-pill">' + notification.type + '</span>';
                            notificationsHtml += '</div>';
                            notificationsHtml += '<small class="text-muted">' + notification.date_creation + '</small>';
                            notificationsHtml += '</a>';
                        });
                        
                        // Mettre à jour la liste des notifications
                        $('#notificationsList').html(notificationsHtml);
                    },
                    error: function() {
                        $('#notificationsList').html('<div class="alert alert-danger">Erreur lors du chargement des notifications</div>');
                    }
                });
            }
        });
    </script>
    
    <script>
        $(document).ready(function() {
            // Toggle sidebar on mobile
            $('#sidebarCollapse').on('click', function() {
                $('.sidebar').toggleClass('active');
                $('.main-content').toggleClass('active');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
