@extends('layouts.app')

@section('title', 'Messages')

<<<<<<< HEAD
@section('styles')
<style>
    .chat-container {
        display: flex;
        height: calc(100vh - 200px);
        min-height: 500px;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .chat-sidebar {
        width: 300px;
        border-right: 1px solid #f0f0f0;
        overflow-y: auto;
        background-color: white;
    }
    
    .chat-header {
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
        background-color: #fff;
    }
    
    .chat-title {
        font-size: 1.2rem;
        font-weight: 500;
        color: #333;
    }
    
    .chat-actions {
        display: flex;
        gap: 10px;
    }
    
    .chat-search {
        padding: 10px 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .chat-search input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 20px;
        font-size: 0.9rem;
        background-color: #f8f9fa;
    }
    
    .chat-list {
        overflow-y: auto;
    }
    
    .chat-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #f5f5f5;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .chat-item:hover {
        background-color: #f8f9fa;
    }
    
    .chat-item.active {
        background-color: #f0f2ff;
        border-left: 3px solid #8668FF;
    }
    
    .chat-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        color: white;
        flex-shrink: 0;
    }
    
    .chat-info {
        flex-grow: 1;
        overflow: hidden;
    }
    
    .chat-name-time {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    
    .chat-name {
        font-weight: 500;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .chat-time {
        font-size: 0.8rem;
        color: #888;
        white-space: nowrap;
    }
    
    .chat-last-message {
        color: #666;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.9rem;
    }
    
    .chat-unread {
        position: relative;
    }
    
    .chat-unread .chat-name,
    .chat-unread .chat-last-message {
        font-weight: 600;
        color: #333;
    }
    
    .chat-unread::after {
        content: '';
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #8668FF;
    }
    
    .chat-main {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background-color: #f8f9fa;
    }
    
    .chat-messages {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto;
    }
    
    .message {
        margin-bottom: 20px;
        display: flex;
    }
    
    .message-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin-right: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        color: white;
        flex-shrink: 0;
    }
    
    .message-content {
        display: flex;
        flex-direction: column;
        max-width: 70%;
    }
    
    .message-bubble {
        background-color: white;
        padding: 10px 15px;
        border-radius: 18px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .message-actions {
        display: none;
        margin-top: 5px;
        text-align: right;
    }
    
    .message:hover .message-actions {
        display: block;
    }
    
    .message-action-btn {
        background: none;
        border: none;
        color: #8668FF;
        font-size: 0.8rem;
        padding: 2px 5px;
        cursor: pointer;
        opacity: 0.7;
    }
    
    .message-action-btn:hover {
        opacity: 1;
    }
    
    .chat-input {
        display: flex;
        align-items: center;
        padding: 15px;
        background-color: white;
        border-top: 1px solid #f0f0f0;
    }
    
    .chat-input-actions {
        display: flex;
        gap: 10px;
        margin-right: 10px;
    }
    
    .chat-input-action-btn {
        background: none;
        border: none;
        color: #666;
        font-size: 1.1rem;
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
        transition: background-color 0.2s;
    }
    
    .chat-input-action-btn:hover {
        background-color: #f0f0f0;
        color: #8668FF;
    }
    
    .emoji-picker {
        position: absolute;
        bottom: 70px;
        left: 15px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        z-index: 1000;
        width: 220px;
    }
    
    .emoji-btn {
        font-size: 1.5rem;
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
        transition: background-color 0.2s;
    }
    
    .emoji-btn:hover {
        background-color: #f0f0f0;
    }
    
    .chat-input input {
        flex-grow: 1;
        padding: 10px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 20px;
        margin-right: 10px;
    }
    
    .chat-send-btn {
        background-color: #8668FF;
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .chat-send-btn:hover {
        background-color: #7559ff;
    }
    
    .new-message-btn {
        background-color: #8668FF;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 8px 15px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .new-message-btn:hover {
        background-color: #7559ff;
    }
    
    .new-message-btn i {
        margin-right: 8px;
    }
    
    .empty-chat {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #888;
    }
    
    .empty-chat i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #ddd;
    }
    
    .modal-recipient-search {
        margin-bottom: 15px;
    }
    
    .recipient-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .recipient-item {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .recipient-item:hover {
        background-color: #f8f9fa;
    }
    
    .recipient-item.selected {
        background-color: #e7f3ff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="chat-container shadow-sm">
        <!-- Sidebar des conversations -->
        <div class="chat-sidebar">
            <div class="chat-header">
                <div class="d-flex align-items-center">
                    <div class="chat-title">Messages</div>
                    <div class="dropdown ms-2">
                        <button class="btn btn-sm" type="button" id="mailboxDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="mailboxDropdown">
                            <li><a class="dropdown-item" href="#">Boîte de réception</a></li>
                            <li><a class="dropdown-item" href="#">Messages envoyés</a></li>
                            <li><a class="dropdown-item" href="#">Corbeille</a></li>
                        </ul>
                    </div>
                </div>
                <a href="{{ route('etudiant.messages.create') }}" class="new-message-btn">
                    <i class="bi bi-envelope-plus"></i> Nouveau
                </a>
            </div>
            
            <div class="chat-search">
                <input type="text" placeholder="Rechercher..." />
            </div>
            
            <div class="chat-list">
                @forelse($messages as $message)
                    <a href="{{ route('etudiant.messages.show', $message->id) }}" class="chat-item {{ !$message->lu ? 'chat-unread' : '' }}">
                        <div class="chat-avatar bg-{{ ['primary', 'info', 'success', 'warning', 'danger', 'secondary'][array_rand(['primary', 'info', 'success', 'warning', 'danger', 'secondary'])] }}">
                            {{ strtoupper(substr($message->expediteur->nom, 0, 1)) }}
                        </div>
                        <div class="chat-info">
                            <div class="chat-name-time">
                                <div class="chat-name">{{ $message->expediteur->nom }} {{ $message->expediteur->prenom }}</div>
                                <div class="chat-time">{{ $message->date->format('d/m/Y') }}</div>
                            </div>
                            <div class="chat-last-message">
                                <span class="fw-medium">{{ $message->sujet }}:</span> {{ Str::limit(strip_tags($message->contenu), 40) }}
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-envelope-open mb-2" style="font-size: 2rem;"></i>
                        <p>Aucun message dans votre boîte de réception</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Zone principale -->
        <div class="chat-main">
            <div class="empty-chat">
                <i class="bi bi-chat-square-text"></i>
                <h5>Sélectionnez un message pour le lire</h5>
                <p>Ou créez un nouveau message avec le bouton <strong>Nouveau</strong></p>
=======
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
>>>>>>> login-acceuil
            </div>
        </div>
    </div>
</div>
@endsection
<<<<<<< HEAD

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation du sélecteur de messages
        const chatItems = document.querySelectorAll('.chat-item');
        chatItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Nous ne prévenons pas le comportement par défaut ici pour permettre la navigation
                // car les liens sont des liens <a> vers la route de détail du message
                
                // Mais on pourrait ajouter d'autres fonctionnalités ici si nécessaire
                // comme marquer le message comme lu via AJAX
            });
        });
    });
</script>
@endsection
=======
>>>>>>> login-acceuil
