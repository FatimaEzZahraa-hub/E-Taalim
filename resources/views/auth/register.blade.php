@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Inscription</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autofocus>
                            @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required>
                            @error('prenom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                                <option value="">Sélectionnez un rôle</option>
                                <option value="etudiant" {{ old('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                                <option value="enseignant" {{ old('role') == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div id="student-fields" style="display: {{ old('role') == 'etudiant' ? 'block' : 'none' }}">
                            <div class="mb-3">
                                <label for="niveau_id" class="form-label">Niveau</label>
                                <select id="niveau_id" class="form-select @error('niveau_id') is-invalid @enderror" name="niveau_id">
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

                            <div class="mb-3">
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

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                S'inscrire
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const studentFields = document.getElementById('student-fields');
        const niveauSelect = document.getElementById('niveau_id');
        const groupeSelect = document.getElementById('groupe_id');

        // Afficher/masquer les champs spécifiques aux étudiants
        roleSelect.addEventListener('change', function() {
            if (this.value === 'etudiant') {
                studentFields.style.display = 'block';
            } else {
                studentFields.style.display = 'none';
            }
        });

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
    });
</script>
@endsection
@endsection
