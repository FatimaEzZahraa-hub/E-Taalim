@extends('layouts.app')

@section('title', 'Travaux et Devoirs')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold mb-0">Travaux et Devoirs</h1>
        <div class="d-flex align-items-center">
            <div class="me-3">
                <form action="{{ route('enseignant.travaux') }}" method="GET" class="d-flex">
                    <select name="classe_id" class="form-select me-2" onchange="this.form.submit()">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="devoirDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus me-2"></i>Créer un devoir
                </button>
                <ul class="dropdown-menu" aria-labelledby="devoirDropdown">
                    @forelse($travaux->pluck('cours')->unique('id') as $c)
                        <li><a class="dropdown-item" href="{{ route('enseignant.travaux_devoirs.create', ['coursId' => $c->id]) }}">{{ $c->titre }}</a></li>
                    @empty
                        <li><span class="dropdown-item text-muted">Aucun cours disponible</span></li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            @if(count($travaux) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Titre</th>
                                <th>Cours</th>
                                <th>Classe</th>
                                <th>Date limite</th>
                                <th>Soumissions</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($travaux as $travail)
                                <tr>
                                    <td class="ps-3 fw-medium">{{ $travail->titre }}</td>
                                    <td>{{ $travail->cours->titre }}</td>
                                    <td><span class="badge bg-light text-dark">{{ $travail->classe->nom }}</span></td>
                                    <td>{{ $travail->date_limite->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-primary">0 soumissions</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('enseignant.soumissions', ['coursId' => $travail->cours->id, 'travailDevoirId' => $travail->id]) }}" class="btn btn-sm btn-outline-primary me-1" title="Voir les soumissions">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('enseignant.travaux_devoirs.edit', ['coursId' => $travail->cours->id, 'id' => $travail->id]) }}" class="btn btn-sm btn-outline-secondary me-1" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $travail->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        
                                        <!-- Modal de confirmation de suppression -->
                                        <div class="modal fade" id="deleteModal{{ $travail->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $travail->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $travail->id }}">Confirmer la suppression</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        Êtes-vous sûr de vouloir supprimer le travail/devoir <strong>{{ $travail->titre }}</strong> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <form action="{{ route('enseignant.travaux_devoirs.delete', ['coursId' => $travail->cours->id, 'id' => $travail->id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <img src="{{ asset('images/empty-tasks.svg') }}" alt="Pas de travaux" class="img-fluid mb-3" style="max-width: 150px" onerror="this.src='{{ asset('images/logo-placeholder.jpg') }}'">
                    <h5 class="text-muted mb-3">Vous n'avez pas encore créé de travaux ou devoirs</h5>
                    <div>
                        <p class="text-muted mb-3">Essayez de sélectionner une autre classe dans le filtre ci-dessus ou</p>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="emptyDevoirDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-plus me-2"></i>Créer un devoir
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="emptyDevoirDropdown">
                                @forelse($travaux->pluck('cours')->unique('id') as $c)
                                    <li><a class="dropdown-item" href="{{ route('enseignant.travaux_devoirs.create', ['coursId' => $c->id]) }}">{{ $c->titre }}</a></li>
                                @empty
                                    <li><a class="dropdown-item" href="{{ route('enseignant.cours.create') }}">Créer un cours d'abord</a></li>
                                @endforelse
                            </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
