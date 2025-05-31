@extends('layouts.app')

@section('title', 'Mes Cours')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Mes cours</h1>
        <div>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher un cours...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($cours as $c)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-img-top bg-light" style="height: 160px; overflow: hidden;">
                        <img src="{{ asset('images/' . $c->image) }}" alt="{{ $c->titre }}" class="img-fluid w-100 h-100 object-fit-cover">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $c->titre }}</h5>
                        <p class="card-text text-muted small mb-2">{{ $c->enseignant }}</p>
                        <p class="card-text">{{ Str::limit($c->description, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="small text-muted">
                                <i class="bi bi-file-earmark me-1"></i> {{ $c->ressources_count }} ressources
                            </div>
                            <div class="small text-muted">
                                <i class="bi bi-clipboard-check me-1"></i> {{ $c->devoirs_count }} devoirs
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>Progression</span>
                                <span>{{ $c->progression }}%</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $c->progression }}%; background-color: #8668FF;" aria-valuenow="{{ $c->progression }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <a href="{{ route('etudiant.cours.show', $c->id) }}" class="btn btn-primary w-100" style="background-color: #8668FF; border-color: #8668FF;">
                            <i class="bi bi-book me-1"></i> Accéder au cours
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i> Vous n'êtes inscrit à aucun cours pour le moment.
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $cours->links() }}
    </div>
</div>
@endsection
