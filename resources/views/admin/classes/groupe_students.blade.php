@extends('layouts.admin')

@section('title', 'Gestion des étudiants du groupe')

@section('styles')
<style>
    .card {
        border-radius: 8px !important;
        margin-bottom: 20px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }
    
    .card-header {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #e3e6f0 !important;
        padding: 1rem 1.5rem !important;
    }
    
    .student-card {
        transition: all 0.3s ease;
        border-left: 4px solid #4e73df;
    }
    
    .student-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1) !important;
    }
    
    .student-info {
        display: flex;
        align-items: center;
    }
    
    .student-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 1.5rem;
        color: #4e73df;
    }
    
    .student-details {
        flex-grow: 1;
    }
    
    .student-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .student-email {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .student-actions {
        display: flex;
        align-items: center;
    }
    
    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        line-height: 36px;
        text-align: center;
        border-radius: 50%;
        margin-left: 8px;
    }
    
    .date-affectation {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gestion des étudiants du groupe</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.classes.index') }}">Classes</a></li>
        <li class="breadcrumb-item active">Étudiants du groupe</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Groupe: <strong>{{ $groupe->nom }}</strong></h5>
                    <p class="text-muted mb-0">Niveau: {{ $groupe->niveau->nom }}</p>
                </div>
                <div>
                    <span class="badge bg-primary">{{ $groupe->etudiants->count() }} / {{ $groupe->capacite }} étudiants</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Ajouter des étudiants au groupe</h6>
                        </div>
                        <div class="card-body">
                            @if($etudiants_disponibles->isEmpty())
                                <div class="alert alert-info mb-0">
                                    Tous les étudiants sont déjà affectés à ce groupe ou aucun étudiant n'est disponible.
                                </div>
                            @else
                                <form action="{{ route('admin.classes.groupe.add-students', $groupe->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="etudiants" class="form-label">Sélectionner des étudiants</label>
                                        <select class="form-select" id="etudiants" name="etudiants[]" multiple size="10">
                                            @foreach($etudiants_disponibles as $etudiant)
                                                <option value="{{ $etudiant->id }}">{{ $etudiant->name }} ({{ $etudiant->email }})</option>
                                            @endforeach
                                        </select>
                                        <div class="form-text">Maintenez la touche Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs étudiants.</div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-user-plus"></i> Ajouter au groupe
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <h5 class="mb-3">u00c9tudiants du groupe</h5>
            
            @if($groupe->etudiants->isEmpty())
                <div class="alert alert-info">
                    Aucun u00e9tudiant n'est affectu00e9 u00e0 ce groupe pour le moment.
                </div>
            @else
                <div class="row">
                    @foreach($groupe->etudiants as $etudiant)
                        <div class="col-md-6 mb-3">
                            <div class="card student-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="student-info">
                                            <div class="student-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="student-details">
                                                <div class="student-name">{{ $etudiant->name }}</div>
                                                <div class="student-email">{{ $etudiant->email }}</div>
                                                <div class="date-affectation">
                                                    Affectu00e9 le: {{ \Carbon\Carbon::parse($etudiant->pivot->date_affectation)->format('d/m/Y') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="student-actions">
                                            <button type="button" class="btn btn-outline-danger btn-icon" data-bs-toggle="modal" data-bs-target="#removeStudentModal{{ $etudiant->id }}" title="Retirer du groupe">
                                                <i class="fas fa-user-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modal Retrait u00c9tudiant -->
                            <div class="modal fade" id="removeStudentModal{{ $etudiant->id }}" tabindex="-1" aria-labelledby="removeStudentModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="removeStudentModalLabel">Confirmer le retrait</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            u00cates-vous su00fbr de vouloir retirer l'u00e9tudiant <strong>{{ $etudiant->name }}</strong> du groupe <strong>{{ $groupe->nom }}</strong> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('admin.classes.groupe.remove-student', ['groupe_id' => $groupe->id, 'etudiant_id' => $etudiant->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Retirer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux classes
            </a>
        </div>
    </div>
</div>
@endsection
