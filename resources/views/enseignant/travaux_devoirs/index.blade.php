@extends('layouts.app')

@section('title', 'Travaux et Devoirs')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Travaux et Devoirs</h1>
            <p class="text-muted">Cours: {{ $cours->titre }}</p>
        </div>
        <a href="{{ route('enseignant.travaux_devoirs.create', $cours->id) }}" class="btn btn-add-resource">
            <i class="fas fa-plus-circle me-2"></i> Ajouter un Travail/Devoir
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Travaux et Devoirs</h6>
            <a href="{{ route('enseignant.cours') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour aux Cours
            </a>
        </div>
        <div class="card-body">
            @if(count($travauxDevoirs) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Date Limite</th>
                                <th>Fichier</th>
                                <th>Soumissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($travauxDevoirs as $travailDevoir)
                                <tr>
                                    <td>{{ $travailDevoir->titre }}</td>
                                    <td>
                                        @if($travailDevoir->date_limite)
                                            <span class="{{ $travailDevoir->date_limite < now() ? 'text-danger' : 'text-success' }}">
                                                {{ $travailDevoir->date_limite->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">Non définie</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($travailDevoir->fichier)
                                            <a href="{{ asset('storage/travaux_devoirs/' . $travailDevoir->fichier) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i> Télécharger
                                            </a>
                                        @else
                                            <span class="text-muted">Aucun fichier</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('enseignant.soumissions', [$cours->id, $travailDevoir->id]) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-file-alt me-1"></i> {{ $travailDevoir->soumissions->count() }} Soumission(s)
                                        </a>
                                    </td>
                                    <td>
                                        <div class="resource-actions">
                                            <a href="{{ route('enseignant.travaux_devoirs.edit', [$cours->id, $travailDevoir->id]) }}" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('enseignant.travaux_devoirs.delete', [$cours->id, $travailDevoir->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce travail/devoir ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0 text-danger" title="Supprimer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="mb-0">Aucun travail ou devoir n'a été créé pour ce cours.</p>
                    <a href="{{ route('enseignant.travaux_devoirs.create', $cours->id) }}" class="btn btn-primary mt-3">Ajouter un Travail/Devoir</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
