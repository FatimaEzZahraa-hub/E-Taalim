@extends('layouts.admin')

@section('title', 'Gestion des modules')

@section('styles')
<style>
    .module-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
    }
    
    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .module-header {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .module-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }
    
    .module-header-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 0 10px;
    }
    
    .module-body {
        padding: 1.25rem;
    }
    
    .module-footer {
        background-color: rgba(0, 0, 0, 0.03);
        border-top: 1px solid rgba(0, 0, 0, 0.125);
        padding: 0.75rem 1.25rem;
    }
    
    .module-badge {
        font-size: 0.8rem;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    
    .btn-module-action {
        margin-right: 5px;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 0;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Gestion des modules</h1>
        <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau module
        </a>
    </div>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item active">Modules</li>
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
    
    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter"></i> Filtres
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="filterNiveau" class="form-label">Niveau</label>
                    <select id="filterNiveau" class="form-select">
                        <option value="">Tous les niveaux</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ ObjHelper::prop($niveau, 'id') }}">{{ ObjHelper::prop($niveau, 'nom', 'Niveau ' . ObjHelper::prop($niveau, 'id')) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="filterEnseignant" class="form-label">Enseignant</label>
                    <select id="filterEnseignant" class="form-select">
                        <option value="">Tous les enseignants</option>
                        @foreach($enseignants as $enseignant)
                            <option value="{{ ObjHelper::prop($enseignant, 'id') }}">{{ ObjHelper::prop($enseignant, 'name') }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="searchModule" class="form-label">Rechercher</label>
                    <input type="text" id="searchModule" class="form-control" placeholder="Nom ou code du module...">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Liste des modules -->
    <div class="row" id="modulesList">
        @forelse($modules as $module)
            <div class="col-md-4 col-lg-3 mb-4 module-item" 
                 data-niveau="{{ ObjHelper::prop($module, 'niveau_id') }}" 
                 data-enseignant="{{ ObjHelper::prop($module, 'enseignant_id') }}" 
                 data-nom="{{ ObjHelper::prop($module, 'nom', 'Module ' . ObjHelper::prop($module, 'id')) }}" 
                 data-code="{{ ObjHelper::prop($module, 'code', '') }}">
                <div class="card module-card">
                    <div class="module-header" style="background-color: {{ ObjHelper::prop($module, 'couleur', '#2196F3') }}; @if(ObjHelper::prop($module, 'image')) background-image: url('{{ asset('storage/' . ObjHelper::prop($module, 'image')) }}'); @endif">
                        <div class="module-header-content">
                            <h5>{{ ObjHelper::prop($module, 'nom', 'Module ' . ObjHelper::prop($module, 'id')) }}</h5>
                            @if(ObjHelper::prop($module, 'code'))
                                <small>{{ ObjHelper::prop($module, 'code') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="module-body">
                        <p class="card-text">
                            <strong>Niveau:</strong> {{ ObjHelper::prop(ObjHelper::prop($module, 'niveau'), 'nom', 'Non défini') }}<br>
                            <strong>Enseignant:</strong> {{ ObjHelper::prop(ObjHelper::prop($module, 'enseignant'), 'name', 'Non défini') }}
                        </p>
                        
                        <div class="mb-2">
                            @if(ObjHelper::prop($module, 'groupes') && count(ObjHelper::prop($module, 'groupes', [])) > 0)
                                @foreach(ObjHelper::prop($module, 'groupes', []) as $groupe)
                                    <span class="badge bg-secondary module-badge">{{ ObjHelper::prop($groupe, 'nom', 'Groupe ' . ObjHelper::prop($groupe, 'id')) }}</span>
                                @endforeach
                            @else
                                <span class="badge bg-light text-dark module-badge">Aucun groupe</span>
                            @endif
                        </div>
                        
                        <p class="card-text small text-muted">
                            {{ ObjHelper::prop($module, 'description') ? Str::limit(ObjHelper::prop($module, 'description'), 100) : 'Aucune description' }}
                        </p>
                    </div>
                    <div class="module-footer d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.modules.show', ObjHelper::prop($module, 'id')) }}" class="btn btn-sm btn-info btn-module-action">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.modules.edit', ObjHelper::prop($module, 'id')) }}" class="btn btn-sm btn-primary btn-module-action">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <form action="{{ route('admin.modules.destroy', ObjHelper::prop($module, 'id')) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce module?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-book"></i>
                    <h3>Aucun module disponible</h3>
                    <p>Commencez par créer un nouveau module en cliquant sur le bouton "Nouveau module".</p>
                    <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer un module
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtrage des modules
        function filterModules() {
            const niveauFilter = document.getElementById('filterNiveau').value;
            const enseignantFilter = document.getElementById('filterEnseignant').value;
            const searchFilter = document.getElementById('searchModule').value.toLowerCase();
            
            const moduleItems = document.querySelectorAll('.module-item');
            
            moduleItems.forEach(function(item) {
                const niveauId = item.getAttribute('data-niveau');
                const enseignantId = item.getAttribute('data-enseignant');
                const nom = item.getAttribute('data-nom').toLowerCase();
                const code = item.getAttribute('data-code')?.toLowerCase() || '';
                
                const matchNiveau = !niveauFilter || niveauId === niveauFilter;
                const matchEnseignant = !enseignantFilter || enseignantId === enseignantFilter;
                const matchSearch = !searchFilter || nom.includes(searchFilter) || code.includes(searchFilter);
                
                if (matchNiveau && matchEnseignant && matchSearch) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Vérifier s'il y a des modules visibles
            const visibleModules = document.querySelectorAll('.module-item[style="display: "]');
            const emptyState = document.querySelector('.empty-state');
            
            if (visibleModules.length === 0 && !emptyState) {
                const modulesList = document.getElementById('modulesList');
                modulesList.innerHTML += `
                    <div class="col-12 no-results">
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <h3>Aucun résultat trouvé</h3>
                            <p>Essayez de modifier vos critères de recherche.</p>
                            <button class="btn btn-secondary" onclick="resetFilters()">
                                <i class="fas fa-undo"></i> Réinitialiser les filtres
                            </button>
                        </div>
                    </div>
                `;
            } else if (visibleModules.length > 0) {
                const noResults = document.querySelector('.no-results');
                if (noResults) {
                    noResults.remove();
                }
            }
        }
        
        // Réinitialiser les filtres
        window.resetFilters = function() {
            document.getElementById('filterNiveau').value = '';
            document.getElementById('filterEnseignant').value = '';
            document.getElementById('searchModule').value = '';
            filterModules();
        };
        
        // Événements pour les filtres
        document.getElementById('filterNiveau').addEventListener('change', filterModules);
        document.getElementById('filterEnseignant').addEventListener('change', filterModules);
        document.getElementById('searchModule').addEventListener('input', filterModules);
    });
</script>
@endsection
