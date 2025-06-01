@extends('layouts.admin')

@section('title', 'Ajouter un module')

@section('styles')
<style>
    .color-preview {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #ddd;
        transition: transform 0.2s;
    }
    
    .color-preview:hover {
        transform: scale(1.1);
    }
    
    .color-preview.selected {
        transform: scale(1.1);
        border: 2px solid #000;
    }
    
    .module-preview {
        height: 150px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        margin-bottom: 20px;
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }
    
    .module-preview::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }
    
    .module-preview-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 0 20px;
    }
    
    .module-preview-code {
        font-size: 0.9rem;
        opacity: 0.9;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Ajouter un module</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.modules.index') }}">Modules</a></li>
        <li class="breadcrumb-item active">Ajouter un module</li>
    </ol>
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus"></i> Informations du module
        </div>
        <div class="card-body">
            <form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Colonne de gauche - Informations du module -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom du module <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Code du module</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="Ex: MATH101">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="niveau_id" class="form-label">Niveau <span class="text-danger">*</span></label>
                                <select class="form-select @error('niveau_id') is-invalid @enderror" id="niveau_id" name="niveau_id" required>
                                    <option value="">Sélectionner un niveau</option>
                                    @foreach($niveaux as $niveau)
                                        <option value="{{ ObjHelper::prop($niveau, 'id') }}" {{ old('niveau_id') == ObjHelper::prop($niveau, 'id') ? 'selected' : '' }}>{{ ObjHelper::prop($niveau, 'nom', 'Niveau ' . ObjHelper::prop($niveau, 'id')) }}</option>
                                    @endforeach
                                </select>
                                @error('niveau_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="enseignant_id" class="form-label">Enseignant <span class="text-danger">*</span></label>
                                <select class="form-select @error('enseignant_id') is-invalid @enderror" id="enseignant_id" name="enseignant_id" required>
                                    <option value="">Sélectionner un enseignant</option>
                                    @foreach($enseignants as $enseignant)
                                        <option value="{{ ObjHelper::prop($enseignant, 'id') }}" {{ old('enseignant_id') == ObjHelper::prop($enseignant, 'id') ? 'selected' : '' }}>{{ ObjHelper::prop($enseignant, 'name') }}</option>
                                    @endforeach
                                </select>
                                @error('enseignant_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="groupes" class="form-label">Groupes</label>
                            <select class="form-select @error('groupes') is-invalid @enderror" id="groupes" name="groupes[]" multiple size="5">
                                <option value="">Sélectionnez d'abord un niveau</option>
                            </select>
                            <div class="form-text">Maintenez la touche Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs groupes.</div>
                            @error('groupes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Colonne de droite - Apparence et prévisualisation -->
                    <div class="col-md-4">
                        <div class="module-preview" id="modulePreview" style="background-color: #2196F3;">
                            <div class="module-preview-content">
                                <div id="previewNom">Nom du module</div>
                                <div class="module-preview-code" id="previewCode"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Couleur du module</label>
                            <div class="d-flex flex-wrap">
                                @foreach($couleurs_suggestions as $couleur)
                                    <div class="color-preview" style="background-color: {{ $couleur }};" data-color="{{ $couleur }}" onclick="selectColor('{{ $couleur }}')"></div>
                                @endforeach
                            </div>
                            <input type="hidden" name="couleur" id="couleur" value="#2196F3">
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Image du module</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*">
                            <div class="form-text">Format recommandé: 800x400px, max 2MB</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Enregistrer le module
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prévisualisation du module
        const nomInput = document.getElementById('nom');
        const codeInput = document.getElementById('code');
        const previewNom = document.getElementById('previewNom');
        const previewCode = document.getElementById('previewCode');
        const modulePreview = document.getElementById('modulePreview');
        const imageInput = document.getElementById('image');
        
        // Mettre à jour la prévisualisation quand le nom change
        nomInput.addEventListener('input', function() {
            previewNom.textContent = this.value || 'Nom du module';
        });
        
        // Mettre à jour la prévisualisation quand le code change
        codeInput.addEventListener('input', function() {
            previewCode.textContent = this.value;
        });
        
        // Prévisualisation de l'image
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    modulePreview.style.backgroundImage = `url('${e.target.result}')`;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Chargement dynamique des groupes en fonction du niveau sélectionné
        const niveauSelect = document.getElementById('niveau_id');
        const groupesSelect = document.getElementById('groupes');
        
        niveauSelect.addEventListener('change', function() {
            const niveauId = this.value;
            
            // Réinitialiser le select des groupes
            groupesSelect.innerHTML = '<option value="">Sélectionnez d\'abord un niveau</option>';
            
            if (niveauId) {
                // Faire une requête AJAX pour obtenir les groupes du niveau sélectionné
                fetch(`/admin/api/niveaux/${niveauId}/groupes`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.groupes && data.groupes.length > 0) {
                            groupesSelect.innerHTML = '';
                            data.groupes.forEach(groupe => {
                                const option = document.createElement('option');
                                option.value = groupe.id;
                                option.textContent = groupe.nom;
                                groupesSelect.appendChild(option);
                            });
                        } else {
                            groupesSelect.innerHTML = '<option value="">Aucun groupe disponible pour ce niveau</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des groupes:', error);
                        groupesSelect.innerHTML = '<option value="">Erreur lors du chargement des groupes</option>';
                    });
            }
        });
    });
    
    // Sélection de couleur
    function selectColor(color) {
        // Mettre à jour la couleur de prévisualisation
        document.getElementById('modulePreview').style.backgroundColor = color;
        
        // Mettre à jour la valeur cachée
        document.getElementById('couleur').value = color;
        
        // Mettre à jour la sélection visuelle
        document.querySelectorAll('.color-preview').forEach(el => {
            el.classList.remove('selected');
        });
        
        document.querySelector(`.color-preview[data-color="${color}"]`).classList.add('selected');
    }
    
    // Sélectionner la couleur par défaut au chargement
    document.addEventListener('DOMContentLoaded', function() {
        selectColor('#2196F3');
    });
</script>
@endsection
