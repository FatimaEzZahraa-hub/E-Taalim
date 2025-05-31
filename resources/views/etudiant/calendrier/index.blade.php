@extends('layouts.app')

@section('title', 'Calendrier')

@section('styles')
<style>
    .calendar {
        width: 100%;
    }
    .calendar-header {
        background-color: #8668FF;
        color: white;
        padding: 15px;
        border-radius: 5px 5px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
    }
    .calendar-day-header {
        text-align: center;
        padding: 10px;
        background-color: #f8f9fa;
        font-weight: 600;
        border: 1px solid #e9ecef;
    }
    .calendar-day {
        min-height: 120px;
        padding: 5px;
        border: 1px solid #e9ecef;
        position: relative;
    }
    .calendar-day.today {
        background-color: rgba(134, 104, 255, 0.1);
    }
    .calendar-day.other-month {
        background-color: #f8f9fa;
        color: #adb5bd;
    }
    .calendar-day-number {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    .today .calendar-day-number {
        background-color: #8668FF;
        color: white;
        border-radius: 50%;
    }
    .calendar-event {
        margin-top: 30px;
        margin-bottom: 2px;
        padding: 3px 5px;
        border-radius: 3px;
        font-size: 12px;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .calendar-event.event-devoir {
        background-color: rgba(255, 193, 7, 0.2);
        border-left: 3px solid #FFC107;
    }
    .calendar-event.event-examen {
        background-color: rgba(220, 53, 69, 0.2);
        border-left: 3px solid #DC3545;
    }
    .calendar-event.event-cours {
        background-color: rgba(13, 110, 253, 0.2);
        border-left: 3px solid #0D6EFD;
    }
    .calendar-event.event-personnel {
        background-color: rgba(25, 135, 84, 0.2);
        border-left: 3px solid #198754;
    }
    .calendar-event.event-autre {
        background-color: rgba(108, 117, 125, 0.2);
        border-left: 3px solid #6C757D;
    }
    .event-details {
        display: none;
        position: absolute;
        z-index: 10;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        min-width: 250px;
        max-width: 300px;
    }
    .event-details h6 {
        margin-bottom: 5px;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 5px;
    }
    .event-time {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }
    .event-location {
        font-size: 12px;
        margin-bottom: 5px;
    }
    .event-actions {
        display: flex;
        justify-content: flex-end;
        gap: 5px;
        margin-top: 10px;
    }
    #addEventModal .modal-header {
        background-color: #8668FF;
        color: white;
    }
    #addEventModal .btn-primary {
        background-color: #8668FF;
        border-color: #8668FF;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Calendrier</h1>
        <div class="d-flex gap-2">
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary" id="prev-month">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="today-btn">Aujourd'hui</button>
                <button type="button" class="btn btn-outline-secondary" id="next-month">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-funnel me-1"></i> Filtrer
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li>
                        <div class="dropdown-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="filter-devoirs" checked>
                                <label class="form-check-label" for="filter-devoirs">
                                    <span class="badge bg-warning text-dark">Devoirs</span>
                                </label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="filter-examens" checked>
                                <label class="form-check-label" for="filter-examens">
                                    <span class="badge bg-danger">Examens</span>
                                </label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="filter-cours" checked>
                                <label class="form-check-label" for="filter-cours">
                                    <span class="badge bg-primary">Cours</span>
                                </label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="filter-personnels" checked>
                                <label class="form-check-label" for="filter-personnels">
                                    <span class="badge bg-success">Personnels</span>
                                </label>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="filter-autres" checked>
                                <label class="form-check-label" for="filter-autres">
                                    <span class="badge bg-secondary">Autres</span>
                                </label>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal" style="background-color: #8668FF; border-color: #8668FF;">
                <i class="bi bi-plus-lg me-1"></i> Ajouter un u00e9vu00e9nement
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="calendar">
            <div class="calendar-header">
                <h2 id="current-month" class="mb-0">Mai 2025</h2>
                <div class="d-flex">
                    <div class="me-3">
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-calendar-check me-1"></i> {{ $stats['total_evenements'] ?? 0 }} u00e9vu00e9nements
                        </span>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-calendar-date me-1"></i> Semaine {{ $stats['semaine_actuelle'] ?? date('W') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="calendar-grid">
                <div class="calendar-day-header">Lun</div>
                <div class="calendar-day-header">Mar</div>
                <div class="calendar-day-header">Mer</div>
                <div class="calendar-day-header">Jeu</div>
                <div class="calendar-day-header">Ven</div>
                <div class="calendar-day-header">Sam</div>
                <div class="calendar-day-header">Dim</div>
                
                @for ($i = 0; $i < 35; $i++)
                    <div class="calendar-day {{ $i % 7 == 5 || $i % 7 == 6 ? 'weekend' : '' }} {{ $i == 10 ? 'today' : '' }} {{ $i < 3 || $i > 30 ? 'other-month' : '' }}">
                        <div class="calendar-day-number">{{ $i < 3 ? 28 + $i : ($i > 30 ? $i - 30 : $i - 2) }}</div>
                        
                        @if($i == 5)
                            <div class="calendar-event event-devoir" data-event-id="1">
                                Devoir de Math
                            </div>
                            <div class="event-details" id="event-details-1">
                                <h6>Devoir de Mathu00e9matiques</h6>
                                <div class="event-time"><i class="bi bi-clock me-1"></i> u00c9chu00e9ance: 18h00</div>
                                <div class="event-location"><i class="bi bi-book me-1"></i> Cours: Algu00e8bre linu00e9aire</div>
                                <p class="small mb-0">Exercices 5 u00e0 8 du chapitre 3</p>
                                <div class="event-actions">
                                    <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                </div>
                            </div>
                        @endif

                        @if($i == 10)
                            <div class="calendar-event event-examen" data-event-id="2">
                                Examen de Programmation
                            </div>
                            <div class="calendar-event event-personnel" data-event-id="3">
                                Ru00e9union de groupe
                            </div>
                            <div class="event-details" id="event-details-2">
                                <h6>Examen de Programmation</h6>
                                <div class="event-time"><i class="bi bi-clock me-1"></i> 10h00 - 12h00</div>
                                <div class="event-location"><i class="bi bi-geo-alt me-1"></i> Salle 203</div>
                                <p class="small mb-0">Examen final sur Java et Python</p>
                                <div class="event-actions">
                                    <a href="#" class="btn btn-sm btn-outline-primary">Du00e9tails</a>
                                </div>
                            </div>
                            <div class="event-details" id="event-details-3">
                                <h6>Ru00e9union de groupe</h6>
                                <div class="event-time"><i class="bi bi-clock me-1"></i> 14h00 - 16h00</div>
                                <div class="event-location"><i class="bi bi-geo-alt me-1"></i> Bibliothèque</div>
                                <p class="small mb-0">Pru00e9paration du projet final</p>
                                <div class="event-actions">
                                    <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                                    <button class="btn btn-sm btn-outline-secondary">Modifier</button>
                                </div>
                            </div>
                        @endif

                        @if($i == 15)
                            <div class="calendar-event event-cours" data-event-id="4">
                                Cours de Bases de donnu00e9es
                            </div>
                            <div class="event-details" id="event-details-4">
                                <h6>Cours de Bases de donnu00e9es</h6>
                                <div class="event-time"><i class="bi bi-clock me-1"></i> 08h00 - 10h00</div>
                                <div class="event-location"><i class="bi bi-geo-alt me-1"></i> Amphithu00e9u00e2tre B</div>
                                <p class="small mb-0">Introduction u00e0 SQL et MongoDB</p>
                                <div class="event-actions">
                                    <a href="#" class="btn btn-sm btn-outline-primary">Voir le cours</a>
                                </div>
                            </div>
                        @endif

                        @if($i == 22)
                            <div class="calendar-event event-autre" data-event-id="5">
                                Confu00e9rence IA et u00e9ducation
                            </div>
                            <div class="event-details" id="event-details-5">
                                <h6>Confu00e9rence IA et u00e9ducation</h6>
                                <div class="event-time"><i class="bi bi-clock me-1"></i> 14h00 - 17h00</div>
                                <div class="event-location"><i class="bi bi-geo-alt me-1"></i> Salle des confu00e9rences</div>
                                <p class="small mb-0">Confu00e9rence sur l'impact de l'IA dans l'u00e9ducation</p>
                                <div class="event-actions">
                                    <a href="#" class="btn btn-sm btn-outline-primary">Plus d'infos</a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i> u00c9vu00e9nements u00e0 venir</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($evenements as $evenement)
                            <div class="list-group-item p-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $evenement->titre }}</h6>
                                    <span class="badge {{ 
                                        $evenement->type == 'devoir' ? 'bg-warning text-dark' : 
                                        ($evenement->type == 'examen' ? 'bg-danger' : 
                                        ($evenement->type == 'cours' ? 'bg-primary' : 
                                        ($evenement->type == 'personnel' ? 'bg-success' : 'bg-secondary'))) 
                                    }}">
                                        {{ 
                                            $evenement->type == 'devoir' ? 'Devoir' : 
                                            ($evenement->type == 'examen' ? 'Examen' : 
                                            ($evenement->type == 'cours' ? 'Cours' : 
                                            ($evenement->type == 'personnel' ? 'Personnel' : 'Autre'))) 
                                        }}
                                    </span>
                                </div>
                                <p class="mb-1 text-muted">
                                    <i class="bi bi-calendar2-date me-1"></i> {{ $evenement->date }} 
                                    @if($evenement->heure_debut)
                                        u00e0 {{ $evenement->heure_debut }}
                                        @if($evenement->heure_fin)
                                            - {{ $evenement->heure_fin }}
                                        @endif
                                    @endif
                                </p>
                                @if($evenement->lieu)
                                    <p class="mb-1 small">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $evenement->lieu }}
                                    </p>
                                @endif
                                @if($evenement->cours)
                                    <p class="mb-0 small">
                                        <i class="bi bi-book me-1"></i> Cours: {{ $evenement->cours }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <div class="list-group-item p-4 text-center">
                                <p class="text-muted mb-0">Aucun u00e9vu00e9nement u00e0 venir</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i> Mes u00e9vu00e9nements personnels</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($evenements_personnels as $evenement)
                            <div class="list-group-item p-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $evenement->titre }}</h6>
                                    <div>
                                        <button class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="mb-1 text-muted">
                                    <i class="bi bi-calendar2-date me-1"></i> {{ $evenement->date }} 
                                    @if($evenement->heure_debut)
                                        u00e0 {{ $evenement->heure_debut }}
                                        @if($evenement->heure_fin)
                                            - {{ $evenement->heure_fin }}
                                        @endif
                                    @endif
                                </p>
                                @if($evenement->lieu)
                                    <p class="mb-1 small">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $evenement->lieu }}
                                    </p>
                                @endif
                                @if($evenement->description)
                                    <p class="mb-0 small">{{ $evenement->description }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="list-group-item p-4 text-center">
                                <p class="text-muted mb-0">Aucun u00e9vu00e9nement personnel</p>
                                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addEventModal" style="background-color: #8668FF; border-color: #8668FF;">
                                    <i class="bi bi-plus-lg me-1"></i> Ajouter un u00e9vu00e9nement
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter un u00e9vu00e9nement -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Ajouter un u00e9vu00e9nement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <div class="mb-3">
                        <label for="event-title" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="event-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="event-date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="event-date" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="event-start-time" class="form-label">Heure de du00e9but</label>
                            <input type="time" class="form-control" id="event-start-time">
                        </div>
                        <div class="col-md-6">
                            <label for="event-end-time" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" id="event-end-time">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="event-location" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="event-location">
                    </div>
                    <div class="mb-3">
                        <label for="event-description" class="form-label">Description</label>
                        <textarea class="form-control" id="event-description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="event-color" class="form-label">Couleur</label>
                        <select class="form-select" id="event-color">
                            <option value="bg-success">Vert</option>
                            <option value="bg-primary">Bleu</option>
                            <option value="bg-danger">Rouge</option>
                            <option value="bg-warning">Jaune</option>
                            <option value="bg-info">Turquoise</option>
                            <option value="bg-secondary">Gris</option>
                            <option value="bg-dark">Noir</option>
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="event-reminder">
                        <label class="form-check-label" for="event-reminder">
                            Recevoir un rappel
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Afficher les du00e9tails d'un u00e9vu00e9nement au survol
        const calendarEvents = document.querySelectorAll('.calendar-event');
        calendarEvents.forEach(event => {
            const eventId = event.dataset.eventId;
            const eventDetails = document.getElementById(`event-details-${eventId}`);
            
            event.addEventListener('mouseenter', function(e) {
                // Positionner les du00e9tails pru00e8s de l'u00e9vu00e9nement
                eventDetails.style.top = `${e.pageY - 100}px`;
                eventDetails.style.left = `${e.pageX + 20}px`;
                eventDetails.style.display = 'block';
            });
            
            event.addEventListener('mouseleave', function() {
                eventDetails.style.display = 'none';
            });
        });
        
        // Filtrer les u00e9vu00e9nements
        const filterCheckboxes = document.querySelectorAll('.dropdown-item input[type="checkbox"]');
        filterCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const eventType = this.id.replace('filter-', '');
                const events = document.querySelectorAll(`.event-${eventType.slice(0, -1)}`);
                
                events.forEach(event => {
                    event.style.display = this.checked ? 'block' : 'none';
                });
            });
        });
        
        // Navigation entre les mois
        const prevMonthBtn = document.getElementById('prev-month');
        const nextMonthBtn = document.getElementById('next-month');
        const todayBtn = document.getElementById('today-btn');
        const currentMonthDisplay = document.getElementById('current-month');
        
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        
        function updateMonthDisplay() {
            const months = ['Janvier', 'Fu00e9vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aou00fbt', 'Septembre', 'Octobre', 'Novembre', 'Du00e9cembre'];
            currentMonthDisplay.textContent = `${months[currentMonth]} ${currentYear}`;
        }
        
        prevMonthBtn.addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            updateMonthDisplay();
            // Ici, vous pourriez recharger les u00e9vu00e9nements du mois
        });
        
        nextMonthBtn.addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            updateMonthDisplay();
            // Ici, vous pourriez recharger les u00e9vu00e9nements du mois
        });
        
        todayBtn.addEventListener('click', function() {
            const today = new Date();
            currentMonth = today.getMonth();
            currentYear = today.getFullYear();
            updateMonthDisplay();
            // Ici, vous pourriez recharger les u00e9vu00e9nements du mois
        });
        
        // Initialiser l'affichage du mois
        updateMonthDisplay();
    });
</script>
@endpush
@endsection
