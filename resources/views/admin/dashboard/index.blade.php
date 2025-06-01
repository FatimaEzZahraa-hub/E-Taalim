@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('page_title', 'Tableau de bord')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Utilisateurs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['users_count'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Étudiants</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['students_count'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Enseignants</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['teachers_count'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Cours</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['courses_count'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Événements récents -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Événements récents</h6>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-primary">Voir tous</a>
                </div>
                <div class="card-body">
                    @if(isset($latest_events) && count($latest_events) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover events-table">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latest_events as $event)
                                    <tr>
                                        <td>{{ $event->titre }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->date_debut)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Aucun événement récent</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Messages récents -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Messages récents</h6>
                    <a href="{{ route('admin.messages') }}" class="btn btn-sm btn-primary">Voir tous</a>
                </div>
                <div class="card-body">
                    @if(isset($latest_messages) && count($latest_messages) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover messages-table">
                                <thead>
                                    <tr>
                                        <th>De</th>
                                        <th>À</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latest_messages as $message)
                                    <tr>
                                        <td>{{ $message->expediteur_email ?? 'Inconnu' }}</td>
                                        <td>{{ $message->destinataire_email ?? 'Inconnu' }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($message->contenu, 30) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($message->date_envoi)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.messages.view', $message->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Consulter
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Aucun message récent</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Cours en attente de validation -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Cours en attente de validation</h6>
                    <a href="{{ route('admin.courses.pending') }}" class="btn btn-sm btn-primary">Voir tous</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover courses-table">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Enseignant</th>
                                    <th>Date de soumission</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Données factices pour les cours en attente
                                    $pendingCourses = [
                                        (object)[
                                            'id' => 1,
                                            'titre' => 'Introduction à la programmation Python',
                                            'description' => 'Un cours complet pour apprendre les bases de la programmation avec Python.',
                                            'date_creation' => now()->subDays(3),
                                            'enseignant_id' => 2,
                                            'statut' => 'en_attente',
                                            'nom' => 'Dupont',
                                            'prenom' => 'Jean'
                                        ],
                                        (object)[
                                            'id' => 2,
                                            'titre' => 'Mathématiques pour l\'informatique',
                                            'description' => 'Ce cours couvre les concepts mathématiques essentiels pour la programmation et l\'informatique.',
                                            'date_creation' => now()->subDays(5),
                                            'enseignant_id' => 3,
                                            'statut' => 'en_attente',
                                            'nom' => 'Martin',
                                            'prenom' => 'Sophie'
                                        ],
                                    ];
                                @endphp
                                
                                @if(count($pendingCourses) > 0)
                                    @foreach($pendingCourses as $course)
                                    <tr>
                                        <td>{{ $course->titre }}</td>
                                        <td>{{ $course->prenom }} {{ $course->nom }}</td>
                                        <td>{{ \Carbon\Carbon::parse($course->date_creation)->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.courses.view', $course->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Consulter
                                            </a>
                                            <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i> Approuver
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $course->id }}">
                                                <i class="fas fa-times"></i> Rejeter
                                            </button>
                                            
                                            <!-- Modal pour rejeter le cours -->
                                            <div class="modal fade" id="rejectModal{{ $course->id }}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="rejectModalLabel">Rejeter le cours</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="reason" class="form-label">Raison du rejet</label>
                                                                    <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">Aucun cours en attente de validation</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
