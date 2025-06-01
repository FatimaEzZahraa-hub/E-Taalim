@extends('layouts.admin')

@section('title', 'Consultation du cours')

@section('page_title', 'Consultation du cours')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du cours</h6>
                    <div>
                        <a href="{{ route('admin.courses.pending') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-check"></i> Approuver
                            </button>
                        </form>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times"></i> Rejeter
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Titre:</strong> {{ $course->titre }}</p>
                            <p><strong>Enseignant:</strong> {{ $course->prenom_enseignant }} {{ $course->nom_enseignant }}</p>
                            <p><strong>Date de création:</strong> {{ \Carbon\Carbon::parse($course->date_creation)->format('d/m/Y') }}</p>
                            <p><strong>Statut:</strong> <span class="badge bg-warning text-dark">En attente</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Description:</strong></p>
                            <p>{{ $course->description }}</p>
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
                    <h6 class="m-0 font-weight-bold text-primary">Contenu du cours</h6>
                </div>
                <div class="card-body">
                    <div class="course-content">
                        {!! $course->contenu !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Documents associés</h6>
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
                                @foreach($course->documents as $document)
                                <tr>
                                    <td>{{ $document->nom }}</td>
                                    <td>{{ strtoupper($document->type) }}</td>
                                    <td>{{ $document->taille }}</td>
                                    <td>{{ \Carbon\Carbon::parse($document->date_upload)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">
                                            <i class="fas fa-download"></i> Télécharger
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
</div>

<!-- Modal pour rejeter le cours -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Rejeter le cours</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Raison du rejet</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .course-content {
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    
    .course-content h2 {
        color: var(--primary-color);
        margin-top: 30px;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .course-content p {
        line-height: 1.6;
        margin-bottom: 20px;
    }
</style>
@endsection
