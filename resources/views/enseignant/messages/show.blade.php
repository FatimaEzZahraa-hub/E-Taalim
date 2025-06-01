@extends('layouts.app')

@section('title', 'Détails du Message')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('enseignant.messages') }}" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 fw-bold mb-1" style="color: #333;">Message</h1>
                <p class="text-muted mb-0">Détails de la conversation</p>
            </div>
        </div>
        <div>
            @if($message->type == 'reçu')
                <a href="{{ route('enseignant.messages.create') }}" class="btn btn-light rounded-pill me-2">
                    <i class="bi bi-reply-fill me-2"></i>Répondre
                </a>
            @endif
            <button type="button" class="btn btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash me-2"></i>Supprimer
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4 p-lg-5">
            <!-- Entête du message -->
            <div class="message-header mb-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="message-avatar me-3">
                        <div class="avatar-circle" style="background-color: #8668FF; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 500; font-size: 1.5rem;">
                            @if($message->type == 'reçu')
                                {{ strtoupper(substr($message->expediteur->prenom, 0, 1)) }}{{ strtoupper(substr($message->expediteur->nom, 0, 1)) }}
                            @else
                                {{ strtoupper(substr($message->destinataire->prenom, 0, 1)) }}{{ strtoupper(substr($message->destinataire->nom, 0, 1)) }}
                            @endif
                        </div>
                    </div>
                    <div>
                        <h2 class="h4 fw-bold mb-1">{{ $message->sujet }}</h2>
                        <div class="text-muted">
                            @if($message->type == 'reçu')
                                <span class="fw-medium">De :</span> {{ $message->expediteur->prenom }} {{ $message->expediteur->nom }}
                            @else
                                <span class="fw-medium">À :</span> {{ $message->destinataire->prenom }} {{ $message->destinataire->nom }}
                            @endif
                            <span class="mx-2">&bull;</span>
                            <span>{{ $message->date_envoi->format('d/m/Y à H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Badge de statut -->
                <div class="mb-4">
                    @if($message->type == 'reçu')
                        <span class="badge rounded-pill" style="background-color: #8668FF;">
                            <i class="bi bi-envelope-fill me-1"></i> Reçu
                        </span>
                    @else
                        <span class="badge rounded-pill bg-light text-dark border">
                            <i class="bi bi-send-fill me-1"></i> Envoyé
                        </span>
                    @endif
                </div>
                
                <hr class="my-4">
            </div>
            
            <!-- Contenu du message -->
            <div class="message-content p-3 p-lg-4 rounded-4" style="background-color: #f8f9fa; line-height: 1.8;">
                {!! nl2br(e($message->contenu)) !!}
            </div>
        </div>
    </div>
    
    <!-- Actions rapides -->
    <div class="d-flex justify-content-center mb-5">
        <a href="{{ route('enseignant.messages') }}" class="btn btn-light rounded-pill me-3">
            <i class="bi bi-arrow-left me-2"></i>Retour aux messages
        </a>
        @if($message->type == 'reçu')
            <a href="{{ route('enseignant.messages.create') }}" class="btn btn-action">
                <i class="bi bi-reply-fill me-2"></i>Répondre
            </a>
        @endif
    </div>
    
    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-0">Êtes-vous sûr de vouloir supprimer ce message ?</p>
                    <p class="text-muted small">Cette action est irréversible.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('enseignant.messages.delete', $message->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill">
                            <i class="bi bi-trash me-2"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
