@extends('layouts.admin')

@section('title', 'Gestion des plaintes')

@section('page_title', 'Gestion des plaintes')

@section('content')
<div class="container-fluid px-0" style="max-width: 95%; width: 95%; padding: 0 20px;">
    <style>
        /* Styles pour optimiser la visibilitu00e9 du tableau */
        .container-fluid {
            padding-left: 20px !important;
            padding-right: 20px !important;
            max-width: 95% !important;
            margin-left: auto !important;
            margin-right: auto !important;
            width: 95% !important;
        }
        
        .card {
            border-radius: 8px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            width: 100% !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 2rem !important;
        }
        
        .card-header {
            padding: 1.2rem 2rem !important;
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #e3e6f0 !important;
        }
        
        .card-header h6 {
            font-size: 1.2rem !important;
            font-weight: 600 !important;
        }
        
        .card-body {
            padding: 2rem !important;
        }
        
        .table-responsive {
            width: 100% !important;
            overflow-x: auto !important;
        }
        
        .table th, .table td {
            white-space: nowrap !important;
            padding: 12px 15px !important;
        }
    </style>
    <div class="card shadow mb-4" style="width: 100%; max-width: 100%; margin: 2rem 0;">
        <div class="card-header" style="padding: 1.2rem 2rem; background-color: #f8f9fa; border-bottom: 1px solid #e3e6f0;">
            <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem;">Liste des plaintes</h6>
        </div>
        <div class="card-body" style="padding: 1.5rem !important;">
            <div class="table-container" style="width: 100%; overflow-x: auto;">
                <table class="table table-hover" style="width: 100%; max-width: none; table-layout: fixed; border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 20%;">Utilisateur</th>
                            <th style="width: 30%;">Sujet</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Statut</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($complaints) > 0)
                            @foreach($complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->id }}</td>
                                    <td>{{ $complaint->email }}</td>
                                    <td>{{ $complaint->sujet }}</td>
                                    <td>{{ \Carbon\Carbon::parse($complaint->date_creation)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($complaint->statut == 'en_attente')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @elseif($complaint->statut == 'en_cours')
                                            <span class="badge bg-info">En cours</span>
                                        @elseif($complaint->statut == 'traité')
                                            <span class="badge bg-success">Traité</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $complaint->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if($complaint->statut != 'traité')
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#responseModal{{ $complaint->id }}">
                                                <i class="fas fa-reply"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Modal pour voir la plainte -->
                                <div class="modal fade" id="viewModal{{ $complaint->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel">Détails de la plainte</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <h6>Utilisateur</h6>
                                                    <p>{{ $complaint->email }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <h6>Sujet</h6>
                                                    <p>{{ $complaint->sujet }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <h6>Message</h6>
                                                    <p>{{ $complaint->message }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <h6>Date de création</h6>
                                                    <p>{{ \Carbon\Carbon::parse($complaint->date_creation)->format('d/m/Y H:i') }}</p>
                                                </div>
                                                @if(isset($complaint->reponse) && $complaint->statut == 'traité')
                                                    <div class="mb-3">
                                                        <h6>Réponse</h6>
                                                        <p>{{ $complaint->reponse }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <h6>Date de traitement</h6>
                                                        <p>{{ \Carbon\Carbon::parse($complaint->date_traitement)->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal pour répondre à la plainte -->
                                @if($complaint->statut != 'traité')
                                    <div class="modal fade" id="responseModal{{ $complaint->id }}" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responseModalLabel">Répondre à la plainte</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.complaints.respond', $complaint->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h6>Sujet</h6>
                                                            <p>{{ $complaint->sujet }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Message</h6>
                                                            <p>{{ $complaint->message }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="response" class="form-label">Votre réponse</label>
                                                            <textarea class="form-control" id="response" name="response" rows="5" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">Envoyer la réponse</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Aucune plainte à traiter</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
