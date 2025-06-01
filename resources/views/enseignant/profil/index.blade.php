@extends('layouts.app')

@section('title', 'Profil')

@section('styles')
<style>
    .profile-card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .profile-header {
        background-color: #8668FF;
        padding: 30px;
        text-align: center;
        color: white;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid white;
        margin: 0 auto 15px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .profile-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .profile-role {
        font-size: 0.9rem;
        opacity: 0.8;
    }
    
    .profile-body {
        padding: 30px;
        background-color: white;
    }
    
    .info-item {
        margin-bottom: 20px;
    }
    
    .info-label {
        font-weight: 600;
        color: #8668FF;
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    
    .info-label i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }
    
    .info-value {
        padding-left: 30px;
        color: #555;
    }
    
    .form-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        padding: 25px;
        margin-bottom: 25px;
    }
    
    .form-card .card-title {
        color: #8668FF;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
    }
    
    .form-control:focus {
        border-color: #8668FF;
        box-shadow: 0 0 0 0.25rem rgba(134, 104, 255, 0.25);
    }
    
    .btn-primary {
        background-color: #8668FF;
        border-color: #8668FF;
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 600;
    }
    
    .btn-primary:hover {
        background-color: #7559e8;
        border-color: #7559e8;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(134, 104, 255, 0.3);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Colonne de gauche - Informations de profil -->
        <div class="col-md-4">
            <div class="profile-card mb-4">
                <div class="profile-header">
                    <div class="profile-avatar">
                        @if(isset($user->photo) && $user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-white text-primary w-100 h-100" style="font-size: 2.5rem;">
                                {{ strtoupper(substr($user->prenom ?? 'U', 0, 1)) }}{{ strtoupper(substr($user->nom ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h4 class="profile-name">{{ $user->prenom ?? 'Prénom' }} {{ $user->nom ?? 'Nom' }}</h4>
                    <div class="profile-role">Enseignant</div>
                </div>
                <div class="profile-body">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-envelope"></i> Adresse Email
                        </div>
                        <div class="info-value">{{ $user->email ?? 'email@example.com' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-telephone"></i> Téléphone
                        </div>
                        <div class="info-value">{{ $user->telephone ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi bi-shield-check"></i> Rôle
                        </div>
                        <div class="info-value">
                            <span class="badge bg-primary">Enseignant</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Colonne de droite - Modification du profil -->
        <div class="col-md-8">
            <div class="form-card mb-4">
                <h5 class="card-title">
                    <i class="bi bi-pencil-square me-2"></i>Modifier le profil
                </h5>
                <form action="{{ route('enseignant.profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">Prénom</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $user->prenom ?? '' }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ $user->nom ?? '' }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? '' }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $user->telephone ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="photo" class="form-label">Photo de profil</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                        <small class="text-muted">Formats acceptés: JPG, PNG. Max: 2Mo</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Enregistrer les modifications
                    </button>
                </form>
            </div>
            
            <div class="form-card">
                <h5 class="card-title">
                    <i class="bi bi-key me-2"></i>Changer de mot de passe
                </h5>
                <form action="{{ route('enseignant.profil.password') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-key me-1"></i> Changer le mot de passe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
