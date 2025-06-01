@extends('layouts.admin')

@section('title', 'Gestion des messages')

@section('page_title', 'Gestion des messages')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                <i class="fas fa-envelope"></i> Nouveau message
            </button>
        </div>
        <div class="card-body">
            <!-- Onglets -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="inbox-tab" data-bs-toggle="tab" data-bs-target="#inbox" type="button" role="tab" aria-controls="inbox" aria-selected="true">Boîte de réception</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent" type="button" role="tab" aria-controls="sent" aria-selected="false">Messages envoyés</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Boîte de réception -->
                <div class="tab-pane fade show active" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Expéditeur</th>
                                    <th>Sujet</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($messages_received) && count($messages_received) > 0)
                                    @foreach($messages_received as $message)
                                        <tr>
                                            <td>{{ $message->expediteur_email ?? 'Inconnu' }}</td>
                                            <td>{{ $message->contenu ? substr($message->contenu, 0, 30).'...' : 'Sans contenu' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($message->date_envoi)->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $message->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal{{ $message->id }}">
                                                    <i class="fas fa-reply"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal pour voir le message -->
                                        <div class="modal fade" id="viewModal{{ $message->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel">Message de {{ $message->expediteur_email ?? 'Inconnu' }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h6>Sujet</h6>
                                                            <p>{{ $message->contenu ? substr($message->contenu, 0, 30).'...' : 'Sans contenu' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Message</h6>
                                                            <p>{{ $message->contenu }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Date d'envoi</h6>
                                                            <p>{{ \Carbon\Carbon::parse($message->date_envoi)->format('d/m/Y H:i') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Modal pour répondre au message -->
                                        <div class="modal fade" id="replyModal{{ $message->id }}" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="replyModalLabel">Répondre à {{ $message->expediteur_email ?? 'Inconnu' }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="sujet" class="form-label">Sujet</label>
                                                                <input type="text" class="form-control" id="sujet" name="sujet" value="Re: {{ $message->contenu ? substr($message->contenu, 0, 30).'...' : 'Sans contenu' }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="contenu" class="form-label">Message</label>
                                                                <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">Envoyer</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">Aucun message reçu</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Messages envoyés -->
                <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab">
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Destinataire</th>
                                    <th>Sujet</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($messages_sent) && count($messages_sent) > 0)
                                    @foreach($messages_sent as $message)
                                        <tr>
                                            <td>{{ $message->destinataire_email }}</td>
                                            <td>{{ $message->contenu ? substr($message->contenu, 0, 30).'...' : 'Sans contenu' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($message->date_envoi)->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewSentModal{{ $message->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal pour voir le message envoyé -->
                                        <div class="modal fade" id="viewSentModal{{ $message->id }}" tabindex="-1" aria-labelledby="viewSentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewSentModalLabel">Message à {{ $message->destinataire_email }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h6>Sujet</h6>
                                                            <p>{{ $message->contenu ? substr($message->contenu, 0, 30).'...' : 'Sans contenu' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Message</h6>
                                                            <p>{{ $message->contenu }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Date d'envoi</h6>
                                                            <p>{{ \Carbon\Carbon::parse($message->date_envoi)->format('d/m/Y H:i') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">Aucun message envoyé</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour envoyer un nouveau message -->
<div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="newMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMessageModalLabel">Nouveau message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.messages.send') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="destinataire" class="form-label">Destinataire</label>
                        <select class="form-select" id="destinataire" name="destinataire" required>
                            <option value="">Sélectionner un destinataire</option>
                            @if(isset($users) && count($users) > 0)
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sujet" class="form-label">Sujet</label>
                        <input type="text" class="form-control" id="sujet" name="sujet" required>
                    </div>
                    <div class="mb-3">
                        <label for="contenu" class="form-label">Message</label>
                        <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
