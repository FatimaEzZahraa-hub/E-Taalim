@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Messages</h1>
        <a href="{{ route('etudiant.messages.create') }}" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
            <i class="bi bi-envelope-plus me-1"></i> Nouveau message
        </a>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action active" style="background-color: #8668FF; border-color: #8668FF;">
                            <i class="bi bi-inbox me-2"></i> Boîte de ru00e9ception
                            @if($stats['non_lus'] > 0)
                                <span class="badge bg-light text-dark float-end">{{ $stats['non_lus'] }}</span>
                            @endif
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-send me-2"></i> Messages envoyés
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="bi bi-trash me-2"></i> Corbeille
                        </a>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filtres</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('etudiant.messages') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusAll" value="all" {{ request('status', 'all') == 'all' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusAll">
                                    Tous
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusUnread" value="unread" {{ request('status') == 'unread' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusUnread">
                                    Non lus
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusRead" value="read" {{ request('status') == 'read' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusRead">
                                    Lus
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="sender" class="form-label">Enseignant</label>
                            <select class="form-select" id="sender" name="sender">
                                <option value="">Tous les enseignants</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}" {{ request('sender') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background-color: #8668FF; border-color: #8668FF;">
                            <i class="bi bi-funnel me-1"></i> Filtrer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="input-group p-3 border-bottom">
                        <input type="text" class="form-control" placeholder="Rechercher dans les messages...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($messages as $message)
                            <a href="{{ route('etudiant.messages.show', $message->id) }}" class="list-group-item list-group-item-action p-3 {{ $message->lu ? '' : 'bg-light' }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 {{ $message->lu ? '' : 'fw-bold' }}">
                                        {{ $message->sujet }}
                                        @if(!$message->lu)
                                            <span class="badge bg-primary ms-2" style="background-color: #8668FF !important;">Nouveau</span>
                                        @endif
                                    </h6>
                                    <small class="text-muted">{{ $message->date->format('d/m/Y H:i') }}</small>
                                </div>
                                <div class="d-flex">
                                    <div class="me-2 flex-shrink-0">
                                        <div class="rounded-circle bg-secondary bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="text-secondary">{{ strtoupper(substr($message->expediteur->nom, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1">De: {{ $message->expediteur->nom }} {{ $message->expediteur->prenom }}</p>
                                        <p class="mb-0 text-muted small">{{ Str::limit(strip_tags($message->contenu), 100) }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-envelope-open fs-1 text-muted"></i>
                                <p class="mt-2 text-muted">Aucun message dans votre boîte de ru00e9ception</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-muted small">Affichage de {{ $messages->firstItem() ?? 0 }} u00e0 {{ $messages->lastItem() ?? 0 }} sur {{ $messages->total() }} message(s)</p>
                        </div>
                        <div>
                            {{ $messages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
