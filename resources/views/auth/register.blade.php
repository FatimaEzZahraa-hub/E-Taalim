@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
<<<<<<< HEAD
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Inscription Enseignant</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom" autofocus>
                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom">
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
=======
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
>>>>>>> origin/interface-admin
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
<<<<<<< HEAD
                        
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Numéro de Téléphone</label>
                            <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" autocomplete="telephone">
                            @error('telephone')
=======

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
>>>>>>> origin/interface-admin
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
<<<<<<< HEAD
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mot_de_passe" class="form-label">Mot de Passe</label>
                                <input id="mot_de_passe" type="password" class="form-control @error('mot_de_passe') is-invalid @enderror" name="mot_de_passe" required autocomplete="new-password">
                                @error('mot_de_passe')
=======

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
>>>>>>> origin/interface-admin
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
<<<<<<< HEAD
                            
                            <div class="col-md-6">
                                <label for="mot_de_passe_confirmation" class="form-label">Confirmer le Mot de Passe</label>
                                <input id="mot_de_passe_confirmation" type="password" class="form-control" name="mot_de_passe_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
=======

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

>>>>>>> origin/interface-admin
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                S'inscrire
                            </button>
                        </div>
                    </form>
                </div>
<<<<<<< HEAD
                <div class="card-footer text-center py-3">
                    <p class="mb-0">Vous avez déjà un compte ? <a href="{{ route('login') }}" class="text-decoration-none">Se Connecter</a></p>
=======
                <div class="card-footer text-center">
                    <p class="mb-0">Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
>>>>>>> origin/interface-admin
                </div>
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD
=======

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
>>>>>>> origin/interface-admin
@endsection
