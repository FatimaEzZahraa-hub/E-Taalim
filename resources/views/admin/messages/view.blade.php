@extends('layouts.admin')

@section('title', 'Consultation du message')

@section('page_title', 'Consultation du message')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du message</h6>
                    <div>
                        <a href="{{ route('admin.messages') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal">
                            <i class="fas fa-reply"></i> Ru00e9pondre
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>De:</strong> {{ $message->expediteur_prenom }} {{ $message->expediteur_nom }} ({{ $message->expediteur_email }})</p>
                            <p><strong>u00c0:</strong> {{ $message->destinataire_prenom }} {{ $message->destinataire_nom }} ({{ $message->destinataire_email }})</p>
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($message->date_envoi)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Sujet:</strong> {{ $message->sujet }}</p>
                            <p><strong>Statut:</strong> 
                                @if($message->lu)
                                    <span class="badge bg-success">Lu</span>
                                @else
                                    <span class="badge bg-warning text-dark">Non lu</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contenu du message</h6>
                </div>
                <div class="card-body">
                    <div class="message-content">
                        {!! $message->contenu !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($message->fichiers_joints) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Fichiers joints</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Taille</th>
                                    <th>Date d'ajout</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($message->fichiers_joints as $fichier)
                                <tr>
                                    <td>{{ $fichier->nom }}</td>
                                    <td>{{ strtoupper($fichier->type) }}</td>
                                    <td>{{ $fichier->taille }}</td>
                                    <td>{{ \Carbon\Carbon::parse($fichier->date_upload)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">
                                            <i class="fas fa-download"></i> Tu00e9lu00e9charger
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Visualiser
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal pour ru00e9pondre au message -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Ru00e9pondre au message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.messages.send') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="destinataire_id" value="{{ $message->expediteur_id }}">
                <input type="hidden" name="destinataire_email" value="{{ $message->expediteur_email }}">
                <input type="hidden" name="sujet" value="RE: {{ $message->sujet }}">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contenu" class="form-label">Votre ru00e9ponse</label>
                        <textarea class="form-control" id="contenu" name="contenu" rows="6" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fichier" class="form-label">Joindre un fichier (optionnel)</label>
                        <input class="form-control" type="file" id="fichier" name="fichier">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer la ru00e9ponse</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .message-content {
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        line-height: 1.6;
    }
    
    .message-content p {
        margin-bottom: 15px;
    }
</style>
@endsection
