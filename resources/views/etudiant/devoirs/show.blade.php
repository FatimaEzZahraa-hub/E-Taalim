@extends('layouts.app')

@section('title', 'Du00e9tail du devoir')

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.devoirs') }}">Mes devoirs</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $devoir->titre }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">{{ $devoir->titre }}</h1>
                <span class="badge {{ 
                    $devoir->statut == 'en_attente' ? 'bg-warning' : 
                    ($devoir->statut == 'soumis' ? 'bg-info' : 
                    ($devoir->statut == 'en_retard' ? 'bg-danger' : 
                    ($devoir->statut == 'u00e9valuu00e9' ? 'bg-success' : 'bg-secondary'))) 
                }}">
                    {{ 
                        $devoir->statut == 'en_attente' ? 'u00c0 rendre' : 
                        ($devoir->statut == 'soumis' ? 'Soumis' : 
                        ($devoir->statut == 'en_retard' ? 'En retard' : 
                        ($devoir->statut == 'u00e9valuu00e9' ? 'u00c9valuu00e9' : 'Inconnu'))) 
                    }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $devoir->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Consignes</h5>
                        <div class="p-3 bg-light rounded">
                            {!! $devoir->consignes !!}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Piu00e8ces jointes</h5>
                        @if(count($devoir->fichiers) > 0)
                            <div class="list-group">
                                @foreach($devoir->fichiers as $fichier)
                                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi {{ 
                                                Str::endsWith($fichier->nom, '.pdf') ? 'bi-file-pdf' : 
                                                (Str::endsWith($fichier->nom, ['.doc', '.docx']) ? 'bi-file-word' : 
                                                (Str::endsWith($fichier->nom, ['.xls', '.xlsx']) ? 'bi-file-excel' : 
                                                (Str::endsWith($fichier->nom, ['.ppt', '.pptx']) ? 'bi-file-ppt' : 'bi-file'))) 
                                            }} me-2"></i>
                                            {{ $fichier->nom }}
                                        </div>
                                        <span class="badge bg-light text-dark">{{ $fichier->taille }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Aucune piu00e8ce jointe pour ce devoir.</p>
                        @endif
                    </div>

                    @if($devoir->statut == 'u00e9valuu00e9')
                        <div class="mb-4">
                            <h5>Feedback de l'enseignant</h5>
                            <div class="p-3 border rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <span class="badge bg-success p-2 fs-5">{{ $devoir->note }}/20</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Note</h6>
                                        <small class="text-muted">Attribuu00e9e le {{ $devoir->date_evaluation->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    {!! $devoir->commentaire !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($devoir->statut == 'en_attente' || $devoir->statut == 'en_retard')
                        <div class="card mt-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Soumettre mon travail</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('etudiant.devoirs.soumettre', $devoir->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                                        <textarea class="form-control" id="commentaire" name="commentaire" rows="3" placeholder="Ajoutez un commentaire pour votre enseignant..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fichiers" class="form-label">Fichiers</label>
                                        <input class="form-control" type="file" id="fichiers" name="fichiers[]" multiple>
                                        <div class="form-text">Vous pouvez su00e9lectionner plusieurs fichiers. Formats acceptu00e9s: PDF, Word, Excel, PPT, ZIP, images.</div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                                        <i class="bi bi-upload me-1"></i> Soumettre mon travail
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if($devoir->statut == 'soumis')
                        <div class="card mt-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Ma soumission</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-2"><strong>Date de soumission:</strong> {{ $devoir->soumission->date->format('d/m/Y u00e0 H:i') }}</p>
                                
                                @if($devoir->soumission->commentaire)
                                    <div class="mb-3">
                                        <h6>Mon commentaire:</h6>
                                        <p class="p-3 bg-light rounded">{{ $devoir->soumission->commentaire }}</p>
                                    </div>
                                @endif
                                
                                <h6>Fichiers soumis:</h6>
                                @if(count($devoir->soumission->fichiers) > 0)
                                    <div class="list-group">
                                        @foreach($devoir->soumission->fichiers as $fichier)
                                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi {{ 
                                                        Str::endsWith($fichier->nom, '.pdf') ? 'bi-file-pdf' : 
                                                        (Str::endsWith($fichier->nom, ['.doc', '.docx']) ? 'bi-file-word' : 
                                                        (Str::endsWith($fichier->nom, ['.xls', '.xlsx']) ? 'bi-file-excel' : 
                                                        (Str::endsWith($fichier->nom, ['.ppt', '.pptx']) ? 'bi-file-ppt' : 'bi-file'))) 
                                                    }} me-2"></i>
                                                    {{ $fichier->nom }}
                                                </div>
                                                <span class="badge bg-light text-dark">{{ $fichier->taille }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">Aucun fichier soumis.</p>
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
                                    <a href="{{ route('etudiant.cours.show', $devoir->cours_id) }}" class="text-decoration-none">
                                        {{ $devoir->cours }}
                                    </a>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <p class="mb-1"><strong>Date limite:</strong></p>
                                <p class="mb-0 {{ $devoir->date_limite->isPast() && ($devoir->statut == 'en_attente' || $devoir->statut == 'en_retard') ? 'text-danger' : '' }}">
                                    <i class="bi bi-calendar-event me-1"></i> {{ $devoir->date_limite->format('d/m/Y u00e0 H:i') }}
                                    
                                    @if($devoir->date_limite->isPast() && ($devoir->statut == 'en_attente' || $devoir->statut == 'en_retard'))
                                        <span class="d-block mt-1 text-danger">Date limite du00e9passu00e9e</span>
                                    @elseif($devoir->statut == 'en_attente')
                                        <span class="d-block mt-1">
                                            Temps restant: {{ now()->diffForHumans($devoir->date_limite, ['parts' => 2]) }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <p class="mb-1"><strong>Type de travail:</strong></p>
                                <p class="mb-0">{{ $devoir->type }}</p>
                            </div>
                            
                            <div class="mb-0">
                                <p class="mb-1"><strong>Barème:</strong></p>
                                <p class="mb-0">/20</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
