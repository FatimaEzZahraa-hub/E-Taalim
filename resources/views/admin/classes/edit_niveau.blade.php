@extends('layouts.admin')

@section('title', 'Modifier un Niveau')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Modifier un Niveau</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.classes.index') }}">Classes</a></li>
        <li class="breadcrumb-item active">Modifier un niveau</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Modifier le niveau: {{ $niveau->nom }}
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
            
            <form action="{{ route('admin.classes.niveaux.update', $niveau->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du niveau</label>
                    <input type="text" class="form-control" id="nom" name="nom" required value="{{ old('nom', $niveau->nom) }}">
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $niveau->description) }}</textarea>
                    <div class="form-text">Une description courte et claire du niveau (optionnel).</div>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="actif" name="actif" {{ $niveau->actif ? 'checked' : '' }}>
                    <label class="form-check-label" for="actif">Niveau actif</label>
                    <div class="form-text">Un niveau inactif ne sera pas disponible pour la création de nouveaux groupes ou l'affectation d'étudiants.</div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
