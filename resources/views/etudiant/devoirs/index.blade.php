@extends('layouts.app')

@section('title', 'Mes Devoirs')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Mes devoirs</h1>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-funnel me-1"></i> Filtrer
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="#">Tous les devoirs</a></li>
                    <li><a class="dropdown-item" href="#">À rendre</a></li>
                    <li><a class="dropdown-item" href="#">Soumis</a></li>
                    <li><a class="dropdown-item" href="#">En retard</a></li>
                    <li><a class="dropdown-item" href="#">Évalués</a></li>
                </ul>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Titre</th>
                            <th scope="col">Cours</th>
                            <th scope="col">Date limite</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Note</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devoirs as $devoir)
                            <tr class="{{ $devoir->statut == 'en_retard' ? 'table-danger' : '' }}">
                                <td>
                                    <div class="fw-bold">{{ $devoir->titre }}</div>
                                    <div class="small text-muted">{{ Str::limit($devoir->description, 50) }}</div>
                                </td>
                                <td>{{ $devoir->cours }}</td>
                                <td>
                                    <span class="{{ $devoir->statut == 'en_retard' ? 'text-danger' : '' }}">
                                        {{ $devoir->date_limite->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ 
                                        $devoir->statut == 'en_attente' ? 'bg-warning' : 
                                        ($devoir->statut == 'soumis' ? 'bg-info' : 
                                        ($devoir->statut == 'en_retard' ? 'bg-danger' : 
                                        ($devoir->statut == 'évalué' ? 'bg-success' : 'bg-secondary'))) 
                                    }}">
                                        {{ 
                                            $devoir->statut == 'en_attente' ? 'À rendre' : 
                                            ($devoir->statut == 'soumis' ? 'Soumis' : 
                                            ($devoir->statut == 'en_retard' ? 'En retard' : 
                                            ($devoir->statut == 'évalué' ? 'Évalué' : 'Inconnu'))) 
                                        }}
                                    </span>
                                </td>
                                <td>
                                    @if($devoir->statut == 'évalué')
                                        <span class="badge bg-light text-dark p-2">
                                            {{ $devoir->note }}/20
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('etudiant.devoirs.show', $devoir->id) }}" class="btn btn-sm btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                                        <i class="bi {{ $devoir->statut == 'en_attente' || $devoir->statut == 'en_retard' ? 'bi-upload' : 'bi-eye' }}"></i>
                                        {{ $devoir->statut == 'en_attente' || $devoir->statut == 'en_retard' ? 'Soumettre' : 'Voir' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-clipboard fs-1 text-muted"></i>
                                    <p class="mt-2 text-muted">Aucun devoir trouvé.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $devoirs->links() }}
    </div>
</div>
@endsection
