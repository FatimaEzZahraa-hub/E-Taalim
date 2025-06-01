@extends('layouts.app')

@section('title', 'Examens')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold mb-0">Examens</h1>
        <div class="d-flex align-items-center">
            <div class="me-3">
                <form action="{{ route('enseignant.examens') }}" method="GET" class="d-flex">
<<<<<<< HEAD
                    <select name="groupe_id" class="form-select me-2" onchange="this.form.submit()">
                        <option value="">Tous les groupes</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ $classeId == $groupe->id ? 'selected' : '' }}>{{ $groupe->nom }}</option>
=======
                    <select name="classe_id" class="form-select me-2" onchange="this.form.submit()">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
>>>>>>> login-acceuil
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="examenDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus me-2"></i>Créer un examen
                </button>
                <ul class="dropdown-menu" aria-labelledby="examenDropdown">
                    @forelse($examens->pluck('cours')->unique('id') as $c)
                        <li><a class="dropdown-item" href="{{ route('enseignant.cours.examens.create', ['coursId' => $c->id]) }}">{{ $c->titre }}</a></li>
                    @empty
                        <li><span class="dropdown-item text-muted">Aucun cours disponible</span></li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold">Liste des Examens</h6>
        </div>
        <div class="card-body">
            @if(count($examens) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Titre</th>
                                <th>Cours</th>
<<<<<<< HEAD
                                <th>Groupe</th>
=======
                                <th>Classe</th>
>>>>>>> login-acceuil
                                <th>Date d'Examen</th>
                                <th>Fichier</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($examens as $examen)
                                <tr>
                                    <td class="ps-3 fw-medium">{{ $examen->titre }}</td>
                                    <td>{{ $examen->cours->titre }}</td>
<<<<<<< HEAD
                                    <td><span class="badge bg-light text-dark">{{ $examen->groupe->nom }}</span></td>
=======
                                    <td><span class="badge bg-light text-dark">{{ $examen->classe->nom }}</span></td>
>>>>>>> login-acceuil
                                    <td>
                                        @if($examen->date_exam)
                                            <span class="{{ $examen->date_exam < now() ? 'text-danger' : 'text-success' }}">
                                                {{ $examen->date_exam->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">Non définie</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($examen->fichier)
                                            <a href="{{ asset('storage/examens/' . $examen->fichier) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i> Télécharger
                                            </a>
                                        @else
                                            <span class="text-muted">Aucun fichier</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="resource-actions">
                                            <a href="{{ route('enseignant.examens.edit', [$cours->id, $examen->id]) }}" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('enseignant.examens.delete', [$cours->id, $examen->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?');">
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
                    <p class="mb-0">Aucun examen n'a été créé pour ce cours.</p>
                    <a href="{{ route('enseignant.examens.create', $cours->id) }}" class="btn btn-primary mt-3">Ajouter un Examen</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
