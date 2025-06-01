@extends('layouts.admin')

@section('title', 'Ajouter un étudiant')
@section('page_title', 'Ajouter un étudiant')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informations de l'étudiant</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.store-student') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autofocus>
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required>
                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Adresse e-mail</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="telephone" class="form-label">Téléphone (optionnel)</label>
                                <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}">
                                @error('telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="niveau_id" class="form-label">Niveau</label>
                                <select id="niveau_id" class="form-select @error('niveau_id') is-invalid @enderror" name="niveau_id" required>
                                    <option value="">Sélectionnez un niveau</option>
                                    @foreach($niveaux as $niveau)
                                        <option value="{{ $niveau->id }}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>{{ $niveau->nom ?? 'Niveau ' . $niveau->id }}</option>
                                    @endforeach
                                </select>
                                @error('niveau_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="groupe_id" class="form-label">Groupe</label>
                                <select id="groupe_id" class="form-select @error('groupe_id') is-invalid @enderror" name="groupe_id">
                                    <option value="">Sélectionnez d'abord un niveau</option>
                                </select>
                                @error('groupe_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="filiere" class="form-label">Filière</label>
                                <input id="filiere" type="text" class="form-control @error('filiere') is-invalid @enderror" name="filiere" value="{{ old('filiere') }}">
                                <small class="text-muted">Exemple: Sciences Mathématiques, Lettres Modernes, etc.</small>
                                @error('filiere')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="annee_scolaire" class="form-label">Année scolaire</label>
                                <input id="annee_scolaire" type="text" class="form-control @error('annee_scolaire') is-invalid @enderror" name="annee_scolaire" value="{{ old('annee_scolaire') ?? date('Y') . '-' . (date('Y')+1) }}">
                                <small class="text-muted">Format: AAAA-AAAA (ex: 2025-2026)</small>
                                @error('annee_scolaire')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Enregistrer l'étudiant
                                </button>
                                <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Retour
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const niveauSelect = document.getElementById('niveau_id');
        const groupeSelect = document.getElementById('groupe_id');

        // Charger les groupes en fonction du niveau sélectionné
        niveauSelect.addEventListener('change', function() {
            const niveauId = this.value;
            if (niveauId) {
                // Réinitialiser le select des groupes
                groupeSelect.innerHTML = '<option value="">Chargement des groupes...</option>';
                
                // Appel AJAX pour récupérer les groupes du niveau
                fetch(`/api/niveaux/${niveauId}/groupes`)
                    .then(response => response.json())
                    .then(data => {
                        // Réinitialiser le select des groupes
                        groupeSelect.innerHTML = '<option value="">Sélectionnez un groupe</option>';
                        
                        // Ajouter les options de groupe
                        data.forEach(groupe => {
                            const option = document.createElement('option');
                            option.value = groupe.id;
                            option.textContent = groupe.nom;
                            groupeSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des groupes:', error);
                        groupeSelect.innerHTML = '<option value="">Erreur lors du chargement des groupes</option>';
                    });
            } else {
                groupeSelect.innerHTML = '<option value="">Sélectionnez d'abord un niveau</option>';
            }
        });

        // Déclencher l'événement change si un niveau est déjà sélectionné (en cas d'erreur de validation)
        if (niveauSelect.value) {
            niveauSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection
