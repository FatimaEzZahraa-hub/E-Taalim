@extends('layouts.app')

@section('title', 'Détails du Message')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('enseignant.messages') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="display-5 fw-bold mb-0">Message</h1>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $message->sujet }}</h5>
                <div>
                    @if($message->type == 'reçu')
                        <a href="{{ route('enseignant.messages.create') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-reply me-1"></i>Répondre
                        </a>
                    @endif
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        @if($message->type == 'reçu')
                            <strong>De :</strong> {{ $message->expediteur->prenom }} {{ $message->expediteur->nom }} ({{ $message->expediteur->type }})
                        @else
                            <strong>À :</strong> {{ $message->destinataire->prenom }} {{ $message->destinataire->nom }} ({{ $message->destinataire->type }})
                        @endif
                    </div>
                    <div class="text-muted">
                        {{ $message->date_envoi->format('d/m/Y H:i') }}
                    </div>
                </div>
                <hr>
                <div class="message-content">
                    {!! nl2br(e($message->contenu)) !!}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer ce message ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('enseignant.messages.delete', $message->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
