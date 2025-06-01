@extends('layouts.app')

@section('title', 'Soumissions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold mb-0">Soumissions</h1>
        <div class="me-3">
            <form action="{{ route('enseignant.soumissions') }}" method="GET" class="d-flex">
                <select name="groupe_id" class="form-select me-2" onchange="this.form.submit()">
                    <option value="">Tous les groupes</option>
                    @foreach($groupes as $groupe)
                        <option value="{{ $groupe->id }}" {{ $classeId == $groupe->id ? 'selected' : '' }}>{{ $groupe->nom }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold">Liste des Soumissions</h6>
        </div>
        <div class="card-body">
            @if(count($soumissions) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Étudiant</th>
                                <th>Groupe</th>
                                <th>Travail/Devoir</th>
                                <th>Cours</th>
                                <th>Date de Soumission</th>
                                <th>Note</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($soumissions as $soumission)
                                <tr>
                                    <td class="ps-3">
                                        {{ $soumission->etudiant->prenom }} {{ $soumission->etudiant->nom }}
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ $soumission->etudiant->groupe->nom }}</span></td>
                                    <td>{{ $soumission->travailDevoir->titre }}</td>
                                    <td>{{ $soumission->cours->titre }}</td>
                                    <td>{{ $soumission->date_soumission->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($soumission->note)
                                            <span class="badge bg-{{ $soumission->note >= 10 ? 'success' : 'danger' }}">{{ $soumission->note }}/20</span>
                                        @else
                                            <span class="badge bg-secondary">Non noté</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        @if($soumission->fichier)
                                            <a href="{{ asset('storage/soumissions/' . $soumission->fichier) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i> Télécharger
                                            </a>
                                        @else
                                            <span class="text-muted">Aucun fichier</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="resource-actions">
                                            <a href="{{ asset('storage/soumissions/' . $soumission->fichier) }}" target="_blank" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="mb-0">Aucune soumission n'a été reçue pour ce travail/devoir.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
