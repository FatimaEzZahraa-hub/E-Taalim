@extends('layouts.app')

@section('title', 'Tableau de bord u00c9tudiant')

@section('content')
<div class="container-fluid py-4">
    <!-- Cartes de statistiques -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-book text-primary fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $stats['cours'] }}</h3>
                            <p class="text-muted mb-0">Cours actifs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="bi bi-file-earmark-text text-warning fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $stats['devoirs_en_attente'] }}</h3>
                            <p class="text-muted mb-0">Devoirs u00e0 rendre</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="bi bi-calendar-event text-danger fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $stats['examens_a_venir'] }}</h3>
                            <p class="text-muted mb-0">Examens u00e0 venir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="bi bi-envelope text-success fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $stats['messages_non_lus'] }}</h3>
                            <p class="text-muted mb-0">Messages non lus</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- u00c9vu00e9nements u00e0 venir -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i> u00c9vu00e9nements u00e0 venir</h5>
                        <a href="{{ route('etudiant.calendrier') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-calendar3"></i> Calendrier
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($evenements as $evenement)
                            <div class="list-group-item list-group-item-action p-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $evenement->titre }}</h6>
                                    <span class="badge {{ $evenement->type == 'examen' ? 'bg-danger' : ($evenement->type == 'devoir' ? 'bg-warning' : 'bg-info') }}">
                                        {{ $evenement->type == 'examen' ? 'Examen' : ($evenement->type == 'devoir' ? 'Devoir' : 'u00c9vu00e9nement') }}
                                    </span>
                                </div>
                                <p class="mb-1 text-muted">
                                    <i class="bi bi-calendar2-date me-1"></i> {{ $evenement->date }} u00e0 {{ $evenement->heure }}
                                </p>
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

        <!-- Devoirs u00e0 rendre -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i> Devoirs u00e0 rendre</h5>
                        <a href="{{ route('etudiant.devoirs') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-list-check"></i> Tous les devoirs
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($devoirs as $devoir)
                            <div class="list-group-item list-group-item-action p-3 {{ $devoir->statut == 'en_retard' ? 'border-danger border-start border-3' : '' }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $devoir->titre }}</h6>
                                    <span class="badge {{ $devoir->statut == 'en_retard' ? 'bg-danger' : 'bg-warning' }}">
                                        {{ $devoir->statut == 'en_retard' ? 'En retard' : 'u00c0 rendre' }}
                                    </span>
                                </div>
                                <p class="mb-1 text-muted">Cours: {{ $devoir->cours }}</p>
                                <p class="mb-0 small">
                                    <i class="bi bi-clock me-1"></i>
                                    @if($devoir->date_limite->isPast())
                                        <span class="text-danger">Date limite du00e9passu00e9e ({{ $devoir->date_limite->format('d/m/Y') }})</span>
                                    @else
                                        <span>Date limite: {{ $devoir->date_limite->format('d/m/Y') }}</span>
                                    @endif
                                </p>
                                <div class="mt-2">
                                    <a href="{{ route('etudiant.devoirs.show', $devoir->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-arrow-right"></i> Voir le devoir
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item p-4 text-center">
                                <p class="text-muted mb-0">Aucun devoir u00e0 rendre</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
