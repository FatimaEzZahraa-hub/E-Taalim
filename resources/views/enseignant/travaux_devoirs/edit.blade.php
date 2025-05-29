@extends('layouts.app')

@section('title', 'Modifier un Travail/Devoir')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Modifier un Travail/Devoir</h1>
            <p class="text-muted">Cours: {{ $cours->titre }}</p>
        </div>
        <a href="{{ route('enseignant.travaux_devoirs', $cours->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour aux Travaux/Devoirs
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('enseignant.travaux_devoirs.update', [$cours->id, $travailDevoir->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                    <input id="titre" type="text" class="form-control @error('titre') is-invalid @enderror" name="titre" value="{{ old('titre', $travailDevoir->titre) }}" required>
                    @error('titre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ old('description', $travailDevoir->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="date_limite" class="form-label">Date Limite <span class="text-danger">*</span></label>
                    <input id="date_limite" type="date" class="form-control @error('date_limite') is-invalid @enderror" name="date_limite" value="{{ old('date_limite', $travailDevoir->date_limite ? $travailDevoir->date_limite->format('Y-m-d') : '') }}" required>
                    @error('date_limite')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="fichier" class="form-label">Fichier</label>
                    @if($travailDevoir->fichier)
                        <div class="mb-2">
                            <a href="{{ asset('storage/travaux_devoirs/' . $travailDevoir->fichier) }}" target="_blank" class="btn btn-sm btn-outline-primary">
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
                        <i class="fas fa-save me-2"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
