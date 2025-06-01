@extends('layouts.app')

@section('title', 'Détails du Cours')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-end align-items-center mb-4">
        <div class="d-flex">
            <a href="{{ route('enseignant.cours') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
            <a href="{{ route('enseignant.cours.edit', $cours->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #8668FF; color: white;">
                    <h5 class="mb-0">Informations du cours</h5>
                    <span class="badge bg-light text-dark">{{ isset($cours->groupe) && is_object($cours->groupe) ? $cours->groupe->nom : 'Groupe non défini' }}</span>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold">Description</h6>
                        <p class="mb-0">
                            @if(isset($cours->description) && !empty($cours->description))
                                {{ $cours->description }}
                            @else
                                <span class="text-muted">Aucune description</span>
                            @endif
                        </p>
                    </div>

                    @if(isset($cours->fichier) && !empty($cours->fichier))
                    <div class="mb-4">
                        <h6 class="fw-bold">Fichier du cours</h6>
                        <a href="{{ asset('storage/cours/' . $cours->fichier) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="fas fa-download me-1"></i> Télécharger le fichier
                        </a>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-tasks text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Travaux & Devoirs</h6>
                                    <p class="mb-0">{{ isset($cours->travauxDevoirs) && is_object($cours->travauxDevoirs) ? $cours->travauxDevoirs->count() : 0 }} éléments</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-clipboard-list text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Examens</h6>
                                    <p class="mb-0">{{ isset($cours->examens) && is_object($cours->examens) ? $cours->examens->count() : 0 }} éléments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="background-color: #8668FF; color: white;">
                    <h5 class="mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('enseignant.travaux_devoirs', $cours->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-tasks me-2 text-primary"></i>
                                Gérer les travaux & devoirs
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('enseignant.examens', $cours->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-clipboard-list me-2 text-info"></i>
                                Gérer les examens
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('enseignant.cours.edit', $cours->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-edit me-2 text-secondary"></i>
                                Modifier le cours
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>

                    <form action="{{ route('enseignant.cours.delete', $cours->id) }}" method="POST" class="mt-3" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash-alt me-2"></i> Supprimer ce cours
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
