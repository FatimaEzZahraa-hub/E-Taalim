@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold mb-0">Messages</h1>
        <a href="{{ route('enseignant.messages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouveau message
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#inbox" data-bs-toggle="tab">Boîte de réception</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#sent" data-bs-toggle="tab">Messages envoyés</a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="inbox">
                    @if(count($messages->where('type', 'reçu')) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3" style="width: 40px"></th>
                                        <th>Expéditeur</th>
                                        <th>Sujet</th>
                                        <th>Date</th>
                                        <th class="text-end pe-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages->where('type', 'reçu') as $message)
                                        <tr class="{{ $message->lu ? '' : 'fw-bold' }}">
                                            <td class="ps-3">
                                                @if(!$message->lu)
                                                    <span class="badge bg-primary rounded-circle p-1">&nbsp;</span>
                                                @endif
                                            </td>
                                            <td>{{ $message->expediteur->prenom }} {{ $message->expediteur->nom }}</td>
                                            <td>{{ $message->sujet }}</td>
                                            <td>{{ $message->date_envoi->format('d/m/Y H:i') }}</td>
                                            <td class="text-end pe-3">
                                                <a href="{{ route('enseignant.messages.show', $message->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $message->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                
                                                <!-- Modal de confirmation de suppression -->
                                                <div class="modal fade" id="deleteModal{{ $message->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $message->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $message->id }}">Confirmer la suppression</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-start">
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
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-inbox.svg') }}" alt="Boîte de réception vide" class="img-fluid mb-3" style="max-width: 150px" onerror="this.src='{{ asset('images/logo-placeholder.jpg') }}'">
                            <h5 class="text-muted mb-3">Votre boîte de réception est vide</h5>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="sent">
                    @if(count($messages->where('type', 'envoyé')) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Destinataire</th>
                                        <th>Sujet</th>
                                        <th>Date</th>
                                        <th class="text-end pe-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages->where('type', 'envoyé') as $message)
                                        <tr>
                                            <td class="ps-3">{{ $message->destinataire->prenom }} {{ $message->destinataire->nom }}</td>
                                            <td>{{ $message->sujet }}</td>
                                            <td>{{ $message->date_envoi->format('d/m/Y H:i') }}</td>
                                            <td class="text-end pe-3">
                                                <a href="{{ route('enseignant.messages.show', $message->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $message->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                
                                                <!-- Modal de confirmation de suppression -->
                                                <div class="modal fade" id="deleteModal{{ $message->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $message->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $message->id }}">Confirmer la suppression</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-start">
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
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-sent.svg') }}" alt="Aucun message envoyé" class="img-fluid mb-3" style="max-width: 150px" onerror="this.src='{{ asset('images/logo-placeholder.jpg') }}'">
                            <h5 class="text-muted mb-3">Vous n'avez pas encore envoyé de messages</h5>
                            <a href="{{ route('enseignant.messages.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nouveau message
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
