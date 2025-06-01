@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'Détails du Message')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('etudiant.messages') }}" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 fw-bold mb-1" style="color: #333;">Message</h1>
                <p class="text-muted mb-0">Détails de la conversation</p>
            </div>
        </div>
        <div>
            <a href="{{ route('etudiant.messages.create') }}?reply={{ $message->id }}" class="btn btn-light rounded-pill me-2">
                <i class="bi bi-reply-fill me-2"></i>Répondre
            </a>
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
                            {{ strtoupper(substr($message->expediteur_nom, 0, 1)) }}{{ strtoupper(substr($message->expediteur_prenom, 0, 1)) }}
                        </div>
                    </div>
                    <div>
                        <h2 class="h4 fw-bold mb-1">{{ $message->sujet }}</h2>
                        <div class="text-muted">
                            <span class="fw-medium">De :</span> {{ $message->expediteur_nom }} {{ $message->expediteur_prenom }}
                            <span class="mx-2">&bull;</span>
                            <span>{{ $message->date->format('d/m/Y à H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Badge de statut -->
                <div class="mb-4">
                    <span class="badge rounded-pill" style="background-color: #8668FF;">
                        <i class="bi bi-envelope-fill me-1"></i> Reçu
                    </span>
                    @if($message->important)
                        <span class="badge bg-danger rounded-pill ms-2">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Important
                        </span>
                    @endif
                </div>
                
                <hr class="my-4">
            </div>
            
            <!-- Contenu du message -->
            <div class="message-content p-3 p-lg-4 rounded-4" style="background-color: #f8f9fa; line-height: 1.8;">
                {!! nl2br(e($message->contenu)) !!}
            </div>
            
            <!-- Pièces jointes -->
            @if(count($message->pieces_jointes) > 0)
                <div class="mt-4">
                    <h5 class="fw-bold mb-3">Pièces jointes</h5>
                    <div class="list-group">
                        @foreach($message->pieces_jointes as $piece_jointe)
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 rounded-3 mb-2 p-3">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 p-2 rounded-circle" style="background-color: rgba(134, 104, 255, 0.1);">
                                        <i class="bi {{ 
                                            Str::endsWith($piece_jointe->nom, '.pdf') ? 'bi-file-pdf' : 
                                            (Str::endsWith($piece_jointe->nom, ['.doc', '.docx']) ? 'bi-file-word' : 
                                            (Str::endsWith($piece_jointe->nom, ['.xls', '.xlsx']) ? 'bi-file-excel' : 
                                            (Str::endsWith($piece_jointe->nom, ['.ppt', '.pptx']) ? 'bi-file-ppt' : 
                                            (Str::endsWith($piece_jointe->nom, ['.jpg', '.jpeg', '.png', '.gif']) ? 'bi-file-image' : 'bi-file')))) 
                                        }}" style="color: #8668FF; font-size: 1.25rem;"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium">{{ $piece_jointe->nom }}</p>
                                        <small class="text-muted">{{ $piece_jointe->taille }}</small>
                                    </div>
                                </div>
                                <i class="bi bi-download text-muted"></i>
=======
@section('title', 'Message - ' . $message->sujet)

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.messages') }}">Messages</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($message->sujet, 50) }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">{{ $message->sujet }}</h1>
                <div>
                    <a href="{{ route('etudiant.messages.create') }}?reply={{ $message->id }}" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                        <i class="bi bi-reply me-1"></i> Ru00e9pondre
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div class="me-3">
                    <div class="rounded-circle bg-secondary bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <span class="fs-4 text-secondary">{{ strtoupper(substr($message->expediteur_nom, 0, 1)) }}</span>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">{{ $message->expediteur_nom }} {{ $message->expediteur_prenom }}</h5>
                    <p class="text-muted mb-0">{{ $message->expediteur_role }}</p>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">
                            <i class="bi bi-clock me-1"></i> {{ $message->date->format('d/m/Y u00e0 H:i') }}
                        </span>
                    </div>
                    <div>
                        @if($message->important)
                            <span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i> Important</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="message-content">
                        {!! nl2br(e($message->contenu)) !!}
                    </div>
                </div>
            </div>

            @if(count($message->pieces_jointes) > 0)
                <div class="mb-3">
                    <h5>Piu00e8ces jointes</h5>
                    <div class="list-group">
                        @foreach($message->pieces_jointes as $piece_jointe)
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi {{ 
                                        Str::endsWith($piece_jointe->nom, '.pdf') ? 'bi-file-pdf' : 
                                        (Str::endsWith($piece_jointe->nom, ['.doc', '.docx']) ? 'bi-file-word' : 
                                        (Str::endsWith($piece_jointe->nom, ['.xls', '.xlsx']) ? 'bi-file-excel' : 
                                        (Str::endsWith($piece_jointe->nom, ['.ppt', '.pptx']) ? 'bi-file-ppt' : 
                                        (Str::endsWith($piece_jointe->nom, ['.jpg', '.jpeg', '.png', '.gif']) ? 'bi-file-image' : 'bi-file')))) 
                                    }} me-2"></i>
                                    {{ $piece_jointe->nom }}
                                </div>
                                <span class="badge bg-light text-dark">{{ $piece_jointe->taille }}</span>
>>>>>>> login-acceuil
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
<<<<<<< HEAD
    </div>
    
    <!-- Actions rapides -->
    <div class="d-flex justify-content-center mb-5">
        <a href="{{ route('etudiant.messages') }}" class="btn btn-light rounded-pill me-3">
            <i class="bi bi-arrow-left me-2"></i>Retour aux messages
        </a>
        <a href="{{ route('etudiant.messages.create') }}?reply={{ $message->id }}" class="btn btn-action rounded-pill" style="background-color: #8668FF; color: white; border: none;">
            <i class="bi bi-reply-fill me-2"></i>Répondre
        </a>
    </div>
    
    <!-- Conversation précédente -->
    @if($message->thread && count($message->thread) > 0)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white p-4 border-0">
                <h5 class="fw-bold mb-0">Conversation précédente</h5>
=======
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('etudiant.messages') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour aux messages
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-danger">
                        <i class="bi bi-trash me-1"></i> Supprimer
                    </button>
                    <a href="{{ route('etudiant.messages.create') }}?reply={{ $message->id }}" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                        <i class="bi bi-reply me-1"></i> Ru00e9pondre
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($message->thread && count($message->thread) > 0)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Conversation pru00e9cu00e9dente</h5>
>>>>>>> login-acceuil
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($message->thread as $threadMessage)
<<<<<<< HEAD
                        <div class="list-group-item p-4 border-0 border-bottom">
                            <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle" style="width: 36px; height: 36px; background-color: rgba(134, 104, 255, 0.15); color: #8668FF; display: flex; align-items: center; justify-content: center; font-weight: 500; margin-right: 12px;">
                                        {{ strtoupper(substr($threadMessage->expediteur_nom, 0, 1)) }}
                                    </div>
                                    <h6 class="mb-0 fw-bold">
                                        {{ $threadMessage->expediteur_nom }} {{ $threadMessage->expediteur_prenom }}
                                        <span class="fw-normal text-muted ms-2 small">{{ $threadMessage->expediteur_role }}</span>
                                    </h6>
                                </div>
                                <small class="text-muted">{{ $threadMessage->date->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="ms-5 ps-3">
                                <p class="mb-0">{{ Str::limit(strip_tags($threadMessage->contenu), 200) }}</p>
                            </div>
=======
                        <div class="list-group-item p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    {{ $threadMessage->expediteur_nom }} {{ $threadMessage->expediteur_prenom }}
                                    <small class="text-muted ms-2">{{ $threadMessage->expediteur_role }}</small>
                                </h6>
                                <small class="text-muted">{{ $threadMessage->date->format('d/m/Y H:i') }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit(strip_tags($threadMessage->contenu), 200) }}</p>
>>>>>>> login-acceuil
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
<<<<<<< HEAD
    
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
                    <form action="{{ route('etudiant.messages') }}" method="POST" class="d-inline">
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
=======
>>>>>>> login-acceuil
</div>
@endsection
