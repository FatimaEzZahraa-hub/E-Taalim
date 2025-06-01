@extends('layouts.admin')

@section('title', 'Conversation')

@section('page_title', 'Messagerie - Conversation')

@section('content')
<div class="container-fluid messaging-container">
    <div class="row">
        <!-- Liste des conversations -->
        <div class="col-md-3 conversation-list">
            <div class="search-box mb-3">
                <input type="text" class="form-control" placeholder="Rechercher...">
            </div>
            <div class="conversations">
                @foreach($conversations as $conv)
                <div class="conversation-item @if($conversation->id == $conv->id) active @endif" 
                     onclick="window.location.href='{{ route("admin.messaging.conversation", $conv->id) }}'">
                    <div class="avatar">
                        @if($conv->type == 'group')
                        <div class="group-avatar">{{ substr($conv->name, 0, 1) }}</div>
                        @else
                        <div class="user-avatar">{{ substr($conv->participant->nom, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="conversation-info">
                        <div class="conversation-name">
                            @if($conv->type == 'group')
                                {{ $conv->name }}
                            @else
                                {{ $conv->participant->nom }} {{ $conv->participant->prenom }}
                            @endif
                        </div>
                        <div class="last-message">{{ $conv->lastMessage ? Str::limit($conv->lastMessage->contenu, 30) : 'Aucun message' }}</div>
                    </div>
                    <div class="conversation-meta">
                        <div class="time">{{ $conv->lastMessage ? $conv->lastMessage->created_at->format('H:i') : '' }}</div>
                        @if($conv->unreadCount > 0)
                        <div class="unread-count">{{ $conv->unreadCount }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Zone de chat -->
        <div class="col-md-9 chat-area">
            <div class="chat-header">
                <div class="chat-title">
                    @if($conversation->type == 'group')
                        {{ $conversation->name }}
                    @else
                        {{ $conversation->participant->nom }} {{ $conversation->participant->prenom }}
                    @endif
                </div>
                <div class="chat-actions">
                    <button class="btn btn-sm"><i class="fas fa-phone"></i></button>
                    <button class="btn btn-sm"><i class="fas fa-video"></i></button>
                    <button class="btn btn-sm"><i class="fas fa-info-circle"></i></button>
                </div>
            </div>
            
            <div class="chat-messages" id="chat-messages">
                <div class="chat-date">{{ now()->format('d/m/Y') }}</div>
                
                @foreach($messages as $message)
                <div class="message @if($message->sender_id == auth()->id()) outgoing @else incoming @endif">
                    @if($message->sender_id != auth()->id())
                    <div class="message-avatar">
                        {{ substr($message->sender->nom, 0, 1) }}
                    </div>
                    @endif
                    <div class="message-content">
                        <div class="message-text">{{ $message->contenu }}</div>
                        <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="chat-input">
                <form action="{{ route('admin.messaging.send') }}" method="POST" id="message-form">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="input-group">
                        <button type="button" class="btn btn-attachment"><i class="fas fa-paperclip"></i></button>
                        <input type="text" name="message" class="form-control" placeholder="Tapez un message..." required>
                        <button type="submit" class="btn btn-send"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .messaging-container {
        height: calc(100vh - 150px);
        overflow: hidden;
    }
    
    .conversation-list {
        background-color: #f8f9fa;
        border-right: 1px solid #e9ecef;
        height: 100%;
        overflow-y: auto;
    }
    
    .search-box {
        padding: 15px;
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 10;
    }
    
    .conversation-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .conversation-item:hover, .conversation-item.active {
        background-color: #e9ecef;
    }
    
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
    
    .user-avatar {
        background-color: #8668FF;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .group-avatar {
        background-color: #FF6868;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .conversation-info {
        flex: 1;
    }
    
    .conversation-name {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .last-message {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .conversation-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }
    
    .time {
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .unread-count {
        background-color: #8668FF;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }
    
    .chat-area {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .chat-header {
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .chat-title {
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .chat-actions button {
        margin-left: 10px;
        background-color: #f8f9fa;
        border: none;
    }
    
    .chat-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }
    
    .chat-date {
        text-align: center;
        margin: 15px 0;
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .message {
        display: flex;
        margin-bottom: 15px;
        max-width: 70%;
    }
    
    .message.incoming {
        align-self: flex-start;
    }
    
    .message.outgoing {
        align-self: flex-end;
        flex-direction: row-reverse;
    }
    
    .message-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #8668FF;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        margin-right: 10px;
    }
    
    .message.outgoing .message-content {
        background-color: #8668FF;
        color: white;
        border-radius: 18px 18px 0 18px;
    }
    
    .message.incoming .message-content {
        background-color: #f1f0f0;
        border-radius: 18px 18px 18px 0;
    }
    
    .message-content {
        padding: 10px 15px;
        position: relative;
    }
    
    .message-text {
        margin-bottom: 5px;
    }
    
    .message-time {
        font-size: 0.7rem;
        opacity: 0.7;
        text-align: right;
    }
    
    .chat-input {
        padding: 15px;
        border-top: 1px solid #e9ecef;
    }
    
    .btn-attachment {
        background-color: transparent;
        border: none;
        color: #6c757d;
    }
    
    .btn-send {
        background-color: #8668FF;
        color: white;
        border: none;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Faire du00e9filer jusqu'au dernier message
        const chatMessages = document.getElementById('chat-messages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Soumettre le formulaire en appuyant sur Entru00e9e
        const messageForm = document.getElementById('message-form');
        const messageInput = messageForm ? messageForm.querySelector('input[name="message"]') : null;
        
        if (messageInput) {
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    messageForm.submit();
                }
            });
        }
    });
</script>
@endsection
