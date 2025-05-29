@extends('layouts.app')

@section('title', 'Nouveau Message')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('enseignant.messages') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="display-5 fw-bold mb-0">Nouveau Message</h1>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('enseignant.messages.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="destinataire_id" class="form-label">Destinataire</label>
                    <select class="form-select @error('destinataire_id') is-invalid @enderror" id="destinataire_id" name="destinataire_id" required>
                        <option value="">Sélectionner un destinataire</option>
                        @foreach($etudiants as $etudiant)
                            <option value="{{ $etudiant->id }}" {{ old('destinataire_id') == $etudiant->id ? 'selected' : '' }}>
                                {{ $etudiant->prenom }} {{ $etudiant->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('destinataire_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="sujet" class="form-label">Sujet</label>
                    <input type="text" class="form-control @error('sujet') is-invalid @enderror" id="sujet" name="sujet" value="{{ old('sujet') }}" required>
                    @error('sujet')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="contenu" class="form-label">Message</label>
                    <textarea class="form-control @error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="6" required>{{ old('contenu') }}</textarea>
                    @error('contenu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('enseignant.messages') }}" class="btn btn-outline-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
