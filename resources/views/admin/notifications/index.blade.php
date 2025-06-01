@extends('layouts.admin')

@section('title', 'Gestion des notifications')

@section('page_title', 'Gestion des notifications')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Notifications</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newNotificationModal">
                <i class="fas fa-bell"></i> Nouvelle notification
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Titre</th>
                            <th>Date de création</th>
                            <th>Date d'expiration</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($notifications) && count($notifications) > 0)
                            @foreach($notifications as $notification)
                                <tr>
                                    <td>
                                        @if($notification->type == 'maintenance')
                                            <span class="badge bg-warning text-dark">Maintenance</span>
                                        @elseif($notification->type == 'information')
                                            <span class="badge bg-info">Information</span>
                                        @elseif($notification->type == 'evenement')
                                            <span class="badge bg-primary">Événement</span>
                                        @else
                                            <span class="badge bg-secondary">Autre</span>
                                        @endif
                                    </td>
                                    <td>{{ $notification->titre }}</td>
                                    <td>{{ \Carbon\Carbon::parse($notification->date_creation)->format('d/m/Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($notification->date_expiration)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($notification->est_lu)
                                            <span class="badge bg-success">Lue</span>
                                        @else
                                            <span class="badge bg-danger">Non lue</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $notification->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $notification->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $notification->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Modal pour voir la notification -->
                                <div class="modal fade" id="viewModal{{ $notification->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel">{{ $notification->titre }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <h6>Type</h6>
                                                    <p>
                                                        @if($notification->type == 'maintenance')
                                                            <span class="badge bg-warning text-dark">Maintenance</span>
                                                        @elseif($notification->type == 'information')
                                                            <span class="badge bg-info">Information</span>
                                                        @elseif($notification->type == 'evenement')
                                                            <span class="badge bg-primary">Événement</span>
                                                        @else
                                                            <span class="badge bg-secondary">Autre</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <h6>Contenu</h6>
                                                    <p>{{ $notification->contenu }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <h6>Date de création</h6>
                                                    <p>{{ \Carbon\Carbon::parse($notification->date_creation)->format('d/m/Y H:i') }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <h6>Date d'expiration</h6>
                                                    <p>{{ \Carbon\Carbon::parse($notification->date_expiration)->format('d/m/Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.notification.mark-as-read', $notification->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Marquer comme lu</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modal pour modifier la notification -->
                                <div class="modal fade" id="editModal{{ $notification->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Modifier la notification</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.notifications.update', $notification->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="type" class="form-label">Type</label>
                                                        <select class="form-select" id="type" name="type" required>
                                                            <option value="maintenance" {{ $notification->type == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                            <option value="information" {{ $notification->type == 'information' ? 'selected' : '' }}>Information</option>
                                                            <option value="evenement" {{ $notification->type == 'evenement' ? 'selected' : '' }}>Événement</option>
                                                            <option value="autre" {{ $notification->type == 'autre' ? 'selected' : '' }}>Autre</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="titre" class="form-label">Titre</label>
                                                        <input type="text" class="form-control" id="titre" name="titre" value="{{ $notification->titre }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="contenu" class="form-label">Contenu</label>
                                                        <textarea class="form-control" id="contenu" name="contenu" rows="5" required>{{ $notification->contenu }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="date_expiration" class="form-label">Date d'expiration</label>
                                                        <input type="date" class="form-control" id="date_expiration" name="date_expiration" value="{{ \Carbon\Carbon::parse($notification->date_expiration)->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modal pour supprimer la notification -->
                                <div class="modal fade" id="deleteModal{{ $notification->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Êtes-vous sûr de vouloir supprimer cette notification ?</p>
                                                <p><strong>{{ $notification->titre }}</strong></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('admin.notifications.delete', $notification->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Aucune notification</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour créer une nouvelle notification -->
<div class="modal fade" id="newNotificationModal" tabindex="-1" aria-labelledby="newNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newNotificationModalLabel">Nouvelle notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.notifications.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="maintenance">Maintenance</option>
                            <option value="information">Information</option>
                            <option value="evenement">Événement</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="mb-3">
                        <label for="contenu" class="form-label">Contenu</label>
                        <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date_expiration" class="form-label">Date d'expiration</label>
                        <input type="date" class="form-control" id="date_expiration" name="date_expiration" value="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
