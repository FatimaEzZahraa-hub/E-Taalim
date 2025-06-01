@extends('layouts.app')

@section('title', 'Nouveau message')

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('etudiant.messages') }}">Messages</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nouveau message</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h1 class="h3 mb-0">Nouveau message</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('etudiant.messages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="destinataire" class="form-label">Destinataire</label>
                    <select class="form-select @error('destinataire') is-invalid @enderror" id="destinataire" name="destinataire" required>
                        <option value="">Su00e9lectionner un enseignant</option>
                        @foreach($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}" {{ old('destinataire') == $enseignant->id ? 'selected' : '' }}>
                                {{ $enseignant->titre }} {{ $enseignant->nom }} {{ $enseignant->prenom }} - {{ $enseignant->matiere }}
                            </option>
                        @endforeach
                    </select>
                    @error('destinataire')
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

                <div class="mb-3">
                    <label for="contenu" class="form-label">Message</label>
                    <textarea class="form-control @error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="8" required>{{ old('contenu') }}</textarea>
                    @error('contenu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pieces_jointes" class="form-label">Piu00e8ces jointes (optionnel)</label>
                    <input class="form-control @error('pieces_jointes') is-invalid @enderror" type="file" id="pieces_jointes" name="pieces_jointes[]" multiple>
                    <div class="form-text">Vous pouvez su00e9lectionner plusieurs fichiers. Taille maximale par fichier: 5MB.</div>
                    @error('pieces_jointes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('etudiant.messages') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                        <i class="bi bi-send me-1"></i> Envoyer le message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
