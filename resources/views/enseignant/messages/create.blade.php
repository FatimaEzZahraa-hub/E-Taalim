@extends('layouts.app')

@section('title', 'Nouveau Message')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('enseignant.messages') }}" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 fw-bold mb-1" style="color: #333;">Nouveau Message</h1>
                <p class="text-muted mb-0">Communiquez avec vos étudiants</p>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4 p-lg-5">
            <form action="{{ route('enseignant.messages.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="destinataire_id" class="form-label fw-medium mb-2">Destinataire</label>
                    <select class="form-select form-select-lg @error('destinataire_id') is-invalid @enderror" id="destinataire_id" name="destinataire_id" required style="border-radius: 12px; padding: 0.75rem 1.25rem; border-color: #e0e0e0;">
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
                
                <div class="mb-4">
                    <label for="sujet" class="form-label fw-medium mb-2">Sujet</label>
                    <input type="text" class="form-control form-control-lg @error('sujet') is-invalid @enderror" id="sujet" name="sujet" value="{{ old('sujet') }}" required style="border-radius: 12px; padding: 0.75rem 1.25rem; border-color: #e0e0e0;">
                    @error('sujet')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="contenu" class="form-label fw-medium mb-2">Message</label>
                    <textarea class="form-control form-control-lg @error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="8" required style="border-radius: 12px; padding: 0.75rem 1.25rem; border-color: #e0e0e0; min-height: 200px;">{{ old('contenu') }}</textarea>
                    @error('contenu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end mt-5">
                    <a href="{{ route('enseignant.messages') }}" class="btn btn-light rounded-pill px-4 py-2 me-3" style="font-weight: 500;">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-action">
                        <i class="bi bi-send-fill me-2"></i>Envoyer le message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
