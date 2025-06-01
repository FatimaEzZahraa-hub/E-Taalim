@extends('layouts.app')

@section('title', 'Chat')

@section('styles')
<style>
    .teams-container {
        display: flex;
        height: calc(100vh - 80px);
        background-color: #f5f5f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .teams-sidebar {
        width: 75px;
        background-color: #f3f2f1;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-right: 1px solid #e1dfdd;
    }
    
    .sidebar-icon {
        width: 100%;
        height: 50px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #616161;
        font-size: 12px;
        cursor: pointer;
        margin: 5px 0;
        position: relative;
    }
    
    .sidebar-icon.active {
        color: #6264A7;
        border-left: 2px solid #6264A7;
    }
    
    .sidebar-icon.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 2px;
        background-color: #6264A7;
    }
    
    .sidebar-icon i {
        font-size: 20px;
        margin-bottom: 4px;
    }
    
    .chat-list {
        width: 350px;
        background-color: #fff;
        border-right: 1px solid #e1dfdd;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .chat-list-header {
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .chat-list-title {
        font-size: 18px;
        font-weight: 600;
        color: #252423;
    }
    
    .header-actions {
        display: flex;
        gap: 10px;
    }
    
    .header-actions button {
        background: none;
        border: none;
        font-size: 16px;
        color: #616161;
        cursor: pointer;
    }
    
    .chat-section {
        margin-bottom: 20px;
    }
    
    .section-header {
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #616161;
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    
    .section-header i {
        margin-right: 8px;
        transition: transform 0.2s;
    }
    
    .section-header.collapsed i {
        transform: rotate(-90deg);
    }
    
    .chat-items {
        overflow-y: auto;
    }
    
    .chat-item {
        padding: 8px 16px;
        display: flex;
        align-items: center;
        cursor: pointer;
        border-left: 3px solid transparent;
    }
    
    .chat-item:hover {
        background-color: #f5f5f5;
    }
    
    .chat-item.active {
        background-color: #f0f0f0;
        border-left: 3px solid #6264A7;
    }
    
    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 500;
        flex-shrink: 0;
    }
    
    .avatar.purple {
        background-color: #8668FF;
    }
    
    .avatar.green {
        background-color: #92C353;
    }
    
    .avatar.blue {
        background-color: #2D8CFF;
    }
    
    .avatar.red {
        background-color: #E74C3C;
    }
    
    .avatar.orange {
        background-color: #F39C12;
    }
    
    .chat-item-content {
        flex: 1;
        overflow: hidden;
    }
    
    .chat-item-name {
        font-size: 14px;
        font-weight: 500;
        color: #252423;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .chat-item-preview {
        font-size: 12px;
        color: #616161;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .chat-item-meta {
        font-size: 11px;
        color: #616161;
        text-align: right;
        white-space: nowrap;
        margin-left: 8px;
    }
    
    .chat-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: #f5f5f5;
    }
    
    .chat-header {
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fff;
        border-bottom: 1px solid #e1dfdd;
    }
    
    .chat-header-left {
        display: flex;
        align-items: center;
    }
    
    .chat-header-title {
        font-size: 16px;
        font-weight: 600;
        color: #252423;
    }
    
    .chat-header-tabs {
        display: flex;
        margin-left: 24px;
    }
    
    .chat-tab {
        padding: 8px 16px;
        font-size: 14px;
        color: #616161;
        cursor: pointer;
        border-bottom: 2px solid transparent;
    }
    
    .chat-tab.active {
        color: #6264A7;
        border-bottom: 2px solid #6264A7;
    }
    
    .chat-header-actions {
        display: flex;
        gap: 16px;
    }
    
    .chat-header-actions button {
        background: none;
        border: none;
        color: #616161;
        font-size: 16px;
        cursor: pointer;
    }
    
    .chat-messages {
        flex: 1;
        padding: 16px;
        overflow-y: auto;
    }
    
    .message {
        display: flex;
        margin-bottom: 16px;
    }
    
    .message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 500;
        flex-shrink: 0;
        background-color: #8668FF;
    }
    
    .message-content {
        max-width: 70%;
    }
    
    .message-bubble {
        padding: 8px 12px;
        background-color: white;
        border-radius: 4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    .message-time {
        font-size: 11px;
        color: #616161;
        margin-top: 4px;
    }
    
    .message-input-container {
        padding: 16px;
        background-color: #fff;
        border-top: 1px solid #e1dfdd;
    }
    
    .message-input-form {
        display: flex;
        align-items: center;
        background-color: #f5f5f5;
        border-radius: 4px;
        padding: 8px 12px;
    }
    
    .message-input {
        flex: 1;
        border: none;
        background: none;
        outline: none;
        font-size: 14px;
        padding: 8px;
    }
    
    .input-actions {
        display: flex;
        gap: 12px;
    }
    
    .input-actions button {
        background: none;
        border: none;
        color: #616161;
        font-size: 16px;
        cursor: pointer;
    }
    
    .send-button {
        color: #6264A7;
    }
</style>
@endsection

@section('content')
<div class="teams-container">
    <!-- Barre latérale de navigation Teams -->
    <div class="teams-sidebar">
        <div class="sidebar-icon">
            <i class="bi bi-bell"></i>
            <span>Activity</span>
        </div>
        <div class="sidebar-icon active">
            <i class="bi bi-chat"></i>
            <span>Chat</span>
        </div>
        <div class="sidebar-icon">
            <i class="bi bi-people"></i>
            <span>Teams</span>
        </div>
        <div class="sidebar-icon">
            <i class="bi bi-calendar"></i>
            <span>Calendar</span>
        </div>
        <div class="sidebar-icon">
            <i class="bi bi-telephone"></i>
            <span>Calls</span>
        </div>
        <div class="sidebar-icon">
            <i class="bi bi-cloud"></i>
            <span>OneDrive</span>
        </div>
    </div>
    
    <!-- Liste des conversations -->
    <div class="chat-list">
        <div class="chat-list-header">
            <div class="chat-list-title">Chat</div>
            <div class="header-actions">
                <button><i class="bi bi-three-dots"></i></button>
                <button><i class="bi bi-pencil-square"></i></button>
            </div>
        </div>
        
        <!-- Section épinglée -->
        <div class="chat-section">
            <div class="section-header">
                <i class="bi bi-chevron-down"></i>
                <span>Pinned</span>
            </div>
            <div class="chat-items">
                <div class="chat-item">
                    <div class="avatar purple">SK</div>
                    <div class="chat-item-content">
                        <div class="chat-item-name">SKIOUI FATIMA-EZ...</div>
                        <div class="chat-item-preview">You: ...</div>
                    </div>
                    <div class="chat-item-meta">12/25/2024</div>
                </div>
            </div>
        </div>
        
        <!-- Section récente -->
        <div class="chat-section">
            <div class="section-header">
                <i class="bi bi-chevron-down"></i>
                <span>Recent</span>
            </div>
            <div class="chat-items">
                <div class="chat-item">
                    <div class="avatar green">PG</div>
                    <div class="chat-item-content">
                        <div class="chat-item-name">Powerpuff girls</div>
                        <div class="chat-item-preview">Meeting ended</div>
                    </div>
                    <div class="chat-item-meta"></div>
                </div>
                
                <div class="chat-item">
                    <div class="avatar blue">BA</div>
                    <div class="chat-item-content">
                        <div class="chat-item-name">BAZYANE AMAL</div>
                        <div class="chat-item-preview">Création de la base CREATE ...</div>
                    </div>
                    <div class="chat-item-meta">4/24</div>
                </div>
                
                <div class="chat-item">
                    <div class="avatar orange">HE</div>
                    <div class="chat-item-content">
                        <div class="chat-item-name">HACHEM EL HARRAK H...</div>
                        <div class="chat-item-preview">You: Sent a file</div>
                    </div>
                    <div class="chat-item-meta">3/15</div>
                </div>
                
                <div class="chat-item active">
                    <div class="avatar red">RI</div>
                    <div class="chat-item-content">
                        <div class="chat-item-name">RABIA SABOUR EL IDRIS</div>
                        <div class="chat-item-preview">Oui, vous pouvez</div>
                    </div>
                    <div class="chat-item-meta">3/10</div>
                </div>
                
                <div class="chat-item">
                    <div class="avatar purple">SO</div>
                    <div class="chat-item-content">
                        <div class="chat-item-name">SOHEIR AMRI</div>
                        <div class="chat-item-preview">Meeting.</div>
                    </div>
                    <div class="chat-item-meta">3/1</div>
                </div>
                
                <div class="chat-item">
                    <div class="avatar green">BA</div>
                    <div class="chat-item-content">
                        <div class="chat-item-name">طيبها على الله</div>
                        <div class="chat-item-preview">BAZYANE AMAL: waayhh yamat zi...</div>
                    </div>
                    <div class="chat-item-meta">2/22</div>
                </div>
                
                <div class="chat-item">
                    <div class="avatar blue">R2</div>
                    <div class="chat-item-content">
                        <div class="chat-item-name">Room 2</div>
                        <div class="chat-item-preview">You: Fatima: Hey, Hajar, Fatima Ez ...</div>
                    </div>
                    <div class="chat-item-meta">2/4</div>
                </div>
                
                <div class="chat-item">
                    <div class="avatar orange">HF</div>
                    <div class="chat-item-content">
                        <div class="chat-item-name">HAMID FOUNAS</div>
                        <div class="chat-item-preview">You: Sent a file</div>
                    </div>
                    <div class="chat-item-meta">1/2</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Zone de conversation -->
    <div class="chat-content">
        <div class="chat-header">
            <div class="chat-header-left">
                <div class="chat-header-title">Chat</div>
                <div class="chat-header-tabs">
                    <div class="chat-tab active">Shared</div>
                    <div class="chat-tab"><i class="bi bi-plus"></i></div>
                </div>
            </div>
            <div class="chat-header-actions">
                <button><i class="bi bi-mic"></i></button>
                <button><i class="bi bi-people">3</i></button>
                <button><i class="bi bi-three-dots"></i></button>
            </div>
        </div>
        
        <div class="chat-messages" id="chat-messages">
            <!-- Message reçu -->
            <div class="message">
                <div class="message-avatar">RI</div>
                <div class="message-content">
                    <div class="message-bubble">habto</div>
                    <div class="message-time">8:07 PM</div>
                </div>
            </div>
            
            <!-- Message reçu -->
            <div class="message">
                <div class="message-avatar">RI</div>
                <div class="message-content">
                    <div class="message-bubble">o 3awdo tal3o</div>
                    <div class="message-time"></div>
                </div>
            </div>
        </div>
        
        <div class="message-input-container">
            <form id="chat-form" class="message-input-form">
                <input type="text" class="message-input" placeholder="Tapez un message..." id="message-input">
                <div class="input-actions">
                    <button type="button"><i class="bi bi-paperclip"></i></button>
                    <button type="button"><i class="bi bi-emoji-smile"></i></button>
                    <button type="button"><i class="bi bi-image"></i></button>
                    <button type="button"><i class="bi bi-three-dots"></i></button>
                    <button type="submit" class="send-button"><i class="bi bi-send"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const chatMessages = document.getElementById('chat-messages');
    
    // Fonction pour ajouter un message
    function addMessage(content, isSent) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message';
        
        // Si c'est un message envoyé, on change l'avatar
        const avatarDiv = document.createElement('div');
        avatarDiv.className = 'message-avatar';
        avatarDiv.textContent = isSent ? 'You' : 'RI';
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        
        const bubbleDiv = document.createElement('div');
        bubbleDiv.className = 'message-bubble';
        bubbleDiv.textContent = content;
        
        const timeDiv = document.createElement('div');
        timeDiv.className = 'message-time';
        
        // Obtenir l'heure actuelle
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        timeDiv.textContent = `${formattedHours}:${minutes} ${ampm}`;
        
        contentDiv.appendChild(bubbleDiv);
        contentDiv.appendChild(timeDiv);
        
        messageDiv.appendChild(avatarDiv);
        messageDiv.appendChild(contentDiv);
        
        chatMessages.appendChild(messageDiv);
        
        // Faire défiler vers le bas
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Gérer l'envoi du formulaire
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (message) {
            // Ajouter le message envoyé
            addMessage(message, true);
            
            // Réinitialiser l'entrée
            messageInput.value = '';
            
            // Simuler une réponse après 1 seconde
            setTimeout(() => {
                addMessage("D'accord", false);
            }, 1000);
        }
    });
    
    // Gestion des sections pliables
    const sectionHeaders = document.querySelectorAll('.section-header');
    sectionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            this.classList.toggle('collapsed');
            const items = this.nextElementSibling;
            items.style.display = this.classList.contains('collapsed') ? 'none' : 'block';
        });
    });
});
</script>
@endsection
