@extends('layouts.admin')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier un utilisateur</h1>
        <a href="{{ route('admin.users') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
        </a>
    </div>

    <!-- Affichage des messages flash -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Affichage des messages d'erreur -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulaire de modification -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $user->role === 'etudiant' ? 'Modifier un étudiant' : 'Modifier un enseignant' }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nom">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $user->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prenom">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $metaData['prenom'] ?? '') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $metaData['telephone'] ?? '') }}">
                        </div>
                    </div>
                </div>

                @if ($user->role === 'student')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="niveau_id">Niveau <span class="text-danger">*</span></label>
                            <select class="form-control" id="niveau_id" name="niveau_id" required>
                                <option value="">Sélectionner un niveau</option>
                                @foreach ($niveaux as $niveau)
                                <option value="{{ $niveau->id }}" {{ (old('niveau_id', $metaData['niveau_id'] ?? '') == $niveau->id) ? 'selected' : '' }}>
                                    {{ $niveau->nom }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @endif

                @if ($user->role === 'teacher')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="specialite">Spécialité <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="specialite" name="specialite" value="{{ old('specialite', $metaData['specialite'] ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="grade">Grade <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="grade" name="grade" value="{{ old('grade', $metaData['grade'] ?? '') }}" required>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- SweetAlert2 pour des alertes modernes et attrayantes -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Afficher un message de succès si présent dans l'URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        Swal.fire({
            title: 'Succès!',
            text: 'Les modifications ont été enregistrées avec succès.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    }
    
    // Script pour la validation côté client
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Validation du nom
            const nom = document.getElementById('nom');
            if (nom.value.trim() === '') {
                isValid = false;
                nom.classList.add('is-invalid');
            } else {
                nom.classList.remove('is-invalid');
            }
            
            // Validation du prénom
            const prenom = document.getElementById('prenom');
            if (prenom.value.trim() === '') {
                isValid = false;
                prenom.classList.add('is-invalid');
            } else {
                prenom.classList.remove('is-invalid');
            }
            
            // Validation de l'email
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                isValid = false;
                email.classList.add('is-invalid');
            } else {
                email.classList.remove('is-invalid');
            }
            
            // Validation du niveau pour les étudiants
            const niveauSelect = document.getElementById('niveau_id');
            if (niveauSelect && niveauSelect.value === '') {
                isValid = false;
                niveauSelect.classList.add('is-invalid');
            } else if (niveauSelect) {
                niveauSelect.classList.remove('is-invalid');
            }
            
            // Validation de la spécialité pour les enseignants
            const specialite = document.getElementById('specialite');
            if (specialite && specialite.value.trim() === '') {
                isValid = false;
                specialite.classList.add('is-invalid');
            } else if (specialite) {
                specialite.classList.remove('is-invalid');
            }
            
            // Validation du grade pour les enseignants
            const grade = document.getElementById('grade');
            if (grade && grade.value.trim() === '') {
                isValid = false;
                grade.classList.add('is-invalid');
            } else if (grade) {
                grade.classList.remove('is-invalid');
            }
            
            if (!isValid) {
                event.preventDefault();
                // Afficher un message d'erreur
                Swal.fire({
                    title: 'Erreur de validation',
                    text: 'Veuillez corriger les erreurs dans le formulaire.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
@endsection
