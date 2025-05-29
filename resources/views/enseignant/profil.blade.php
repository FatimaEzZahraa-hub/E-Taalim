@extends('layouts.app')

@section('title', 'Profil Enseignant')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="profile-container" style="background-color: #8668FF; padding: 40px; border-radius: 10px; position: relative; overflow: hidden;">
                        <!-- Éléments décoratifs (cercles) -->
                        <div class="circle-decoration-1" style="position: absolute; width: 150px; height: 150px; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 50%; top: -50px; left: -50px;"></div>
                        <div class="circle-decoration-2" style="position: absolute; width: 200px; height: 200px; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 50%; bottom: -100px; right: -50px;"></div>
                        
                        <div class="row">
                            <div class="col-12 text-center mb-4">
                                <h1 class="text-white mb-4">Mon Profil</h1>
                                
                                <div class="profile-avatar bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                    @if(isset($enseignant) && $enseignant->photo)
                                        <img src="{{ asset('storage/photos/' . $enseignant->photo) }}" alt="Photo de profil" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#8668FF" class="bi bi-person" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="text-white mb-2">Nom</label>
                                <input type="text" class="form-control bg-light bg-opacity-25 text-white border-0 rounded-pill" id="nom" name="nom" placeholder="Entrer votre nom" value="{{ isset($enseignant) ? $enseignant->nom : '' }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="text-white mb-2">Prénom</label>
                                <input type="text" class="form-control bg-light bg-opacity-25 text-white border-0 rounded-pill" id="prenom" name="prenom" placeholder="Entrer votre Prénom" value="{{ isset($enseignant) ? $enseignant->prenom : '' }}">
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="code" class="text-white mb-2">Code</label>
                                <input type="text" class="form-control bg-light bg-opacity-25 text-white border-0 rounded-pill" id="code" name="code" placeholder="Entrer votre Code" value="{{ isset($enseignant) ? $enseignant->code : '' }}">
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="email" class="text-white mb-2">Email</label>
                                <input type="email" class="form-control bg-light bg-opacity-25 text-white border-0 rounded-pill" id="email" name="email" placeholder="Entrer votre Email" value="{{ isset($enseignant) && isset($enseignant->utilisateur) ? $enseignant->utilisateur->email : '' }}">
                            </div>
                            
                            <div class="col-12 mb-4">
                                <label for="password" class="text-white mb-2">Mot de passe</label>
                                <input type="password" class="form-control bg-light bg-opacity-25 text-white border-0 rounded-pill" id="password" name="password" placeholder="Entrer votre Mot de passe">
                            </div>
                            
                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-light rounded-pill px-4">Annuler</button>
                                <button type="submit" class="btn btn-light rounded-pill px-4">Confirmer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
    
    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.3) !important;
        color: white;
        box-shadow: none;
    }
    
    .rounded-4 {
        border-radius: 1rem !important;
    }
    
    .btn-light {
        font-weight: 500;
    }
    
    .btn-light:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
