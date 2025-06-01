@extends('layouts.app')

@section('title', 'Gestion des Cours')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-end align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <form action="{{ route('enseignant.cours') }}" method="GET" class="d-flex">
                    <select name="classe_id" class="form-select me-2" onchange="this.form.submit()">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <a href="{{ route('enseignant.cours.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Ajouter un cours
            </a>
        </div>
    </div>
    
    @if(count($cours) > 0)
        <div class="row">
            @foreach($cours as $c)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card resource-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa;">
                            <div>
                                <h5 class="card-title mb-0">{{ $c->titre ?? 'Cours sans titre' }}</h5>
                                <span class="badge bg-light text-dark mt-1">{{ isset($c->classe) && is_object($c->classe) ? $c->classe->nom : 'Classe non définie' }}</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link p-0" type="button" id="dropdownMenuButton{{ $c->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $c->id }}">
                                    <li><a class="dropdown-item" href="{{ route('enseignant.cours.edit', $c->id) }}"><i class="fas fa-edit me-2"></i> Modifier</a></li>
                                    <li><a class="dropdown-item" href="{{ route('enseignant.travaux_devoirs', $c->id) }}"><i class="fas fa-tasks me-2"></i> Travaux & Devoirs</a></li>
                                    <li><a class="dropdown-item" href="{{ route('enseignant.examens', $c->id) }}"><i class="fas fa-clipboard-list me-2"></i> Examens</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('enseignant.cours.delete', $c->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt me-2"></i> Supprimer</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                @if(isset($c->description) && !empty($c->description))
                                    {{ \Illuminate\Support\Str::limit($c->description, 150) }}
                                @else
                                    <span class="text-muted">Aucune description</span>
                                @endif
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">Cours</small>
                                
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2" title="Travaux & Devoirs">
                                        <i class="fas fa-tasks me-1"></i> {{ isset($c->travauxDevoirs) && is_object($c->travauxDevoirs) ? $c->travauxDevoirs->count() : 0 }}
                                    </span>
                                    <span class="badge bg-info" title="Examens">
                                        <i class="fas fa-clipboard-list me-1"></i> {{ isset($c->examens) && is_object($c->examens) ? $c->examens->count() : 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            @if(isset($c->fichier) && !empty($c->fichier))
                                <a href="{{ asset('storage/cours/' . $c->fichier) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="fas fa-download me-1"></i> Télécharger
                                </a>
                            @else
                                <span></span>
                            @endif
                            
                            <div class="resource-actions">
                                <a href="{{ route('enseignant.travaux_devoirs', $c->id) }}" title="Travaux & Devoirs" style="color: #4CAF50; margin-right: 8px;">
                                    <i class="fas fa-tasks"></i>
                                </a>
                                <a href="{{ route('enseignant.examens', $c->id) }}" title="Examens" style="color: #2196F3; margin-right: 8px;">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                                <a href="{{ route('enseignant.cours.edit', $c->id) }}" title="Modifier" style="color: #FF9800;">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- Lien précédent --}}
                    @if ($cours->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $cours->previousPageUrl() }}" rel="prev">&laquo;</a>
                        </li>
                    @endif

                    {{-- Liens des pages --}}
                    @for ($i = 1; $i <= $cours->lastPage(); $i++)
                        <li class="page-item {{ ($cours->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $cours->url($i) }}" style="{{ ($cours->currentPage() == $i) ? 'background-color: #8668FF; border-color: #8668FF;' : '' }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Lien suivant --}}
                    @if ($cours->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $cours->nextPageUrl() }}" rel="next">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">&raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @else
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5">
                <img src="{{ asset('images/empty-courses.svg') }}" alt="Pas de cours" class="img-fluid mb-3" style="max-width: 150px" onerror="this.src='{{ asset('images/logo-placeholder.jpg') }}'">
                <h5 class="text-muted mb-3">Vous n'avez pas encore créé de cours</h5>
                <p class="text-muted mb-3">Essayez de sélectionner une autre classe dans le filtre ci-dessus ou</p>
                <a href="{{ route('enseignant.cours.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Ajouter un cours
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
