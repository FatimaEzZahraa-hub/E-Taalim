@extends('layouts.admin')

@section('title', 'Cru00e9er un Groupe')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Cru00e9er un Groupe</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.classes.index') }}">Classes</a></li>
        <li class="breadcrumb-item active">Cru00e9er un groupe</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            Nouveau groupe pour le niveau: <strong>{{ $niveau->nom }}</strong>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.classes.groupes.store', $niveau->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du groupe</label>
                    <input type="text" class="form-control" id="nom" name="nom" required value="{{ old('nom') }}">
                    <div class="form-text">Exemple: Groupe A, Classe 1, etc.</div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    <div class="form-text">Une description courte et claire du groupe (optionnel).</div>
                </div>
                
                <div class="mb-3">
                    <label for="capacite" class="form-label">Capacitu00e9 maximale</label>
                    <input type="number" class="form-control" id="capacite" name="capacite" min="1" value="{{ old('capacite', 30) }}">
                    <div class="form-text">Nombre maximal d'u00e9tudiants dans ce groupe.</div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Cru00e9er le groupe</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
