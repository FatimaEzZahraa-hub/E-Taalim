@extends('layouts.app')

@section('title', 'Messages')

@section('styles')
<style>
    .message-list {
        background-color: white;
    }
    
    .message-item {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #f0f0f0;
        text-decoration: none;
        color: #333;
        position: relative;
    }
    
    .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #8668FF;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .message-content {
        flex-grow: 1;
    }
    
    .message-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    
    .message-name {
        font-weight: 500;
        color: #333;
    }
    
    .message-date {
        font-size: 0.8rem;
        color: #888;
    }
    
    .message-subject {
        color: #666;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 90%;
    }
    
    .message-actions {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .message-badge {
        background-color: #8668FF;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .delete-btn {
        color: #ff6b6b;
        background: none;
        border: none;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    
    .delete-btn:hover {
        opacity: 1;
    }
    
    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #eee;
        margin-bottom: 0;
    }
    
    .tab-button {
        padding: 12px 20px;
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        font-weight: 500;
        color: #666;
        display: flex;
        align-items: center;
    }
    
    .tab-button.active {
        color: #8668FF;
        border-bottom-color: #8668FF;
    }
    
    .tab-button i {
        margin-right: 8px;
    }
    
    .tab-button .badge {
        margin-left: 8px;
        background-color: #8668FF;
        color: white;
        font-size: 0.7rem;
        border-radius: 10px;
        padding: 2px 6px;
    }
    
    .search-box {
        padding: 10px 15px;
        border: 1px solid #eee;
        border-radius: 20px;
        width: 250px;
        font-size: 0.9rem;
    }
    
    .search-box:focus {
        outline: none;
        border-color: #8668FF;
    }
    
    .new-message-btn {
        background-color: #8668FF;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 500;
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
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Messagerie</h1>
            <p class="text-muted mb-0">Gérez vos conversations avec les étudiants</p>
        </div>
        <a href="{{ route('enseignant.messages.create') }}" class="new-message-btn">
            <i class="bi bi-plus-circle"></i> Nouveau message
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
                <div class="tab-buttons">
                    <button class="tab-button active" data-tab="inbox">
                        <i class="bi bi-inbox"></i> Boîte de réception
                        <span class="badge">2</span>
                    </button>
                    <button class="tab-button" data-tab="sent">
                        <i class="bi bi-cursor"></i> Messages envoyés
                    </button>
                </div>
                <div>
                    <input type="text" class="search-box" placeholder="Rechercher...">
                </div>
            </div>
            
            <div class="tab-content">
                <div class="tab-pane active" id="inbox">
                    <div class="message-list">
                        <!-- Message 1 -->
                        <div class="message-item">
                            <div class="message-avatar">PN</div>
                            <div class="message-content">
                                <div class="message-header">
                                    <div class="message-name">Prénom 2 Nom 2</div>
                                    <div class="message-date">2 days ago</div>
                                </div>
                                <div class="message-subject">Sujet du message 2</div>
                            </div>
                            <div class="message-actions">
                                <button class="delete-btn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Message 2 -->
                        <div class="message-item">
                            <div class="message-avatar">PN</div>
                            <div class="message-content">
                                <div class="message-header">
                                    <div class="message-name">Prénom 4 Nom 4</div>
                                    <div class="message-date">4 days ago</div>
                                </div>
                                <div class="message-subject">Sujet du message 4</div>
                            </div>
                            <div class="message-actions">
                                <button class="delete-btn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Message 3 -->
                        <div class="message-item">
                            <div class="message-avatar">PN</div>
                            <div class="message-content">
                                <div class="message-header">
                                    <div class="message-name">Prénom 6 Nom 6</div>
                                    <div class="message-date">6 days ago</div>
                                </div>
                                <div class="message-subject">Sujet du message 6</div>
                            </div>
                            <div class="message-actions">
                                <button class="delete-btn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Message 4 -->
                        <div class="message-item">
                            <div class="message-avatar">PN</div>
                            <div class="message-content">
                                <div class="message-header">
                                    <div class="message-name">Prénom 8 Nom 8</div>
                                    <div class="message-date">1 week ago</div>
                                </div>
                                <div class="message-subject">Sujet du message 8</div>
                            </div>
                            <div class="message-actions">
                                <span class="message-badge">Nouveau</span>
                                <button class="delete-btn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Message 5 -->
                        <div class="message-item">
                            <div class="message-avatar">PN</div>
                            <div class="message-content">
                                <div class="message-header">
                                    <div class="message-name">Prénom 10 Nom 10</div>
                                    <div class="message-date">1 week ago</div>
                                </div>
                                <div class="message-subject">Sujet du message 10</div>
                            </div>
                            <div class="message-actions">
                                <span class="message-badge">Nouveau</span>
                                <button class="delete-btn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane" id="sent" style="display: none;">
                    <!-- Contenu des messages envoyés ici -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Activer le bouton d'onglet
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Afficher le contenu de l'onglet
            tabPanes.forEach(pane => {
                if (pane.id === tabId) {
                    pane.style.display = 'block';
                    pane.classList.add('active');
                } else {
                    pane.style.display = 'none';
                    pane.classList.remove('active');
                }
            });
        });
    });
});
</script>
@endsection
