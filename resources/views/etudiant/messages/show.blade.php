@extends('layouts.app')

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
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
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
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($message->thread as $threadMessage)
                        <div class="list-group-item p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    {{ $threadMessage->expediteur_nom }} {{ $threadMessage->expediteur_prenom }}
                                    <small class="text-muted ms-2">{{ $threadMessage->expediteur_role }}</small>
                                </h6>
                                <small class="text-muted">{{ $threadMessage->date->format('d/m/Y H:i') }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit(strip_tags($threadMessage->contenu), 200) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
