@extends('layouts.admin')

@section('title', 'Paramètres')

@section('page_title', 'Paramètres')

@section('content')
<div class="container-fluid" style="max-width: 1400px;">
    <div class="row">
        <!-- Colonne pour la navigation des paramètres -->
        <div class="col-md-3">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Menu Paramètres</h6>
                </div>
                <div class="card-body p-0">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-general-tab" data-bs-toggle="pill" href="#v-pills-general" role="tab" aria-controls="v-pills-general" aria-selected="true">
                            <i class="fas fa-cog me-2"></i> Paramètres Généraux
                        </a>
                        <a class="nav-link" id="v-pills-notifications-tab" data-bs-toggle="pill" href="#v-pills-notifications" role="tab" aria-controls="v-pills-notifications" aria-selected="false">
                            <i class="fas fa-bell me-2"></i> Notifications
                        </a>
                        <a class="nav-link" id="v-pills-privacy-tab" data-bs-toggle="pill" href="#v-pills-privacy" role="tab" aria-controls="v-pills-privacy" aria-selected="false">
                            <i class="fas fa-shield-alt me-2"></i> Confidentialité
                        </a>
                        <a class="nav-link" id="v-pills-display-tab" data-bs-toggle="pill" href="#v-pills-display" role="tab" aria-controls="v-pills-display" aria-selected="false">
                            <i class="fas fa-desktop me-2"></i> Affichage
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Colonne pour le contenu des paramètres -->
        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                <!-- Paramètres généraux -->
                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Paramètres Généraux</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update-general') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="site_name" class="form-label"><i class="fas fa-globe me-2"></i> Nom du site</label>
                                    <input type="text" class="form-control form-control-lg" id="site_name" name="site_name" value="E-Taalim">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label"><i class="fas fa-envelope me-2"></i> Email de contact</label>
                                    <input type="email" class="form-control form-control-lg" id="contact_email" name="contact_email" value="{{ $admin->email }}">
                                </div>
                                

                                
                                <div class="mb-3">
                                    <label for="timezone" class="form-label"><i class="fas fa-clock me-2"></i> Fuseau horaire</label>
                                    <select class="form-select form-select-lg" id="timezone" name="timezone">
                                        <option value="Africa/Casablanca" {{ session('app_timezone') == 'Africa/Casablanca' || !session('app_timezone') ? 'selected' : '' }}>Casablanca (GMT+1)</option>
                                        <option value="Europe/Paris" {{ session('app_timezone') == 'Europe/Paris' ? 'selected' : '' }}>Paris (GMT+2)</option>
                                        <option value="UTC" {{ session('app_timezone') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-1"></i> Enregistrer les paramètres
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Paramètres de notifications -->
                <div class="tab-pane fade" id="v-pills-notifications" role="tabpanel" aria-labelledby="v-pills-notifications-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Paramètres de Notifications</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update-notifications') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label">Notifications par email</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="email_new_message" name="email_notifications[new_message]" checked>
                                        <label class="form-check-label" for="email_new_message">Nouveaux messages</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="email_new_course" name="email_notifications[new_course]" checked>
                                        <label class="form-check-label" for="email_new_course">Nouveaux cours soumis</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="email_new_complaint" name="email_notifications[new_complaint]" checked>
                                        <label class="form-check-label" for="email_new_complaint">Nouvelles plaintes</label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Notifications du système</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="system_new_user" name="system_notifications[new_user]" checked>
                                        <label class="form-check-label" for="system_new_user">Nouveaux utilisateurs</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="system_new_event" name="system_notifications[new_event]" checked>
                                        <label class="form-check-label" for="system_new_event">Nouveaux événements</label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Enregistrer les paramètres
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Paramètres de confidentialité -->
                <div class="tab-pane fade" id="v-pills-privacy" role="tabpanel" aria-labelledby="v-pills-privacy-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Paramètres de Confidentialité</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update-privacy') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label">Sécurité du compte</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="two_factor_auth" name="privacy[two_factor_auth]">
                                        <label class="form-check-label" for="two_factor_auth">Activer l'authentification à deux facteurs</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activity_log" name="privacy[activity_log]" checked>
                                        <label class="form-check-label" for="activity_log">Enregistrer l'historique de connexion</label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="session_timeout" class="form-label">Durée de session (en minutes)</label>
                                    <input type="number" class="form-control" id="session_timeout" name="privacy[session_timeout]" value="60" min="15" max="480">
                                    <div class="form-text">La session sera automatiquement fermée après cette période d'inactivité.</div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Enregistrer les paramètres
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Paramètres d'affichage -->
                <div class="tab-pane fade" id="v-pills-display" role="tabpanel" aria-labelledby="v-pills-display-tab">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Paramètres d'Affichage</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update-display') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="theme" class="form-label">Thème</label>
                                    <select class="form-select" id="theme" name="display[theme]">
                                        <option value="light" selected>Clair</option>
                                        <option value="dark">Sombre</option>
                                        <option value="auto">Automatique (selon système)</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="sidebar_color" class="form-label">Couleur de la barre latérale</label>
                                    <select class="form-select" id="sidebar_color" name="display[sidebar_color]">
                                        <option value="dark" selected>Sombre</option>
                                        <option value="light">Claire</option>
                                        <option value="primary">Bleue</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="items_per_page" class="form-label">Éléments par page</label>
                                    <select class="form-select" id="items_per_page" name="display[items_per_page]">
                                        <option value="10" selected>10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Enregistrer les paramètres
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
