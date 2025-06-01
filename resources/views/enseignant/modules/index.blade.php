@extends('layouts.enseignant')

@section('title', 'Mes modules')

@section('styles')
<style>
    .module-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        cursor: pointer;
    }
    
    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .module-header {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.4rem;
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
        padding: 0 15px;
    }
    
    .module-body {
        padding: 1.25rem;
    }
    
    .module-stats {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }
    
    .stat-item {
        text-align: center;
        padding: 10px;
        border-radius: 5px;
        background-color: rgba(0, 0, 0, 0.03);
        flex: 1;
        margin: 0 5px;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: bold;
        display: block;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: #666;
    }
    
    .module-badge {
        font-size: 0.8rem;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 0;
    }
    
    .empty-state i {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Mes modules</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Tableau de bord</a></li>
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
    
    <!-- Liste des modules -->
    <div class="row">
        @forelse($modules as $module)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card module-card" onclick="window.location.href='{{ route('enseignant.modules.show', $module->id) }}'">
                    <div class="module-header" style="background-color: {{ $module->couleur ?? '#2196F3' }}; @if($module->image) background-image: url('{{ asset('storage/' . $module->image) }}'); @endif">
                        <div class="module-header-content">
                            <h5 class="card-title mb-0">{{ $module->nom }}</h5>
                            @if($module->code)
                                <small>{{ $module->code }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="module-body">
                        <p class="card-text">
                            <strong>Niveau:</strong> {{ $module->niveau ? $module->niveau->nom ?? 'Non défini' : 'Non défini' }}
                        </p>
                        
                        <div class="mb-3">
                            @foreach($module->groupes as $groupe)
                                <span class="badge bg-secondary module-badge">{{ $groupe->nom }}</span>
                            @endforeach
                        </div>
                        
                        <div class="module-stats">
                            <div class="stat-item">
                                <span class="stat-value">{{ $module->cours->count() }}</span>
                                <span class="stat-label">Cours</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">{{ $module->devoirs->count() }}</span>
                                <span class="stat-label">Devoirs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-book"></i>
                    <h3>Vous n'avez pas encore de modules</h3>
                    <p>Aucun module ne vous a encore u00e9tu00e9 assignu00e9. Veuillez contacter l'administration si vous pensez qu'il s'agit d'une erreur.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
