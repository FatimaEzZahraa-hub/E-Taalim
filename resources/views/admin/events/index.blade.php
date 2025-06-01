@extends('layouts.admin')

@section('title', 'Gestion des Événements')

@section('page_title', 'Gestion des Événements')

@section('styles')
<style>
    /* Styles pour agrandir la largeur du tableau */
    .container-fluid {
        padding-left: 0 !important;
        padding-right: 0 !important;
        max-width: 100vw !important;
        margin-left: -15px !important;
        margin-right: -15px !important;
        width: calc(100vw + 30px) !important;
    }
    
    .card-body {
        padding: 0.75rem !important;
    }
    
    .table-container {
        width: 100%;
        overflow-x: auto;
        margin: 0 -15px;
    }
    
    /* Styles pour les colonnes du tableau */
    .table th, .table td {
        white-space: nowrap;
        padding: 12px 15px;
    }
    
    .table th:first-child, .table td:first-child {
        padding-left: 20px;
    }
    
    .table th:last-child, .table td:last-child {
        padding-right: 20px;
    }
    
    /* Styles existants */
    .event-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .event-date {
        background-color: #4361ee;
        color: white;
        padding: 10px;
        text-align: center;
        font-weight: 600;
    }
    .event-day {
        font-size: 1.5rem;
    }
    .event-month {
        font-size: 0.9rem;
        text-transform: uppercase;
    }
    .event-badge {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .event-actions {
        position: absolute;
        bottom: 10px;
        right: 10px;
        opacity: 0;
        transition: all 0.3s ease;
    }
    .event-card:hover .event-actions {
        opacity: 1;
    }
    .event-creator {
        font-size: 0.8rem;
        color: #6c757d;
    }
    .calendar-view {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    }
    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .calendar-nav {
        display: flex;
        gap: 10px;
    }
    .calendar-day {
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .calendar-day:hover {
        background-color: #e9ecef;
    }
    .calendar-day.active {
        background-color: #4361ee;
        color: white;
    }
    .calendar-day.has-event {
        border: 2px solid #4361ee;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-1" style="max-width: 100vw; overflow-x: hidden;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer un événement
            </a>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary active" id="cardViewBtn">
                <i class="fas fa-th-large"></i> Cartes
            </button>
            <button type="button" class="btn btn-outline-primary" id="listViewBtn">
                <i class="fas fa-list"></i> Liste
            </button>
            <button type="button" class="btn btn-outline-primary" id="calendarViewBtn">
                <i class="fas fa-calendar-alt"></i> Calendrier
            </button>
        </div>
    </div>

    <!-- Vue Recherche et Filtres -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Rechercher un événement..." id="searchInput">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="monthFilter">
                        <option value="all">Tous les mois</option>
                        <option value="1">Janvier</option>
                        <option value="2">Février</option>
                        <option value="3">Mars</option>
                        <option value="4">Avril</option>
                        <option value="5">Mai</option>
                        <option value="6">Juin</option>
                        <option value="7">Juillet</option>
                        <option value="8">Août</option>
                        <option value="9">Septembre</option>
                        <option value="10">Octobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Décembre</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="all">Tous les statuts</option>
                        <option value="upcoming">À venir</option>
                        <option value="ongoing">En cours</option>
                        <option value="past">Passés</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Vue Cartes -->
    <div id="cardView">
        <div class="row">
            @forelse($events as $event)
            <div class="col-md-4 mb-4 event-item" 
                data-month="{{ \Carbon\Carbon::parse($event->date_debut)->format('n') }}"
                data-status="{{ \Carbon\Carbon::parse($event->date_debut)->isFuture() ? 'upcoming' : (\Carbon\Carbon::parse($event->date_fin)->isPast() ? 'past' : 'ongoing') }}">
                <div class="card event-card">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <div class="event-date h-100 d-flex flex-column justify-content-center">
                                <div class="event-day">{{ \Carbon\Carbon::parse($event->date_debut)->format('d') }}</div>
                                <div class="event-month">{{ \Carbon\Carbon::parse($event->date_debut)->format('M') }}</div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body position-relative">
                                @if(\Carbon\Carbon::parse($event->date_debut)->isFuture())
                                    <span class="badge bg-primary event-badge">À venir</span>
                                @elseif(\Carbon\Carbon::parse($event->date_fin)->isPast())
                                    <span class="badge bg-secondary event-badge">Passé</span>
                                @else
                                    <span class="badge bg-success event-badge">En cours</span>
                                @endif
                                
                                <h5 class="card-title">{{ $event->titre }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->date_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->date_fin)->format('H:i') }}
                                    </small>
                                </p>
                                <p class="card-text event-creator">
                                    <small>Créé par: {{ $event->creator_email }}</small>
                                </p>
                                
                                <div class="event-actions">
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEventModal{{ $event->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Suppression -->
                <div class="modal fade" id="deleteEventModal{{ $event->id }}" tabindex="-1" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteEventModalLabel">Confirmer la suppression</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer l'événement <strong>{{ $event->titre }}</strong> ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Aucun événement trouvé. <a href="{{ route('admin.events.create') }}" class="alert-link">Créez votre premier événement</a>.
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Vue Liste -->
    <div id="listView" style="display: none; width: 100%;">
        <div class="card shadow" style="margin: 0; width: 100vw; max-width: 100vw;">
            <div class="card-body" style="padding: 0.5rem !important;">
                <div class="table-container">
                    <table class="table table-hover" style="width: 100vw; max-width: none; table-layout: fixed; border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Titre</th>
                                <th style="width: 18%;">Date de début</th>
                                <th style="width: 18%;">Date de fin</th>
                                <th style="width: 10%;">Statut</th>
                                <th style="width: 19%;">Créé par</th>
                                <th style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                            <tr class="event-item" 
                                data-month="{{ \Carbon\Carbon::parse($event->date_debut)->format('n') }}"
                                data-status="{{ \Carbon\Carbon::parse($event->date_debut)->isFuture() ? 'upcoming' : (\Carbon\Carbon::parse($event->date_fin)->isPast() ? 'past' : 'ongoing') }}">
                                <td>{{ $event->titre }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->date_debut)->format('d/m/Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->date_fin)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if(\Carbon\Carbon::parse($event->date_debut)->isFuture())
                                        <span class="badge bg-primary">À venir</span>
                                    @elseif(\Carbon\Carbon::parse($event->date_fin)->isPast())
                                        <span class="badge bg-secondary">Passé</span>
                                    @else
                                        <span class="badge bg-success">En cours</span>
                                    @endif
                                </td>
                                <td>{{ $event->creator_email }}</td>
                                <td>
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEventModal{{ $event->id }}List">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    <!-- Modal Suppression (Liste) -->
                                    <div class="modal fade" id="deleteEventModal{{ $event->id }}List" tabindex="-1" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteEventModalLabel">Confirmer la suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer l'événement <strong>{{ $event->titre }}</strong> ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun événement trouvé</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Vue Calendrier (simplifiée) -->
    <div id="calendarView" style="display: none;">
        <div class="calendar-view">
            <div class="calendar-header">
                <h5 id="currentMonth">Mai 2025</h5>
                <div class="calendar-nav">
                    <button class="btn btn-sm btn-outline-primary" id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                    <button class="btn btn-sm btn-outline-primary" id="nextMonth"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col text-center">Lun</div>
                <div class="col text-center">Mar</div>
                <div class="col text-center">Mer</div>
                <div class="col text-center">Jeu</div>
                <div class="col text-center">Ven</div>
                <div class="col text-center">Sam</div>
                <div class="col text-center">Dim</div>
            </div>
            <div id="calendarDays" class="row row-cols-7 g-2">
                <!-- Les jours seront générés par JavaScript -->
            </div>
            
            <div class="mt-4" id="dayEventsList">
                <h6>Événements du <span id="selectedDate">28/05/2025</span></h6>
                <ul class="list-group" id="eventsForDay">
                    <!-- Les événements seront ajoutés ici par JavaScript -->
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle entre les vues
        $('#cardViewBtn').click(function() {
            $('#cardView').show();
            $('#listView').hide();
            $('#calendarView').hide();
            $(this).addClass('active');
            $('#listViewBtn').removeClass('active');
            $('#calendarViewBtn').removeClass('active');
        });
        
        $('#listViewBtn').click(function() {
            $('#cardView').hide();
            $('#listView').show();
            $('#calendarView').hide();
            $(this).addClass('active');
            $('#cardViewBtn').removeClass('active');
            $('#calendarViewBtn').removeClass('active');
        });
        
        $('#calendarViewBtn').click(function() {
            $('#cardView').hide();
            $('#listView').hide();
            $('#calendarView').show();
            $(this).addClass('active');
            $('#cardViewBtn').removeClass('active');
            $('#listViewBtn').removeClass('active');
            
            // Initialiser le calendrier
            initCalendar();
        });
        
        // Recherche d'événements
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".event-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        // Filtre par mois
        $("#monthFilter").on("change", function() {
            var month = $(this).val();
            
            if (month === 'all') {
                $(".event-item").show();
            } else {
                $(".event-item").hide();
                $(".event-item[data-month='" + month + "']").show();
            }
        });
        
        // Filtre par statut
        $("#statusFilter").on("change", function() {
            var status = $(this).val();
            
            if (status === 'all') {
                $(".event-item").show();
            } else {
                $(".event-item").hide();
                $(".event-item[data-status='" + status + "']").show();
            }
        });
        
        // Fonction pour initialiser le calendrier (simplifiée)
        function initCalendar() {
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Mettre à jour le titre du mois
            const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
            $('#currentMonth').text(monthNames[month] + ' ' + year);
            
            // Obtenir le premier jour du mois
            const firstDay = new Date(year, month, 1).getDay();
            // Obtenir le nombre de jours dans le mois
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            // Ajuster pour que la semaine commence le lundi (0 = Lundi, 6 = Dimanche)
            const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;
            
            // Générer les jours
            let daysHTML = '';
            
            // Jours vides avant le début du mois
            for (let i = 0; i < adjustedFirstDay; i++) {
                daysHTML += '<div class="col"><div class="calendar-day text-muted"></div></div>';
            }
            
            // Jours du mois
            for (let i = 1; i <= daysInMonth; i++) {
                const isToday = i === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear();
                const hasEvent = Math.random() > 0.7; // Simulation d'événements
                
                daysHTML += `
                    <div class="col">
                        <div class="calendar-day${isToday ? ' active' : ''}${hasEvent ? ' has-event' : ''}" data-date="${i}/${month+1}/${year}">
                            ${i}
                        </div>
                    </div>
                `;
            }
            
            $('#calendarDays').html(daysHTML);
            
            // Événement pour cliquer sur un jour
            $('.calendar-day').click(function() {
                const dateStr = $(this).data('date');
                if (dateStr) {
                    $('#selectedDate').text(dateStr);
                    // Simulation d'événements pour ce jour
                    let eventsList = '';
                    
                    if (Math.random() > 0.5) {
                        eventsList += `
                            <li class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Réunion des enseignants</h6>
                                    <small>10:00 - 11:30</small>
                                </div>
                                <p class="mb-1">Discussion sur les nouveaux programmes</p>
                            </li>
                        `;
                    }
                    
                    if (Math.random() > 0.7) {
                        eventsList += `
                            <li class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Conférence sur l'IA</h6>
                                    <small>14:00 - 16:00</small>
                                </div>
                                <p class="mb-1">Présentation des nouvelles technologies</p>
                            </li>
                        `;
                    }
                    
                    if (eventsList === '') {
                        eventsList = '<li class="list-group-item">Aucun événement pour ce jour</li>';
                    }
                    
                    $('#eventsForDay').html(eventsList);
                }
            });
        }
    });
</script>
@endsection
