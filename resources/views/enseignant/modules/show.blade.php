@extends('layouts.enseignant')

@section('title', $module->nom)

@section('styles')
<style>
    .module-header {
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        background-size: cover;
        background-position: center;
        position: relative;
        border-radius: 10px;
        margin-bottom: 30px;
    }
    
    .module-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
        border-radius: 10px;
    }
    
    .module-header-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 0 20px;
    }
    
    .module-title {
        font-size: 2.5rem;
        margin-bottom: 5px;
    }
    
    .module-code {
        font-size: 1.2rem;
        opacity: 0.9;
    }
    
    .module-badge {
        font-size: 0.9rem;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    
    .content-section {
        margin-bottom: 30px;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .item-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
    }
    
    .item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .item-icon {
        font-size: 2rem;
        margin-right: 15px;
    }
    
    .empty-list {
        text-align: center;
        padding: 30px;
        background-color: #f8f9fa;
        border-radius: 10px;
    }
    
    .empty-list i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 15px;
    }
    
    .nav-tabs .nav-link {
        border-radius: 8px 8px 0 0;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        background-color: #f8f9fa;
        border-bottom-color: #f8f9fa;
    }
    
    .tab-content {
        background-color: #f8f9fa;
        border-radius: 0 0 8px 8px;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-top: none;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .add-content-form {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête du module -->
    <div class="module-header" style="background-color: {{ $module->couleur ?? '#2196F3' }}; @if($module->image) background-image: url('{{ asset('storage/' . $module->image) }}'); @endif">
        <div class="module-header-content">
            <h1 class="module-title">{{ $module->nom }}</h1>
            @if($module->code)
                <div class="module-code">{{ $module->code }}</div>
            @endif
            <div class="mt-3">
                @foreach($module->groupes as $groupe)
                    <span class="badge bg-light text-dark module-badge">{{ $groupe->nom }}</span>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Fil d'Ariane -->
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item"><a href="{{ route('enseignant.modules.index') }}">Modules</a></li>
        <li class="breadcrumb-item active">{{ $module->nom }}</li>
    </ol>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <!-- Informations du module -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Informations du module
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Niveau:</strong> {{ $module->niveau ? $module->niveau->nom ?? 'Non défini' : 'Non défini' }}</p>
                            <p><strong>Nombre de groupes:</strong> {{ $module->groupes->count() }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Nombre de cours:</strong> {{ $module->cours->count() }}</p>
                            <p><strong>Nombre de devoirs:</strong> {{ $module->devoirs->count() }}</p>
                        </div>
                    </div>
                    
                    @if($module->description)
                        <div class="mt-3">
                            <h6>Description:</h6>
                            <p>{{ $module->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus-circle"></i> Ajouter du contenu
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" onclick="showAddForm('cours')">
                            <i class="fas fa-file-alt"></i> Ajouter un cours
                        </button>
                        <button class="btn btn-success" type="button" onclick="showAddForm('devoir')">
                            <i class="fas fa-tasks"></i> Ajouter un devoir
                        </button>
                        <button class="btn btn-info" type="button" onclick="showAddForm('examen')">
                            <i class="fas fa-clipboard-check"></i> Ajouter un examen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Onglets pour le contenu -->
    <ul class="nav nav-tabs" id="moduleContentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="cours-tab" data-bs-toggle="tab" data-bs-target="#cours" type="button" role="tab" aria-controls="cours" aria-selected="true">
                <i class="fas fa-file-alt"></i> Cours
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="devoirs-tab" data-bs-toggle="tab" data-bs-target="#devoirs" type="button" role="tab" aria-controls="devoirs" aria-selected="false">
                <i class="fas fa-tasks"></i> Devoirs
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="examens-tab" data-bs-toggle="tab" data-bs-target="#examens" type="button" role="tab" aria-controls="examens" aria-selected="false">
                <i class="fas fa-clipboard-check"></i> Examens
            </button>
        </li>
    </ul>
    
    <div class="tab-content" id="moduleContentTabsContent">
        <!-- Onglet Cours -->
        <div class="tab-pane fade show active" id="cours" role="tabpanel" aria-labelledby="cours-tab">
            <!-- Formulaire d'ajout de cours (caché par défaut) -->
            <div id="add-cours-form" class="add-content-form mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ajouter un nouveau cours</h5>
                        <button type="button" class="btn-close" onclick="hideAddForm('cours')"></button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('enseignant.cours.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="module_id" value="{{ $module->id }}">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="titre_cours" class="form-label">Titre du cours <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="titre_cours" name="titre" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="type_cours" class="form-label">Type de cours</label>
                                    <select class="form-select" id="type_cours" name="type">
                                        <option value="cours">Cours</option>
                                        <option value="tp">Travaux pratiques</option>
                                        <option value="td">Travaux dirigés</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description_cours" class="form-label">Description</label>
                                <textarea class="form-control" id="description_cours" name="description" rows="3"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="fichier_cours" class="form-label">Fichier du cours (PDF, DOCX, PPTX)</label>
                                <input type="file" class="form-control" id="fichier_cours" name="fichier">
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="hideAddForm('cours')">Annuler</button>
                                <button type="submit" class="btn btn-primary">Enregistrer le cours</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Liste des cours -->
            <div class="row">
                @forelse($module->cours as $cours)
                    <div class="col-md-6 mb-3">
                        <div class="card item-card">
                            <div class="card-body d-flex">
                                <div class="item-icon">
                                    @if($cours->type == 'tp')
                                        <i class="fas fa-flask text-success"></i>
                                    @elseif($cours->type == 'td')
                                        <i class="fas fa-pencil-alt text-info"></i>
                                    @else
                                        <i class="fas fa-book text-primary"></i>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="card-title">{{ $cours->titre }}</h5>
                                    <p class="card-text small text-muted">{{ Str::limit($cours->description, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Ajouté le {{ $cours->created_at->format('d/m/Y') }}</small>
                                        <div class="action-buttons">
                                            @if($cours->fichier)
                                                <a href="{{ asset('storage/' . $cours->fichier) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                            <a href="#" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="#" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-list">
                            <i class="fas fa-file-alt"></i>
                            <h5>Aucun cours disponible</h5>
                            <p>Commencez par ajouter un cours à ce module.</p>
                            <button class="btn btn-primary" onclick="showAddForm('cours')">
                                <i class="fas fa-plus"></i> Ajouter un cours
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Onglet Devoirs -->
        <div class="tab-pane fade" id="devoirs" role="tabpanel" aria-labelledby="devoirs-tab">
            <!-- Formulaire d'ajout de devoir (caché par défaut) -->
            <div id="add-devoir-form" class="add-content-form mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ajouter un nouveau devoir</h5>
                        <button type="button" class="btn-close" onclick="hideAddForm('devoir')"></button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('enseignant.devoirs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="module_id" value="{{ $module->id }}">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="titre_devoir" class="form-label">Titre du devoir <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="titre_devoir" name="titre" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="date_limite" class="form-label">Date limite de remise <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="date_limite" name="date_limite" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description_devoir" class="form-label">Instructions</label>
                                <textarea class="form-control" id="description_devoir" name="description" rows="3"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="fichier_devoir" class="form-label">Fichier joint (PDF, DOCX)</label>
                                <input type="file" class="form-control" id="fichier_devoir" name="fichier">
                            </div>
                            
                            <div class="mb-3">
                                <label for="groupes_devoir" class="form-label">Groupes concernés</label>
                                <select class="form-select" id="groupes_devoir" name="groupes[]" multiple>
                                    @foreach($module->groupes as $groupe)
                                        <option value="{{ $groupe->id }}">{{ $groupe->nom }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Laissez vide pour assigner à tous les groupes du module.</div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="hideAddForm('devoir')">Annuler</button>
                                <button type="submit" class="btn btn-success">Publier le devoir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Liste des devoirs -->
            <div class="row">
                @forelse($module->devoirs as $devoir)
                    <div class="col-md-6 mb-3">
                        <div class="card item-card">
                            <div class="card-body d-flex">
                                <div class="item-icon">
                                    <i class="fas fa-tasks text-success"></i>
                                </div>
                                <div class="w-100">
                                    <h5 class="card-title">{{ $devoir->titre }}</h5>
                                    <p class="card-text small text-muted">{{ Str::limit($devoir->description, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-warning">Date limite: {{ $devoir->date_limite->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <div class="action-buttons">
                                            @if($devoir->fichier)
                                                <a href="{{ asset('storage/' . $devoir->fichier) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                            <a href="#" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="#" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce devoir?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-list">
                            <i class="fas fa-tasks"></i>
                            <h5>Aucun devoir disponible</h5>
                            <p>Commencez par ajouter un devoir à ce module.</p>
                            <button class="btn btn-success" onclick="showAddForm('devoir')">
                                <i class="fas fa-plus"></i> Ajouter un devoir
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Onglet Examens -->
        <div class="tab-pane fade" id="examens" role="tabpanel" aria-labelledby="examens-tab">
            <!-- Formulaire d'ajout d'examen (caché par défaut) -->
            <div id="add-examen-form" class="add-content-form mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ajouter un nouvel examen</h5>
                        <button type="button" class="btn-close" onclick="hideAddForm('examen')"></button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('enseignant.examens.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="module_id" value="{{ $module->id }}">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="titre_examen" class="form-label">Titre de l'examen <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="titre_examen" name="titre" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="type_examen" class="form-label">Type d'examen</label>
                                    <select class="form-select" id="type_examen" name="type">
                                        <option value="controle">Contrôle continu</option>
                                        <option value="partiel">Examen partiel</option>
                                        <option value="final">Examen final</option>
                                        <option value="rattrapage">Rattrapage</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_examen" class="form-label">Date de l'examen <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date_examen" name="date" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="duree_examen" class="form-label">Durée (minutes)</label>
                                    <input type="number" class="form-control" id="duree_examen" name="duree" min="15" step="15" value="60">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description_examen" class="form-label">Instructions</label>
                                <textarea class="form-control" id="description_examen" name="description" rows="3"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="groupes_examen" class="form-label">Groupes concernés</label>
                                <select class="form-select" id="groupes_examen" name="groupes[]" multiple>
                                    @foreach($module->groupes as $groupe)
                                        <option value="{{ $groupe->id }}">{{ $groupe->nom }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Laissez vide pour assigner à tous les groupes du module.</div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="hideAddForm('examen')">Annuler</button>
                                <button type="submit" class="btn btn-info">Planifier l'examen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Liste des examens -->
            <div class="empty-list">
                <i class="fas fa-clipboard-check"></i>
                <h5>Aucun examen disponible</h5>
                <p>Commencez par planifier un examen pour ce module.</p>
                <button class="btn btn-info" onclick="showAddForm('examen')">
                    <i class="fas fa-plus"></i> Ajouter un examen
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Afficher le formulaire d'ajout
    function showAddForm(type) {
        // Cacher tous les formulaires
        document.querySelectorAll('.add-content-form').forEach(form => {
            form.style.display = 'none';
        });
        
        // Afficher le formulaire demandé
        document.getElementById(`add-${type}-form`).style.display = 'block';
        
        // Faire défiler jusqu'au formulaire
        document.getElementById(`add-${type}-form`).scrollIntoView({ behavior: 'smooth' });
    }
    
    // Cacher le formulaire d'ajout
    function hideAddForm(type) {
        document.getElementById(`add-${type}-form`).style.display = 'none';
    }
    
    // Activer l'onglet spécifié dans l'URL si présent
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        
        if (tab) {
            const tabElement = document.querySelector(`#moduleContentTabs button[data-bs-target="#${tab}"]`);
            if (tabElement) {
                const tabInstance = new bootstrap.Tab(tabElement);
                tabInstance.show();
                
                // Afficher le formulaire si demandé
                const showForm = urlParams.get('showForm');
                if (showForm === 'true') {
                    showAddForm(tab.replace('s', '')); // Enlever le 's' pour obtenir le type singulier (cours, devoir, examen)
                }
            }
        }
    });
</script>
@endsection
