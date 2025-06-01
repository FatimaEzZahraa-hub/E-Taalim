@extends('layouts.admin')

@section('title', 'Mon Profil')

@section('page_title', 'Mon Profil')

@section('content')
<div class="container-fluid" style="max-width: 1600px;">
    <div class="row">
        <!-- Colonne de gauche - Informations de profil -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations Personnelles</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @php
                            // Vérifier si meta_data est déjà un objet ou une chaîne JSON
                            if (is_string($admin->meta_data)) {
                                $metaData = json_decode($admin->meta_data, true) ?: [];
                            } elseif (is_object($admin->meta_data)) {
                                $metaData = (array) $admin->meta_data;
                            } else {
                                $metaData = [];
                            }
                            $photo = $metaData['photo'] ?? null;
                        @endphp
                        @if($photo)
                            <img src="{{ asset('storage/' . $photo) }}" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="Photo de profil">
                        @else
                            <div class="mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; font-size: 3rem;">
                                {{ strtoupper(substr($metaData['prenom'] ?? '', 0, 1)) }}{{ strtoupper(substr($metaData['nom'] ?? '', 0, 1)) }}
                            </div>
                        @endif
                        <h5 class="card-title">{{ $metaData['prenom'] ?? '' }} {{ $metaData['nom'] ?? '' }}</h5>
                        <p class="text-muted">Administrateur</p>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                <span class="fw-bold">Adresse Email</span>
                            </div>
                            <div class="text-muted ps-4">{{ ObjHelper::prop($admin, 'email') }}</div>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-phone me-2 text-primary"></i>
                                <span class="fw-bold">Téléphone</span>
                            </div>
                            <div class="text-muted ps-4">{{ ObjHelper::prop($admin, 'telephone', 'Non renseigné') }}</div>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-user-shield me-2 text-primary"></i>
                                <span class="fw-bold">Rôle</span>
                            </div>
                            <div class="ps-4"><span class="badge bg-primary">Administrateur</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Colonne de droite - Modification du profil -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Modifier le profil</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="prenom" class="form-label"><i class="fas fa-user me-2"></i> Prénom</label>
                                <input type="text" class="form-control form-control-lg" id="prenom" name="prenom" value="{{ ObjHelper::prop($admin, 'prenom') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nom" class="form-label"><i class="fas fa-user me-2"></i> Nom</label>
                                <input type="text" class="form-control form-control-lg" id="nom" name="nom" value="{{ ObjHelper::prop($admin, 'nom') }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i> Adresse email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ ObjHelper::prop($admin, 'email') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telephone" class="form-label"><i class="fas fa-phone me-2"></i> Téléphone</label>
                            <input type="text" class="form-control form-control-lg" id="telephone" name="telephone" value="{{ ObjHelper::prop($admin, 'telephone', '') }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="photo" class="form-label"><i class="fas fa-camera me-2"></i> Photo de profil</label>
                            <input type="file" class="form-control form-control-lg" id="photo" name="photo" accept="image/*">
                            <small class="text-muted">Formats acceptés: JPG, PNG. Max: 2Mo</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-1"></i> Enregistrer les modifications
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Changer de mot de passe</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label"><i class="fas fa-lock me-2"></i> Mot de passe actuel <small class="text-muted">(temporairement optionnel)</small></label>
                            <input type="password" class="form-control form-control-lg" id="current_password" name="current_password">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="fas fa-key me-2"></i> Nouveau mot de passe</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label"><i class="fas fa-check-circle me-2"></i> Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-key me-1"></i> Changer le mot de passe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
