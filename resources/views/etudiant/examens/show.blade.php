@extends('layouts.app')

@section('title', 'Du00e9tail de l\'examen')

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.examens') }}">Mes examens</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $examen->titre }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">{{ $examen->titre }}</h1>
                @if($examen->date->isPast())
                    <span class="badge bg-secondary">Passu00e9</span>
                @elseif($examen->date->isToday())
                    <span class="badge bg-danger">Aujourd'hui</span>
                @elseif($examen->date->diffInDays(now()) <= 7)
                    <span class="badge bg-warning">Cette semaine</span>
                @else
                    <span class="badge bg-light text-dark">u00c0 venir</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $examen->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Instructions</h5>
                        <div class="p-3 bg-light rounded">
                            {!! $examen->instructions !!}
                        </div>
                    </div>

                    @if($examen->type == 'en_ligne' && $examen->date->isToday() && now()->format('H:i') >= $examen->heure_debut && now()->format('H:i') <= $examen->heure_fin)
                        <div class="alert alert-success">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-check-circle-fill fs-1"></i>
                                </div>
                                <div>
                                    <h4 class="alert-heading">L'examen est actuellement disponible!</h4>
                                    <p>Vous pouvez commencer l'examen maintenant. Assurez-vous d'avoir le temps nu00e9cessaire pour le terminer en une seule session.</p>
                                    <p class="mb-0">Duru00e9e: {{ $examen->duree }} minutes</p>
                                    <hr>
                                    <button class="btn btn-success">
                                        <i class="bi bi-play-fill me-1"></i> Commencer l'examen
                                    </button>
                                </div>
                            </div>
                        </div>
                    @elseif($examen->type == 'en_ligne' && $examen->date->isFuture())
                        <div class="alert alert-info">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-info-circle-fill fs-1"></i>
                                </div>
                                <div>
                                    <h4 class="alert-heading">L'examen sera disponible prochainement</h4>
                                    <p>Cet examen sera disponible le {{ $examen->date->format('d/m/Y') }} de {{ $examen->heure_debut }} u00e0 {{ $examen->heure_fin }}.</p>
                                    <p class="mb-0">N'oubliez pas de vous connecter u00e0 temps.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($examen->type == 'en_presentiel')
                        <div class="alert alert-warning">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-geo-alt-fill fs-1"></i>
                                </div>
                                <div>
                                    <h4 class="alert-heading">Examen en pru00e9sentiel</h4>
                                    <p>Cet examen se du00e9roulera en pru00e9sentiel. Veuillez vous rendre u00e0 l'adresse indiquu00e9e u00e0 l'heure pru00e9vue.</p>
                                    <p class="mb-0">N'oubliez pas de vous munir de votre carte d'u00e9tudiant.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($examen->materiel_autorise)
                        <div class="mb-4">
                            <h5>Matu00e9riel autorisu00e9</h5>
                            <div class="p-3 border rounded">
                                {!! $examen->materiel_autorise !!}
                            </div>
                        </div>
                    @endif

                    @if($examen->chapitres_a_reviser)
                        <div class="mb-4">
                            <h5>Chapitres u00e0 ru00e9viser</h5>
                            <div class="list-group">
                                @foreach(explode('\n', $examen->chapitres_a_reviser) as $chapitre)
                                    @if(trim($chapitre) !== '')
                                        <div class="list-group-item">
                                            <i class="bi bi-check2-circle me-2 text-success"></i> {{ trim($chapitre) }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($examen->resultats && $examen->date->isPast())
                        <div class="card mt-4 border-success">
                            <div class="card-header bg-white">
                                <h5 class="mb-0 text-success">Ru00e9sultats de l'examen</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <span class="badge bg-success p-2 fs-5">{{ $examen->resultats->note }}/20</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Note finale</h6>
                                        <small class="text-muted">Publiu00e9e le {{ $examen->resultats->date->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                                
                                @if($examen->resultats->commentaire)
                                    <div class="mb-3">
                                        <h6>Commentaire de l'enseignant:</h6>
                                        <div class="p-3 bg-light rounded">
                                            {!! $examen->resultats->commentaire !!}
                                        </div>
                                    </div>
                                @endif
                                
                                @if($examen->resultats->correction_url)
                                    <a href="{{ $examen->resultats->correction_url }}" class="btn btn-outline-success">
                                        <i class="bi bi-file-earmark-text me-1"></i> Tu00e9lu00e9charger la correction
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Informations</h5>
                            
                            <div class="mb-3">
                                <p class="mb-1"><strong>Cours:</strong></p>
                                <p class="mb-0">
                                    <a href="{{ route('etudiant.cours.show', $examen->cours_id) }}" class="text-decoration-none">
                                        {{ $examen->cours }}
                                    </a>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <p class="mb-1"><strong>Date:</strong></p>
                                <p class="mb-0">
                                    <i class="bi bi-calendar-event me-1"></i> {{ $examen->date->format('d/m/Y') }}
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <p class="mb-1"><strong>Horaire:</strong></p>
                                <p class="mb-0">
                                    <i class="bi bi-clock me-1"></i> {{ $examen->heure_debut }} - {{ $examen->heure_fin }}
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <p class="mb-1"><strong>Duru00e9e:</strong></p>
                                <p class="mb-0">{{ $examen->duree }} minutes</p>
                            </div>
                            
                            <div class="mb-3">
                                <p class="mb-1"><strong>Type:</strong></p>
                                <p class="mb-0">
                                    <i class="bi {{ $examen->type == 'en_ligne' ? 'bi-laptop' : 'bi-building' }} me-1"></i>
                                    {{ $examen->type == 'en_ligne' ? 'Examen en ligne' : 'Examen en pru00e9sentiel' }}
                                </p>
                            </div>
                            
                            @if($examen->type == 'en_presentiel')
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Lieu:</strong></p>
                                    <p class="mb-0">{{ $examen->lieu ?? 'Non spu00e9cifiu00e9' }}</p>
                                </div>
                                
                                @if($examen->salle)
                                    <div class="mb-3">
                                        <p class="mb-1"><strong>Salle:</strong></p>
                                        <p class="mb-0">{{ $examen->salle }}</p>
                                    </div>
                                @endif
                            @endif
                            
                            <div class="mb-0">
                                <p class="mb-1"><strong>Baru00e8me:</strong></p>
                                <p class="mb-0">/20</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($examen->date->isFuture())
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title mb-3">Ajouter u00e0 mon calendrier</h5>
                                <button class="btn btn-outline-primary mb-2 w-100">
                                    <i class="bi bi-calendar-plus me-1"></i> Google Calendar
                                </button>
                                <button class="btn btn-outline-primary w-100">
                                    <i class="bi bi-calendar-plus me-1"></i> iCalendar (.ics)
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
