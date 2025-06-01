@extends('layouts.app')

@section('title', 'Modifier un Cours')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('enseignant.cours') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour aux Cours
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('enseignant.cours.update', $cours->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre du Cours <span class="text-danger">*</span></label>
                    <input id="titre" type="text" class="form-control @error('titre') is-invalid @enderror" name="titre" value="{{ old('titre', $cours->titre) }}" required>
                    @error('titre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
<<<<<<< HEAD
                    <label for="groupe_id" class="form-label">Groupe <span class="text-danger">*</span></label>
                    <select id="groupe_id" class="form-select @error('groupe_id') is-invalid @enderror" name="groupe_id" required>
                        <option value="">Sélectionner un groupe</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ (old('groupe_id', $cours->groupe->id ?? null) == $groupe->id) ? 'selected' : '' }}>{{ $groupe->nom }}</option>
                        @endforeach
                    </select>
                    @error('groupe_id')
=======
                    <label for="classe_id" class="form-label">Classe <span class="text-danger">*</span></label>
                    <select id="classe_id" class="form-select @error('classe_id') is-invalid @enderror" name="classe_id" required>
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ (old('classe_id', $cours->classe->id ?? null) == $classe->id) ? 'selected' : '' }}>{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                    @error('classe_id')
>>>>>>> login-acceuil
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ old('description', $cours->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="fichier" class="form-label">Fichier du Cours</label>
                    @if($cours->fichier)
                        <div class="mb-2">
                            <a href="{{ asset('storage/cours/' . $cours->fichier) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-file me-1"></i> Voir le fichier actuel
                            </a>
                        </div>
                    @endif
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
                        <i class="fas fa-save me-2"></i> Mettre à jour le Cours
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
