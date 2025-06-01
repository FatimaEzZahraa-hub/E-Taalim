@extends('layouts.admin')

@section('title', 'Gestion des Classes')

@section('styles')
<style>
    .card {
        border-radius: 8px !important;
        margin-bottom: 20px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
    }
    
    .card-header {
        background-color: var(--primary-color) !important;
        color: white !important;
        border-bottom: 1px solid #e3e6f0 !important;
        padding: 1.2rem 1.5rem !important;
        border-radius: 8px 8px 0 0 !important;
    }
    
    .niveau-card {
        margin-bottom: 2.5rem;
        border: none;
        overflow: hidden;
    }
    
    .groupe-card {
        border: 1px solid #e3e6f0;
        height: 100%;
    }
    
    .niveau-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .badge-count {
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        background-color: rgba(255, 255, 255, 0.3);
    }
    
    .btn-icon {
        width: 38px;
        height: 38px;
        padding: 0;
        line-height: 38px;
        text-align: center;
        border-radius: 50%;
        margin-left: 8px;
        background-color: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
    }
    
    .btn-icon:hover {
        background-color: rgba(255, 255, 255, 0.4);
        color: white;
    }
    
    .groupe-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 10px;
    }
    
    .groupe-item {
        flex: 0 0 calc(50% - 20px);
        max-width: calc(50% - 20px);
        margin-bottom: 15px;
    }
    
    .groupe-card {
        min-height: 220px;
    }
    
    .create-niveau-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        transition: all 0.3s ease;
    }
    
    .create-niveau-btn:hover {
        transform: scale(1.1);
        background-color: var(--secondary-color);
        color: white;
    }
    
    .student-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .student-item {
        padding: 8px 12px;
        border-bottom: 1px solid #e3e6f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .student-item:last-child {
        border-bottom: none;
    }
    
    .empty-list {
        padding: 30px;
        text-align: center;
        color: #6c757d;
    }
    
    @media (max-width: 1200px) {
        .groupe-item {
            flex: 0 0 calc(50% - 20px);
            max-width: calc(50% - 20px);
        }
    }
    
    @media (max-width: 768px) {
        .groupe-item {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gestion des Classes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item active">Classes</li>
    </ol>
    
    <!-- Bouton flottant pour créer un niveau -->
    <a href="#" class="create-niveau-btn" data-bs-toggle="modal" data-bs-target="#createNiveauModal">
        <i class="fas fa-plus"></i>
    </a>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <!-- Modal pour créer un niveau -->
    <div class="modal fade" id="createNiveauModal" tabindex="-1" aria-labelledby="createNiveauModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createNiveauModalLabel">Créer un nouveau niveau</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.classes.niveaux.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du niveau</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nb_groupes" class="form-label">Nombre de groupes</label>
                            <input type="number" class="form-control" id="nb_groupes" name="nb_groupes" min="0" value="0">
                            <small class="text-muted">Vous pourrez ajouter des groupes plus tard si nécessaire.</small>
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
    
    @if($niveaux->isEmpty())
        <div class="alert alert-info">
            Aucun niveau n'a été créé. <button class="btn btn-link p-0 alert-link" data-bs-toggle="modal" data-bs-target="#createNiveauModal">Créez votre premier niveau</button>.
        </div>
    @else
        <div class="row">
            @foreach($niveaux as $niveau)
                <div class="col-md-6 mb-4">
                    <div class="card niveau-card">
                        <div class="card-header">
                            <div class="niveau-title">
                                <h5 class="mb-0">
                                    {{ $niveau->nom }}
                                    <span class="badge badge-count ms-2">{{ $niveau->groupes->count() }} groupe(s)</span>
                                </h5>
                                <div>
                                    <button class="btn btn-icon" data-bs-toggle="modal" data-bs-target="#createGroupeModal{{ $niveau->id }}" title="Ajouter un groupe">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.classes.niveaux.edit', $niveau->id) }}" class="btn btn-icon" title="Modifier le niveau">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                            @if($niveau->description)
                                <p class="text-white-50 mb-0 mt-2">{{ $niveau->description }}</p>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($niveau->groupes->isEmpty())
                                <div class="empty-list">
                                    <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                                    <p>Aucun groupe n'a été créé pour ce niveau.</p>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createGroupeModal{{ $niveau->id }}">
                                        <i class="fas fa-plus me-1"></i> Ajouter un groupe
                                    </button>
                                </div>
                            @else
                                <div class="groupe-list">
                                    @foreach($niveau->groupes as $groupe)
                                        <div class="groupe-item">
                                            <div class="card groupe-card">
                                                <div class="card-header bg-light">
                                                    <h6 class="card-title mb-0 d-flex justify-content-between align-items-center">
                                                        {{ $groupe->nom }}
                                                        <span class="badge bg-info">{{ $groupe->etudiants->count() }}/{{ $groupe->capacite }}</span>
                                                    </h6>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="student-list">
                                                        @if($groupe->etudiants->isEmpty())
                                                            <div class="empty-list">
                                                                <p>Aucun étudiant dans ce groupe</p>
                                                            </div>
                                                        @else
                                                            @foreach($groupe->etudiants as $etudiant)
                                                                <div class="student-item">
                                                                    <span>{{ $etudiant->name }}</span>
                                                                    <form action="{{ route('admin.classes.groupe.remove-student', ['groupe_id' => $groupe->id, 'etudiant_id' => $etudiant->id]) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Retirer l'étudiant">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-light d-flex justify-content-between">
                                                    <a href="{{ route('admin.classes.groupe.students', $groupe->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-users me-1"></i> Gérer
                                                    </a>
                                                    <div>
                                                        <a href="{{ route('admin.classes.groupes.edit', $groupe->id) }}" class="btn btn-sm btn-secondary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteGroupeModal{{ $groupe->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- Modal Suppression Groupe -->
                                    <div class="modal fade" id="deleteGroupeModal{{ $groupe->id }}" tabindex="-1" aria-labelledby="deleteGroupeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteGroupeModalLabel">Confirmer la suppression</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer le groupe <strong>{{ $groupe->nom }}</strong> ?
                                                    <p class="text-danger mt-2">Attention : Cette action supprimera également toutes les affectations d'étudiants à ce groupe.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('admin.classes.groupes.destroy', $groupe->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteNiveauModal{{ $niveau->id }}">
                                <i class="fas fa-trash"></i> Supprimer ce niveau
                            </button>
                        </div>
                        
                        <!-- Modal pour créer un groupe -->
                        <div class="modal fade" id="createGroupeModal{{ $niveau->id }}" tabindex="-1" aria-labelledby="createGroupeModalLabel{{ $niveau->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="createGroupeModalLabel{{ $niveau->id }}">Ajouter un groupe au niveau {{ $niveau->nom }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.classes.groupes.store') }}" method="POST" class="needs-validation" novalidate>
                                        @csrf
                                        @if($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <input type="hidden" name="niveau_id" value="{{ $niveau->id }}">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nom_groupe_{{ $niveau->id }}" class="form-label">Nom du groupe</label>
                                                <input type="text" class="form-control" id="nom_groupe_{{ $niveau->id }}" name="nom" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="filiere_{{ $niveau->id }}" class="form-label">Filière</label>
                                                <input type="text" class="form-control" id="filiere_{{ $niveau->id }}" name="description" placeholder="Ex: Sciences Mathématiques">
                                            </div>
                                            <div class="mb-3">
                                                <label for="capacite_{{ $niveau->id }}" class="form-label">Capacité maximale</label>
                                                <input type="number" class="form-control" id="capacite_{{ $niveau->id }}" name="capacite" min="1" value="30">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-success">Ajouter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            
            <!-- Modal Suppression Niveau -->
            <div class="modal fade" id="deleteNiveauModal{{ $niveau->id }}" tabindex="-1" aria-labelledby="deleteNiveauModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteNiveauModalLabel">Confirmer la suppression</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Êtes-vous sûr de vouloir supprimer le niveau <strong>{{ $niveau->nom }}</strong> ?
                            <p class="text-danger mt-2">Attention : Cette action supprimera également tous les groupes associés à ce niveau et toutes les affectations d'étudiants à ces groupes.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <form action="{{ route('admin.classes.niveaux.destroy', $niveau->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@section('scripts')
    @include('admin.classes.index_scripts')
@endsection
