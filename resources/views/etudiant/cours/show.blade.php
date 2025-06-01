@extends('layouts.app')

@section('title', 'Du00e9tail du cours')

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.cours') }}">Mes cours</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $cours->titre }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="h3 mb-2">{{ $cours->titre }}</h1>
                    <p class="text-muted mb-3">{{ $cours->enseignant }}</p>
                    <p>{{ $cours->description }}</p>
                    
                    <div class="d-flex gap-2 mt-3">
                        <span class="badge bg-primary">{{ $cours->filiere }}</span>
                        <span class="badge bg-secondary">Semestre {{ $cours->semestre }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Progression du cours</h5>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Avancement</span>
                                <span>{{ $cours->progression }}%</span>
                            </div>
                            <div class="progress mb-4" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $cours->progression }}%; background-color: #8668FF;" aria-valuenow="{{ $cours->progression }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <i class="bi bi-file-earmark text-primary me-1"></i> Ressources
                                </div>
                                <div>{{ count($ressources) }}</div>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <i class="bi bi-clipboard-check text-warning me-1"></i> Devoirs
                                </div>
                                <div>{{ count($devoirs) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets pour naviguer entre ressources et devoirs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#ressources">
                <i class="bi bi-file-earmark me-1"></i> Ressources pu00e9dagogiques
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#devoirs">
                <i class="bi bi-clipboard-check me-1"></i> Devoirs et travaux
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Onglet des ressources pu00e9dagogiques -->
        <div class="tab-pane fade show active" id="ressources">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-3">Ressources pu00e9dagogiques</h4>
                    <div class="list-group">
                        @forelse($ressources as $ressource)
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <h6 class="mb-1">{{ $ressource->titre }}</h6>
                                    <p class="mb-0 small text-muted">{{ $ressource->description }}</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark me-2">{{ $ressource->type }}</span>
                                    <button class="btn btn-sm btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                                        <i class="bi {{ $ressource->type == 'PDF' ? 'bi-file-pdf' : ($ressource->type == 'Vidu00e9o' ? 'bi-play-circle' : 'bi-file-earmark') }}"></i> Tu00e9lu00e9charger
                                    </button>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-info-circle fs-1 text-muted"></i>
                                <p class="mt-2 text-muted">Aucune ressource disponible pour ce cours.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet des devoirs et travaux -->
        <div class="tab-pane fade" id="devoirs">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-3">Devoirs et travaux</h4>
                    <div class="list-group">
                        @forelse($devoirs as $devoir)
                            <div class="list-group-item {{ $devoir->statut == 'en_retard' ? 'border-danger border-start border-3' : '' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $devoir->titre }}</h6>
                                        <p class="mb-2 small text-muted">{{ $devoir->description }}</p>
                                        <div class="mb-2">
                                            <span class="badge {{ $devoir->statut == 'en_attente' ? 'bg-warning' : ($devoir->statut == 'soumis' ? 'bg-success' : 'bg-danger') }}">
                                                {{ $devoir->statut == 'en_attente' ? 'u00c0 rendre' : ($devoir->statut == 'soumis' ? 'Soumis' : 'En retard') }}
                                            </span>
                                            <span class="badge bg-light text-dark ms-2">
                                                <i class="bi bi-clock me-1"></i> u00c9chu00e9ance: {{ $devoir->date_limite->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('etudiant.devoirs.show', $devoir->id) }}" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                                        <i class="bi {{ $devoir->statut == 'soumis' ? 'bi-eye' : 'bi-upload' }}"></i>
                                        {{ $devoir->statut == 'soumis' ? 'Voir ma soumission' : 'Soumettre' }}
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-clipboard fs-1 text-muted"></i>
                                <p class="mt-2 text-muted">Aucun devoir assignu00e9 pour ce cours.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
