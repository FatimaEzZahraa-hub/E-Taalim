@extends('layouts.app')

@section('title', 'Messages')

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
    
    .message.sent {
        justify-content: flex-end;
    }
    
    .message.sent .message-bubble {
        background-color: #8668FF;
        color: white;
    }
    
    .message-time {
        font-size: 0.7rem;
        color: #888;
        margin-top: 5px;
        text-align: right;
    }
    
    .chat-input {
        padding: 15px;
        border-top: 1px solid #f0f0f0;
        background-color: white;
        display: flex;
        align-items: center;
        position: relative;
    }
    
    /* Style pour le sélecteur d'emoji */
    .emoji-picker {
        position: absolute;
        bottom: 60px;
        left: 15px;
        width: 250px;
        background-color: white;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 10px;
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 5px;
        z-index: 1000;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
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
        font-size: 0.95rem;
    }
    
    .chat-input .send-btn {
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
    }
    
    .chat-input .new-message-btn {
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
        box-shadow: 0 2px 5px rgba(134, 104, 255, 0.3);
    }
    
    .chat-input .input-actions {
        display: flex;
        gap: 10px;
        margin-right: 10px;
    }
    
    .chat-input .input-action {
        color: #8668FF;
        background: none;
        border: none;
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
    
    /* Couleurs pour les avatars */
    .bg-primary { background-color: #8668FF; }
    .bg-info { background-color: #17a2b8; }
    .bg-success { background-color: #28a745; }
    .bg-warning { background-color: #ffc107; color: #212529; }
    .bg-danger { background-color: #dc3545; }
    .bg-secondary { background-color: #6c757d; }
    .bg-dark { background-color: #343a40; }
    .bg-purple { background-color: #8668FF; }
    .bg-pink { background-color: #e83e8c; }
    .bg-orange { background-color: #fd7e14; }
    .bg-teal { background-color: #20c997; }
    
    /* Styles pour le modal de nouveau message */
    .recipient-results {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
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
                        <button class="btn btn-sm btn-outline-secondary rounded-circle" id="messagesMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="messagesMenuButton">
                            <li><a class="dropdown-item" href="#" id="markAllAsRead"><i class="bi bi-check-all me-2"></i> Marquer tout comme lu</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-archive me-2"></i> Archives</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Paramètres</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Le bouton de rafraîchissement a été supprimé -->
            </div>
            
            <div class="chat-search">
                <input type="text" placeholder="Rechercher..." />
            </div>
            
            <div class="chat-list">
                <!-- Conversation 1 - Active -->
                <div class="chat-item active">
                    <div class="chat-avatar bg-primary">T</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">Tee</div>
                            <div class="chat-time">15 Min</div>
                        </div>
                        <div class="chat-last-message">You: Hey whats up</div>
                    </div>
                </div>
                
                <!-- Conversation 2 (avec indicateur non lu) -->
                <div class="chat-item chat-unread">
                    <div class="chat-avatar bg-warning">Z</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">Zeepay</div>
                            <div class="chat-time">12:36 PM</div>
                        </div>
                        <div class="chat-last-message">Hi Neequaye Kotey...</div>
                    </div>
                </div>
                
                <!-- Conversation 3 -->
                <div class="chat-item">
                    <div class="chat-avatar bg-secondary">C</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">CloudOTP</div>
                            <div class="chat-time">12:36 PM</div>
                        </div>
                        <div class="chat-last-message">796508 is your veri...</div>
                    </div>
                </div>
                
                <!-- Conversation 4 (avec indicateur non lu) -->
                <div class="chat-item chat-unread">
                    <div class="chat-avatar bg-info">GK</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">Gatekeeper</div>
                            <div class="chat-time">12:36 PM</div>
                        </div>
                        <div class="chat-last-message">Welcome to Our G...</div>
                    </div>
                </div>
                
                <!-- Conversation 5 -->
                <div class="chat-item">
                    <div class="chat-avatar bg-purple">M</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">MyMTN 2.0</div>
                            <div class="chat-time">12:36 PM</div>
                        </div>
                        <div class="chat-last-message">Yello MTNner, do...</div>
                    </div>
                </div>
                
                <!-- Conversation 6 -->
                <div class="chat-item">
                    <div class="chat-avatar bg-success">MK</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">Mama K</div>
                            <div class="chat-time">12:36 PM</div>
                        </div>
                        <div class="chat-last-message">Where is you fath...</div>
                    </div>
                </div>
                
                <!-- Conversation 7 -->
                <div class="chat-item">
                    <div class="chat-avatar bg-danger">N</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">Nana</div>
                            <div class="chat-time">12:36 PM</div>
                        </div>
                        <div class="chat-last-message">yo man, food dey...</div>
                    </div>
                </div>
                
                <!-- Conversation 8 -->
                <div class="chat-item">
                    <div class="chat-avatar bg-dark">VC</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">VodaCash</div>
                            <div class="chat-time">12:36 PM</div>
                        </div>
                        <div class="chat-last-message">Payment of GHS 3...</div>
                    </div>
                </div>
                
                <!-- Conversation 9 -->
                <div class="chat-item">
                    <div class="chat-avatar bg-pink">B</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">Bunda</div>
                            <div class="chat-time">12:36 PM</div>
                        </div>
                        <div class="chat-last-message">Amber where are...</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Zone principale de chat -->
        <div class="chat-main">
            <!-- En-tête du chat actif -->
            <div class="chat-header">
                <div class="d-flex align-items-center">
                    <div class="chat-avatar bg-primary me-2">N</div>
                    <div>
                        <div class="chat-title">Nana</div>
                    </div>
                </div>
                <div class="chat-actions">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary rounded-circle" id="chatMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatMenuButton">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-check2-circle me-2"></i> Mark as unread</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-pin-angle me-2"></i> Pin</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-bell-slash me-2"></i> Mute</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item d-none group-chat-option" href="#"><i class="bi bi-box-arrow-right me-2"></i> Leave</a></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Messages -->
            <div class="chat-messages">
                <div class="text-center text-muted small mb-4">Thursday, Jan 4 • 6:21 PM</div>
                
                <!-- Message système -->
                <div class="text-center text-muted small mb-4 mt-3">
                    <span class="badge bg-light text-dark">Messages et appels sont chiffrés de bout en bout</span>
                </div>
                
                <!-- Message reçu -->
                <div class="message">
                    <div class="message-avatar bg-danger">N</div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <div>Yo mandem</div>
                            <div class="message-time">6:21 PM</div>
                        </div>
                        <div class="message-actions">
                            <button class="message-action-btn" title="Répondre"><i class="bi bi-reply"></i></button>
                            <button class="message-action-btn" title="Transférer"><i class="bi bi-forward"></i></button>
                            <div class="dropdown d-inline">
                                <button class="message-action-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i> Marquer</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-clipboard me-2"></i> Copier</a></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Supprimer</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Message reçu -->
                <div class="message">
                    <div class="message-avatar bg-danger">N</div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <div>Cho dey house?</div>
                            <div class="message-time">6:22 PM</div>
                        </div>
                        <div class="message-actions">
                            <button class="message-action-btn" title="Répondre"><i class="bi bi-reply"></i></button>
                            <button class="message-action-btn" title="Transférer"><i class="bi bi-forward"></i></button>
                            <div class="dropdown d-inline">
                                <button class="message-action-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i> Marquer</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-clipboard me-2"></i> Copier</a></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Supprimer</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Message envoyé -->
                <div class="message sent">
                    <div class="message-content">
                        <div class="message-bubble">
                            <div>Kwasia</div>
                            <div class="message-time">6:25 PM</div>
                        </div>
                        <div class="message-actions">
                            <button class="message-action-btn" title="Répondre"><i class="bi bi-reply"></i></button>
                            <button class="message-action-btn" title="Transférer"><i class="bi bi-forward"></i></button>
                            <div class="dropdown d-inline">
                                <button class="message-action-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                <ul class="dropdown-menu dropdown-menu-start">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i> Marquer</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-clipboard me-2"></i> Copier</a></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Supprimer</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Message envoyé -->
                <div class="message sent">
                    <div class="message-content">
                        <div class="message-bubble">
                            <div>You dey hung dier you kai say house dey</div>
                            <div class="message-time">6:25 PM</div>
                        </div>
                        <div class="message-actions">
                            <button class="message-action-btn" title="Répondre"><i class="bi bi-reply"></i></button>
                            <button class="message-action-btn" title="Transférer"><i class="bi bi-forward"></i></button>
                            <div class="dropdown d-inline">
                                <button class="message-action-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                <ul class="dropdown-menu dropdown-menu-start">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i> Marquer</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-clipboard me-2"></i> Copier</a></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Supprimer</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Zone de saisie -->
            <div class="chat-input">
                <div class="input-actions">
                    <button class="input-action" id="emojiButton">
                        <i class="bi bi-emoji-smile"></i>
                    </button>
                    <div class="dropdown">
                        <button class="input-action" id="attachmentButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-paperclip"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="attachmentButton">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-image me-2"></i> Image</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-pdf me-2"></i> Document</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-camera-video me-2"></i> Vidéo</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-mic me-2"></i> Audio</a></li>
                        </ul>
                    </div>
                </div>
                <input type="text" placeholder="Écrivez un message..." />
                <button class="send-btn">
                    <i class="bi bi-send"></i>
                </button>
                <button class="new-message-btn ms-2" title="Nouveau message">
                    <i class="bi bi-pencil-square"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Le bouton flottant a été supprimé et remplacé par un bouton dans l'interface -->

<!-- Interface de sélection de contact (initialement masquée) -->
<div id="contactSelectionInterface" class="d-none">
    <div class="chat-container shadow-sm">
        <!-- Sidebar des conversations avec barre de recherche -->
        <div class="chat-sidebar w-100">
            <div class="chat-header">
                <div class="chat-title">Nouvelle conversation</div>
                <div class="chat-actions">
                    <button class="btn btn-sm btn-outline-secondary rounded-circle" id="cancelNewChat">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            
            <div class="chat-search">
                <input type="text" id="contactSearch" placeholder="Entrer nom, email, groupe ou tag" />
            </div>
            
            <div id="contactResults" class="chat-list">
                <!-- Contact 1 -->
                <div class="chat-item contact-item" data-name="SOHEIR AMRI" data-initials="SA" data-color="primary" data-role="FORMATEUR PERMANENT" data-id="SOHEIR.AMRI">
                    <div class="chat-avatar bg-primary">SA</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">SOHEIR AMRI</div>
                        </div>
                        <div class="chat-last-message text-muted">(SOHEIR.AMRI) FORMATEUR PERMANENT</div>
                    </div>
                </div>
                
                <!-- Contact 2 -->
                <div class="chat-item contact-item" data-name="SKIOUI FATIMA-EZ-ZAHRAA" data-initials="SK" data-color="info" data-role="STAGIAIRE" data-id="2004061900236">
                    <div class="chat-avatar bg-info">SK</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">SKIOUI FATIMA-EZ-ZAHRAA (You)</div>
                        </div>
                        <div class="chat-last-message text-muted">(2004061900236) STAGIAIRE</div>
                    </div>
                </div>
                
                <!-- Contact 3 -->
                <div class="chat-item contact-item" data-name="HAMID FOUNAS" data-initials="HF" data-color="danger" data-role="FORMATEUR" data-id="HAMID.FOUNAS">
                    <div class="chat-avatar bg-danger">HF</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">HAMID FOUNAS</div>
                        </div>
                        <div class="chat-last-message text-muted">(HAMID.FOUNAS) FORMATEUR</div>
                    </div>
                </div>
                
                <!-- Contact 4 -->
                <div class="chat-item contact-item" data-name="SALIMI NIAMA" data-initials="SN" data-color="success" data-role="STAGIAIRE" data-id="2003041200271">
                    <div class="chat-avatar bg-success">SN</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">SALIMI NIAMA</div>
                        </div>
                        <div class="chat-last-message text-muted">(2003041200271) STAGIAIRE</div>
                    </div>
                </div>
                
                <!-- Contact 5 -->
                <div class="chat-item contact-item" data-name="BELLALA FATIMAZAHRA" data-initials="BF" data-color="warning" data-role="STAGIAIRE" data-id="2004061900236">
                    <div class="chat-avatar bg-warning">BF</div>
                    <div class="chat-info">
                        <div class="chat-name-time">
                            <div class="chat-name">BELLALA FATIMAZAHRA</div>
                        </div>
                        <div class="chat-last-message text-muted">(2004061900236) STAGIAIRE</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des conversations dans la liste
    const chatItems = document.querySelectorAll('.chat-item');
    
    chatItems.forEach(item => {
        item.addEventListener('click', function() {
            // Désactiver toutes les conversations
            chatItems.forEach(chat => chat.classList.remove('active'));
            
            // Activer la conversation cliquée
            this.classList.add('active');
            
            // Vérifier si c'est une conversation de groupe
            // Pour cette démo, on considère que la conversation avec Mama K est un groupe
            const isGroupChat = this.querySelector('.chat-name').textContent === 'Mama K';
            
            // Afficher ou masquer l'option Leave selon le type de conversation
            const leaveOption = document.querySelector('.group-chat-option');
            if (leaveOption) {
                if (isGroupChat) {
                    leaveOption.classList.remove('d-none');
                } else {
                    leaveOption.classList.add('d-none');
                }
            }
            
            // Ici, on pourrait charger les messages de la conversation sélectionnée via AJAX
            // Pour l'instant, on ne fait rien d'autre que changer l'état visuel
        });
    });
    
    // Variables globales pour l'interface de chat
    const mainChatInterface = document.querySelector('.chat-container:not(#contactSelectionInterface .chat-container)');
    const contactSelectionInterface = document.getElementById('contactSelectionInterface');
    const chatMain = document.querySelector('.chat-main');
    const chatHeader = chatMain.querySelector('.chat-header');
    
    // Gestion du bouton de nouveau message
    const newMessageBtn = document.querySelector('.new-message-btn');
    if (newMessageBtn) {
        newMessageBtn.addEventListener('click', function() {
            // Masquer l'interface principale et afficher l'interface de sélection
            mainChatInterface.style.display = 'none';
            contactSelectionInterface.classList.remove('d-none');
            
            // Focus sur la barre de recherche de contacts
            const contactSearchInput = document.getElementById('contactSearch');
            if (contactSearchInput) {
                contactSearchInput.focus();
            }
        });
    }
    
    // Gestion du bouton d'annulation de nouveau chat
    const cancelNewChatBtn = document.getElementById('cancelNewChat');
    if (cancelNewChatBtn) {
        cancelNewChatBtn.addEventListener('click', function() {
            // Revenir à l'interface principale
            contactSelectionInterface.classList.add('d-none');
            mainChatInterface.style.display = 'flex';
        });
    }
    
    // Gestion de la recherche de contacts
    const contactSearch = document.getElementById('contactSearch');
    const contactItems = document.querySelectorAll('.contact-item');
    
    if (contactSearch) {
        contactSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            contactItems.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                const role = item.getAttribute('data-role').toLowerCase();
                const id = item.getAttribute('data-id').toLowerCase();
                
                if (name.includes(searchTerm) || role.includes(searchTerm) || id.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
    
    // Sélection d'un contact pour démarrer une conversation
    contactItems.forEach(item => {
        item.addEventListener('click', function() {
            // Récupérer les informations du contact
            const name = this.getAttribute('data-name');
            const initials = this.getAttribute('data-initials');
            const color = this.getAttribute('data-color');
            
            // Mettre à jour l'en-tête du chat avec les informations du contact
            updateChatHeader(name, initials, color);
            
            // Vider la zone de messages
            const chatMessages = document.querySelector('.chat-messages');
            chatMessages.innerHTML = '<div class="text-center text-muted small mb-4">Aujourd\'hui</div>';
            
            // Revenir à l'interface principale
            contactSelectionInterface.classList.add('d-none');
            mainChatInterface.style.display = 'flex';
            
            // Mettre le focus sur le champ de saisie
            const chatInput = document.querySelector('.chat-input input');
            if (chatInput) {
                chatInput.focus();
            }
        });
    });
    
    // Fonction pour mettre à jour l'en-tête du chat
    function updateChatHeader(name, initials, color) {
        const headerContent = `
            <div class="d-flex align-items-center">
                <div class="chat-avatar bg-${color} me-2">${initials}</div>
                <div>
                    <div class="chat-title">${name}</div>
                </div>
            </div>
            <div class="chat-actions">
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary rounded-circle" id="chatMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatMenuButton">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-check2-circle me-2"></i> Mark as unread</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-pin-angle me-2"></i> Pin</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-bell-slash me-2"></i> Mute</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item d-none group-chat-option" href="#"><i class="bi bi-box-arrow-right me-2"></i> Leave</a></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
        `;
        
        chatHeader.innerHTML = headerContent;
    }
    
    // Fonction pour faire défiler automatiquement vers le bas de la conversation
    function scrollToBottom() {
        const chatMessages = document.querySelector('.chat-messages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }
    
    // Faire défiler vers le bas au chargement
    scrollToBottom();
    
    // Gestion de l'envoi de message
    const chatInput = document.querySelector('.chat-input input');
    const sendButton = document.querySelector('.chat-input .send-btn');
    
    function sendMessage() {
        if (chatInput && chatInput.value.trim() !== '') {
            // Ici, on simulerait l'envoi du message au serveur
            // Pour l'instant, on ajoute juste visuellement le message
            const messageText = chatInput.value.trim();
            const now = new Date();
            const timeString = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
            
            const messageHTML = `
                <div class="message sent">
                    <div class="message-content">
                        <div class="message-bubble">
                            <div>${messageText}</div>
                            <div class="message-time">${timeString}</div>
                        </div>
                        <div class="message-actions">
                            <button class="message-action-btn" title="Répondre"><i class="bi bi-reply"></i></button>
                            <button class="message-action-btn" title="Transférer"><i class="bi bi-forward"></i></button>
                            <div class="dropdown d-inline">
                                <button class="message-action-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                <ul class="dropdown-menu dropdown-menu-start">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i> Marquer</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-clipboard me-2"></i> Copier</a></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Supprimer</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            const chatMessages = document.querySelector('.chat-messages');
            if (chatMessages) {
                chatMessages.insertAdjacentHTML('beforeend', messageHTML);
                chatInput.value = '';
                scrollToBottom();
                
                // Add event listeners to the new message action buttons
                const newMessage = chatMessages.lastElementChild;
                const actionBtns = newMessage.querySelectorAll('.message-action-btn');
                
                actionBtns.forEach(btn => {
                    if (btn.title === 'Répondre') {
                        btn.addEventListener('click', function() {
                            const msgText = this.closest('.message-content').querySelector('.message-bubble div:first-child').textContent;
                            const sender = 'You'; // Since this is a sent message
                            
                            if (chatInput) {
                                chatInput.value = `Replying to ${sender}: "${msgText.substring(0, 20)}${msgText.length > 20 ? '...' : ''}" \n`;
                                chatInput.focus();
                            }
                        });
                    } else if (btn.title === 'Transférer') {
                        btn.addEventListener('click', function() {
                            alert('Fonctionnalité de transfert à implémenter');
                        });
                    }
                });
            }
        }
    }
    
    if (sendButton) {
        sendButton.addEventListener('click', sendMessage);
    }
    
    if (chatInput) {
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    }
    
    // Gestion des options du menu déroulant
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.textContent.trim();
            console.log(`Action sélectionnée: ${action}`);
            // Ici, on pourrait implémenter les actions correspondantes
        });
    });
});
    // Fonction pour marquer tous les messages comme lus
    const markAllAsReadBtn = document.getElementById('markAllAsRead');
    if (markAllAsReadBtn) {
        markAllAsReadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const unreadChats = document.querySelectorAll('.chat-unread');
            unreadChats.forEach(chat => {
                chat.classList.remove('chat-unread');
            });
            
            // Afficher une notification de confirmation
            const notification = document.createElement('div');
            notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.innerHTML = `
                Tous les messages ont été marqués comme lus
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(notification);
            
            // Supprimer la notification après 3 secondes
            setTimeout(() => {
                notification.remove();
            }, 3000);
        });
    }
    
    // Gestion des pièces jointes
    const attachmentDropdownItems = document.querySelectorAll('#attachmentButton + .dropdown-menu .dropdown-item');
    attachmentDropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const attachmentType = this.textContent.trim();
            
            // Simuler un clic sur l'input de fichier approprié
            // Dans une implémentation réelle, on aurait des inputs de type file cachés
            alert(`Sélection de pièce jointe: ${attachmentType}`);
            
            // Exemple de message avec pièce jointe (à implémenter)
            if (attachmentType.includes('Image')) {
                const now = new Date();
                const timeString = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
                
                const attachmentHTML = `
                    <div class="message sent">
                        <div class="message-content">
                            <div class="message-bubble">
                                <div class="attachment-preview mb-2">
                                    <img src="https://via.placeholder.com/300x200" class="img-fluid rounded" alt="Image attachment">
                                </div>
                                <div class="message-time">${timeString}</div>
                            </div>
                            <div class="message-actions">
                                <button class="message-action-btn" title="Répondre"><i class="bi bi-reply"></i></button>
                                <button class="message-action-btn" title="Transférer"><i class="bi bi-forward"></i></button>
                                <div class="dropdown d-inline">
                                    <button class="message-action-btn" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-start">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i> Marquer</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download me-2"></i> Télécharger</a></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i> Supprimer</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                const chatMessages = document.querySelector('.chat-messages');
                if (chatMessages) {
                    chatMessages.insertAdjacentHTML('beforeend', attachmentHTML);
                    scrollToBottom();
                }
            }
        });
    });
    
    // Emoji picker functionality
    const emojiButton = document.getElementById('emojiButton');
    if (emojiButton) {
        emojiButton.addEventListener('click', function() {
            // Simple emoji picker for demonstration
            const emojis = ['😀', '😂', '😊', '😍', '🤔', '😎', '👍', '❤️', '🎉', '🔥'];
            
            // Check if emoji picker already exists
            let emojiPicker = document.querySelector('.emoji-picker');
            
            if (emojiPicker) {
                // Toggle visibility if it exists
                emojiPicker.remove();
                return;
            }
            
            // Create emoji picker using the CSS classes we defined
            emojiPicker = document.createElement('div');
            emojiPicker.className = 'emoji-picker';
            
            emojis.forEach(emoji => {
                const emojiBtn = document.createElement('button');
                emojiBtn.className = 'emoji-btn';
                emojiBtn.textContent = emoji;
                
                emojiBtn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Empêche la propagation du clic
                    
                    // Insert emoji into input field
                    if (chatInput) {
                        const cursorPos = chatInput.selectionStart;
                        const textBefore = chatInput.value.substring(0, cursorPos);
                        const textAfter = chatInput.value.substring(cursorPos);
                        chatInput.value = textBefore + emoji + textAfter;
                        chatInput.focus();
                        chatInput.selectionStart = cursorPos + emoji.length;
                        chatInput.selectionEnd = cursorPos + emoji.length;
                    }
                });
                
                emojiPicker.appendChild(emojiBtn);
            });
            
            // Add to DOM
            const chatInputContainer = document.querySelector('.chat-input');
            chatInputContainer.appendChild(emojiPicker);
            
            // Fermer le sélecteur d'emoji quand on clique ailleurs
            document.addEventListener('click', function closeEmojiPicker(e) {
                if (!emojiPicker.contains(e.target) && e.target !== emojiButton) {
                    emojiPicker.remove();
                    document.removeEventListener('click', closeEmojiPicker);
                }
            });
        });
    }
    
    // Message action buttons functionality
    const messageActionBtns = document.querySelectorAll('.message-action-btn');
    messageActionBtns.forEach(btn => {
        if (btn.title === 'Répondre') {
            btn.addEventListener('click', function() {
                const messageText = this.closest('.message-content').querySelector('.message-bubble div:first-child').textContent;
                const sender = this.closest('.message').classList.contains('sent') ? 'You' : 'Nana';
                
                // Focus input and add reply prefix
                if (chatInput) {
                    chatInput.value = `Replying to ${sender}: "${messageText.substring(0, 20)}${messageText.length > 20 ? '...' : ''}" \n`;
                    chatInput.focus();
                }
            });
        } else if (btn.title === 'Transférer') {
            btn.addEventListener('click', function() {
                alert('Fonctionnalité de transfert à implémenter');
                // Ici, on pourrait ouvrir une interface de sélection de destinataire
            });
        }
    });
</script>
@endsection
