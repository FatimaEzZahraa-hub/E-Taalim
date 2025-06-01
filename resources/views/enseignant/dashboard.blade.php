@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container py-4"> 
    <!-- Filtre par classe -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('enseignant.dashboard') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="classe_filter" class="form-label fw-bold mb-1">Filtrer par classe:</label>
                        <select name="classe_id" id="classe_filter" class="form-select" style="height: 38px; display: flex; align-items: center;">
                            <option value="">Toutes les classes</option>
                            @foreach($cours->pluck('niveau')->unique() as $niveau)
                                <option value="{{ $niveau }}" {{ request('classe_id') == $niveau ? 'selected' : '' }}>{{ $niveau }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="matiere_filter" class="form-label fw-bold mb-1">Matière:</label>
                        <select name="matiere_id" id="matiere_filter" class="form-select" style="height: 38px; display: flex; align-items: center;">
                            <option value="">Toutes les matières</option>
                            @foreach($cours->pluck('matiere')->unique() as $matiere)
                                <option value="{{ $matiere }}" {{ request('matiere_id') == $matiere ? 'selected' : '' }}>{{ $matiere }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-primary me-2 d-flex align-items-center justify-content-center" style="height: 38px;">
                            <i class="bi bi-funnel me-1"></i> Filtrer
                        </button>
                        <a href="{{ route('enseignant.dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="height: 38px;">
                            <i class="bi bi-arrow-repeat me-1"></i> Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Statistiques et Calendrier -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card bg-white">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-title">COURS</div>
                <div class="stat-value">{{ count($cours) }}</div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="stat-card bg-white">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-title">TRAVAUX & DEVOIRS</div>
                <div class="stat-value">
                    @php
                        $travauxCount = 0;
                        foreach($cours as $c) {
                            $travauxCount += $c->travauxDevoirs->count();
                        }
                        echo $travauxCount;
                    @endphp
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="stat-card bg-white">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="stat-title">EXAMENS</div>
                <div class="stat-value">
                    @php
                        $examensCount = 0;
                        foreach($cours as $c) {
                            $examensCount += $c->examens->count();
                        }
                        echo $examensCount;
                    @endphp
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="stat-card bg-white">
                <div class="stat-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-title">ÉTUDIANTS</div>
                <div class="stat-value">
                    @php
                        $etudiantsCount = 0;
                        foreach($cours as $c) {
                            $etudiantsCount += $c->etudiants->count();
                        }
                        echo $etudiantsCount;
                    @endphp
                </div>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    

    
    <!-- Contenu principal -->
    <div class="row g-4">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Cours récents -->
            <div class="card shadow-sm mb-4 fade-up">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Mes cours récents</h5>
                    <a href="{{ route('enseignant.cours') }}" class="btn btn-sm btn-outline-primary">Voir tous</a>
                </div>
                <div class="card-body p-0">
                    @if(count($cours) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Titre</th>
                                        <th>Niveau</th>
                                        <th>Matière</th>
                                        <th>Étudiants</th>
                                        <th class="text-end pe-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cours->take(5) as $cour)
                                        <tr>
                                            <td class="ps-3 fw-medium">{{ $cour->titre }}</td>
                                            <td>{{ $cour->niveau }}</td>
                                            <td>{{ $cour->matiere }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ $cour->etudiants->count() }} étudiants
                                                </span>
                                            </td>
                                            <td class="text-end pe-3">
                                                <a href="{{ route('enseignant.cours.show', $cour->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('enseignant.cours.edit', $cour->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-courses.svg') }}" alt="Pas de cours" class="img-fluid mb-3" style="max-width: 150px" onerror="this.src='{{ asset('images/logo-placeholder.jpg') }}'">
                            <h5 class="text-muted mb-3">Vous n'avez pas encore de cours</h5>
                            <a href="{{ route('enseignant.cours.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Créer un cours
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activités récentes -->
            <div class="card shadow-sm mb-4 fade-up">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Activités récentes</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-3 d-flex">
                            <div class="me-3">
                                <span class="avatar-circle bg-primary">
                                    <i class="fas fa-book text-white"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1">Nouveau cours ajouté</h6>
                                <p class="mb-1 text-muted">Vous avez créé le cours "Mathématiques Avancées"</p>
                                <small class="text-muted">Il y a 2 jours</small>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex">
                            <div class="me-3">
                                <span class="avatar-circle bg-success">
                                    <i class="fas fa-tasks text-white"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1">Devoir assigné</h6>
                                <p class="mb-1 text-muted">Vous avez assigné le devoir "Exercices d'algèbre" au cours de Mathématiques</p>
                                <small class="text-muted">Il y a 3 jours</small>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex">
                            <div class="me-3">
                                <span class="avatar-circle bg-info">
                                    <i class="fas fa-clipboard-check text-white"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1">Examen programmé</h6>
                                <p class="mb-1 text-muted">Vous avez programmé l'examen "Contrôle final" pour le cours de Physique</p>
                                <small class="text-muted">Il y a 5 jours</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Colonne latérale -->
        <div class="col-lg-4">
            <!-- Actions rapides -->
            <div class="card shadow-sm mb-4 fade-up">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('enseignant.cours.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Ajouter un cours
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle w-100" type="button" id="devoirDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-alt me-2"></i>Créer un devoir
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="devoirDropdown">
                                @forelse($cours as $c)
                                    <li><a class="dropdown-item" href="{{ route('enseignant.travaux_devoirs.create', ['coursId' => $c->id]) }}">{{ $c->titre }}</a></li>
                                @empty
                                    <li><span class="dropdown-item text-muted">Aucun cours disponible</span></li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-info text-white dropdown-toggle w-100" type="button" id="examenDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-clipboard-list me-2"></i>Programmer un examen
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="examenDropdown">
                                @forelse($cours as $c)
                                    <li><a class="dropdown-item" href="{{ route('enseignant.cours.examens.create', ['coursId' => $c->id]) }}">{{ $c->titre }}</a></li>
                                @empty
                                    <li><span class="dropdown-item text-muted">Aucun cours disponible</span></li>
                                @endforelse
                            </ul>
                        </div>
                        <a href="{{ route('enseignant.messages.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-envelope me-2"></i>Envoyer un message
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Événements à venir -->
            <div class="card shadow-sm mb-4 fade-up">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Événements à venir</h5>
                </div>
                <div class="card-body p-0">
                    <div class="text-center py-3">
                        <div class="calendar-icon mb-2">
                            <i class="bi bi-calendar-event text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <p class="text-muted mb-0">Vous avez 3 événements à venir</p>
                    </div>
                    
                    <div class="upcoming-events border-top">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-3 border-0">
                                <div class="d-flex">
                                    <div class="event-date me-3 text-center">
                                        <div class="date-day fw-bold text-primary">09</div>
                                        <div class="date-month small text-muted">Mai</div>
                                    </div>
                                    <div class="event-details">
                                        <div class="event-title fw-semibold">Réunion des enseignants</div>
                                        <div class="event-time small text-muted">
                                            <i class="bi bi-clock me-1"></i> 14:00 - 16:00
                                        </div>
                                        <div class="event-location small text-muted">
                                            <i class="bi bi-geo-alt me-1"></i> Salle de conférence
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item p-3 border-0">
                                <div class="d-flex">
                                    <div class="event-date me-3 text-center">
                                        <div class="date-day fw-bold text-primary">21</div>
                                        <div class="date-month small text-muted">Mai</div>
                                    </div>
                                    <div class="event-details">
                                        <div class="event-title fw-semibold">Examen de mathématiques</div>
                                        <div class="event-time small text-muted">
                                            <i class="bi bi-clock me-1"></i> 09:00 - 11:00
                                        </div>
                                        <div class="event-location small text-muted">
                                            <i class="bi bi-geo-alt me-1"></i> Salle 102
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item p-3 border-0">
                                <div class="d-flex">
                                    <div class="event-date me-3 text-center">
                                        <div class="date-day fw-bold text-white bg-primary rounded px-1">30</div>
                                        <div class="date-month small text-muted">Mai</div>
                                    </div>
                                    <div class="event-details">
                                        <div class="event-title fw-semibold">Conseil de classe</div>
                                        <div class="event-time small text-muted">
                                            <i class="bi bi-clock me-1"></i> 15:30 - 17:30
                                        </div>
                                        <div class="event-location small text-muted">
                                            <i class="bi bi-geo-alt me-1"></i> Salle des professeurs
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('enseignant.calendrier') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-calendar3 me-1"></i> Voir le calendrier
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
