@extends('layouts.app')

@section('title', 'Mes Examens')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Mes examens</h1>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-funnel me-1"></i> Filtrer
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="#">Tous les examens</a></li>
                    <li><a class="dropdown-item" href="#">u00c0 venir</a></li>
                    <li><a class="dropdown-item" href="#">Passu00e9s</a></li>
                    <li><a class="dropdown-item" href="#">En ligne</a></li>
                    <li><a class="dropdown-item" href="#">En pru00e9sentiel</a></li>
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
                            <th scope="col">Date</th>
                            <th scope="col">Duru00e9e</th>
                            <th scope="col">Type</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($examens as $examen)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $examen->titre }}</div>
                                    <div class="small text-muted">{{ Str::limit($examen->description, 50) }}</div>
                                </td>
                                <td>{{ $examen->cours }}</td>
                                <td>
                                    {{ $examen->date->format('d/m/Y') }}<br>
                                    <small class="text-muted">{{ $examen->heure_debut }} - {{ $examen->heure_fin }}</small>
                                </td>
                                <td>{{ $examen->duree }} min</td>
                                <td>
                                    <span class="badge {{ $examen->type == 'en_ligne' ? 'bg-info' : 'bg-secondary' }}">
                                        {{ $examen->type == 'en_ligne' ? 'En ligne' : 'En pru00e9sentiel' }}
                                    </span>
                                </td>
                                <td>
                                    @if($examen->date->isPast())
                                        <span class="badge bg-secondary">Passu00e9</span>
                                    @elseif($examen->date->isToday())
                                        <span class="badge bg-danger">Aujourd'hui</span>
                                    @elseif($examen->date->diffInDays(now()) <= 7)
                                        <span class="badge bg-warning">Cette semaine</span>
                                    @else
                                        <span class="badge bg-light text-dark">u00c0 venir</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('etudiant.examens.show', $examen->id) }}" class="btn btn-sm btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                                        <i class="bi bi-eye"></i> Du00e9tails
                                    </a>
                                    @if($examen->type == 'en_ligne' && $examen->date->isToday() && now()->format('H:i') >= $examen->heure_debut && now()->format('H:i') <= $examen->heure_fin)
                                        <a href="#" class="btn btn-sm btn-success ms-1">
                                            <i class="bi bi-play-fill"></i> Commencer
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-calendar2-x fs-1 text-muted"></i>
                                    <p class="mt-2 text-muted">Aucun examen trouvu00e9.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $examens->links() }}
    </div>
</div>
@endsection
