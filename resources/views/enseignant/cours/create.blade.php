@extends('layouts.app')

@section('title', 'Ajouter un Cours')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold mb-0">Ajouter un Cours</h1>
        <a href="{{ route('enseignant.cours') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour aux Cours
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('enseignant.cours.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre du Cours <span class="text-danger">*</span></label>
                    <input id="titre" type="text" class="form-control @error('titre') is-invalid @enderror" name="titre" value="{{ old('titre') }}" required>
                    @error('titre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="classe_id" class="form-label">Classe <span class="text-danger">*</span></label>
                    <select id="classe_id" class="form-select @error('classe_id') is-invalid @enderror" name="classe_id" required>
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                    @error('classe_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="fichier" class="form-label">Fichier du Cours</label>
                    <input id="fichier" type="file" class="form-control @error('fichier') is-invalid @enderror" name="fichier">
                    @error('fichier')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <small class="form-text text-muted">Formats acceptés : PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX. Taille maximale : 10 Mo.</small>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Enregistrer le Cours
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
