@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="position-relative mx-auto mb-3" style="width: 120px; height: 120px;">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; overflow: hidden;">
                            @if ($etudiant->photo)
                                <img src="{{ asset($etudiant->photo) }}" alt="Photo de profil" class="img-fluid">
                            @else
                                <i class="bi bi-person text-secondary" style="font-size: 4rem;"></i>
                            @endif
                        </div>
                        <button class="btn btn-sm rounded-circle position-absolute bottom-0 end-0" style="background-color: #8668FF; color: white;" data-bs-toggle="modal" data-bs-target="#photoModal">
                            <i class="bi bi-camera"></i>
                        </button>
                    </div>
                    <h3 class="mb-1">{{ $etudiant->prenom }} {{ $etudiant->nom }}</h3>
                    <p class="text-muted mb-3">{{ $etudiant->niveau }} - {{ $etudiant->filiere }}</p>
                    <div class="d-flex justify-content-around mb-3">
                        <div class="text-center">
                            <h4 class="mb-0">{{ $stats['cours'] ?? 0 }}</h4>
                            <small class="text-muted">Cours</small>
                        </div>
                        <div class="text-center">
                            <h4 class="mb-0">{{ $stats['moyenne'] ?? '0.00' }}</h4>
                            <small class="text-muted">Moyenne</small>
                        </div>
                        <div class="text-center">
                            <h4 class="mb-0">{{ $stats['assiduite'] ?? '0%' }}</h4>
                            <small class="text-muted">Assiduitu00e9</small>
                        </div>
                    </div>
                    <a href="{{ route('etudiant.messages.create') }}" class="btn btn-primary w-100" style="background-color: #8668FF; border-color: #8668FF;">
                        <i class="bi bi-envelope me-1"></i> Contacter mon responsable
                    </a>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Informations de contact</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-2 d-flex align-items-center">
                            <i class="bi bi-envelope me-3 text-muted"></i>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span>{{ $etudiant->email }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 d-flex align-items-center">
                            <i class="bi bi-phone me-3 text-muted"></i>
                            <div>
                                <small class="text-muted d-block">Tu00e9lu00e9phone</small>
                                <span>{{ $etudiant->telephone ?? 'Non renseignu00e9' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 d-flex align-items-center">
                            <i class="bi bi-geo-alt me-3 text-muted"></i>
                            <div>
                                <small class="text-muted d-block">Adresse</small>
                                <span>{{ $etudiant->adresse ?? 'Non renseignu00e9e' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 d-flex align-items-center">
                            <i class="bi bi-person-badge me-3 text-muted"></i>
                            <div>
                                <small class="text-muted d-block">Numu00e9ro u00e9tudiant</small>
                                <span>{{ $etudiant->matricule }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="infos-tab" data-bs-toggle="tab" data-bs-target="#infos" type="button" role="tab" aria-controls="infos" aria-selected="true">Informations personnelles</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="securite-tab" data-bs-toggle="tab" data-bs-target="#securite" type="button" role="tab" aria-controls="securite" aria-selected="false">Su00e9curitu00e9</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="parametres-tab" data-bs-toggle="tab" data-bs-target="#parametres" type="button" role="tab" aria-controls="parametres" aria-selected="false">Paramu00e8tres</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="profileTabsContent">
                        <div class="tab-pane fade show active" id="infos" role="tabpanel" aria-labelledby="infos-tab">
                            <form action="{{ route('etudiant.profil.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nom" class="form-label">Nom</label>
                                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $etudiant->nom) }}">
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="prenom" class="form-label">Pru00e9nom</label>
                                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}">
                                        @error('prenom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $etudiant->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telephone" class="form-label">Tu00e9lu00e9phone</label>
                                        <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $etudiant->telephone) }}">
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="adresse" class="form-label">Adresse</label>
                                    <textarea class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" rows="2">{{ old('adresse', $etudiant->adresse) }}</textarea>
                                    @error('adresse')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="date_naissance" class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $etudiant->date_naissance) }}">
                                        @error('date_naissance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="lieu_naissance" class="form-label">Lieu de naissance</label>
                                        <input type="text" class="form-control @error('lieu_naissance') is-invalid @enderror" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $etudiant->lieu_naissance) }}">
                                        @error('lieu_naissance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="nationalite" class="form-label">Nationalitu00e9</label>
                                        <input type="text" class="form-control @error('nationalite') is-invalid @enderror" id="nationalite" name="nationalite" value="{{ old('nationalite', $etudiant->nationalite) }}">
                                        @error('nationalite')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="contact_urgence_nom" class="form-label">Contact d'urgence - Nom</label>
                                        <input type="text" class="form-control @error('contact_urgence_nom') is-invalid @enderror" id="contact_urgence_nom" name="contact_urgence_nom" value="{{ old('contact_urgence_nom', $etudiant->contact_urgence_nom) }}">
                                        @error('contact_urgence_nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact_urgence_telephone" class="form-label">Contact d'urgence - Tu00e9lu00e9phone</label>
                                        <input type="tel" class="form-control @error('contact_urgence_telephone') is-invalid @enderror" id="contact_urgence_telephone" name="contact_urgence_telephone" value="{{ old('contact_urgence_telephone', $etudiant->contact_urgence_telephone) }}">
                                        @error('contact_urgence_telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                                        <i class="bi bi-save me-1"></i> Enregistrer les modifications
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="securite" role="tabpanel" aria-labelledby="securite-tab">
                            <form action="{{ route('etudiant.profil.updatePassword') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nouveau mot de passe</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Le mot de passe doit contenir au moins 8 caractu00e8res, dont une majuscule, un chiffre et un caractu00e8re spu00e9cial.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                                        <i class="bi bi-lock me-1"></i> Modifier le mot de passe
                                    </button>
                                </div>
                            </form>
                            
                            <hr class="my-4">
                            
                            <h5 class="mb-3">Historique de connexion</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Appareil</th>
                                            <th>Localisation</th>
                                            <th>IP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($connexions as $connexion)
                                            <tr>
                                                <td>{{ $connexion->date->format('d/m/Y H:i') }}</td>
                                                <td>{{ $connexion->appareil }}</td>
                                                <td>{{ $connexion->localisation }}</td>
                                                <td>{{ $connexion->ip }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Aucun historique de connexion disponible</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="parametres" role="tabpanel" aria-labelledby="parametres-tab">
                            <form action="{{ route('etudiant.profil.updateSettings') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <h5 class="mb-3">Notifications</h5>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notifications_email" name="notifications_email" {{ $etudiant->settings->notifications_email ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notifications_email">Recevoir des notifications par email</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notifications_devoirs" name="notifications_devoirs" {{ $etudiant->settings->notifications_devoirs ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notifications_devoirs">Notifications pour les nouveaux devoirs</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notifications_examens" name="notifications_examens" {{ $etudiant->settings->notifications_examens ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notifications_examens">Notifications pour les examens</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notifications_messages" name="notifications_messages" {{ $etudiant->settings->notifications_messages ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notifications_messages">Notifications pour les nouveaux messages</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notifications_notes" name="notifications_notes" {{ $etudiant->settings->notifications_notes ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notifications_notes">Notifications pour les nouvelles notes</label>
                                    </div>
                                </div>
                                
                                <h5 class="mb-3 mt-4">Pru00e9fu00e9rences d'affichage</h5>
                                <div class="mb-3">
                                    <label for="langue" class="form-label">Langue</label>
                                    <select class="form-select" id="langue" name="langue">
                                        <option value="fr" {{ $etudiant->settings->langue == 'fr' ? 'selected' : '' }}>Franu00e7ais</option>
                                        <option value="en" {{ $etudiant->settings->langue == 'en' ? 'selected' : '' }}>English</option>
                                        <option value="ar" {{ $etudiant->settings->langue == 'ar' ? 'selected' : '' }}>u0627u0644u0639u0631u0628u064au0629</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="theme" class="form-label">Thu00e8me</label>
                                    <select class="form-select" id="theme" name="theme">
                                        <option value="light" {{ $etudiant->settings->theme == 'light' ? 'selected' : '' }}>Clair</option>
                                        <option value="dark" {{ $etudiant->settings->theme == 'dark' ? 'selected' : '' }}>Sombre</option>
                                        <option value="auto" {{ $etudiant->settings->theme == 'auto' ? 'selected' : '' }}>Automatique (selon systu00e8me)</option>
                                    </select>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" style="background-color: #8668FF; border-color: #8668FF;">
                                        <i class="bi bi-check-circle me-1"></i> Enregistrer les pru00e9fu00e9rences
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Progression acadu00e9mique</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Semestre en cours</h6>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $etudiant->progression }}%; background-color: #8668FF;" aria-valuenow="{{ $etudiant->progression }}" aria-valuemin="0" aria-valuemax="100">{{ $etudiant->progression }}%</div>
                    </div>
                    
                    <div class="table-responsive mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Enseignant</th>
                                    <th>Moyenne</th>
                                    <th>Progression</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($modules as $module)
                                    <tr>
                                        <td>{{ $module->nom }}</td>
                                        <td>{{ $module->enseignant }}</td>
                                        <td>
                                            <span class="badge {{ $module->moyenne >= 10 ? 'bg-success' : 'bg-danger' }}">{{ $module->moyenne }}/20</span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $module->progression }}%; background-color: #8668FF;" aria-valuenow="{{ $module->progression }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Aucun module pour ce semestre</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Photo -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #8668FF; color: white;">
                <h5 class="modal-title" id="photoModalLabel">Modifier ma photo de profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('etudiant.profil.updatePhoto') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="photo" class="form-label">Su00e9lectionner une nouvelle photo</label>
                        <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                        <div class="form-text">La photo doit u00eatre au format JPEG, PNG ou GIF et ne pas du00e9passer 2 Mo.</div>
                    </div>
                    <div class="text-center mt-4" id="preview-container" style="display: none;">
                        <h6>Aperu00e7u</h6>
                        <img id="preview-image" src="#" alt="Aperu00e7u de la photo" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('photoForm').submit()" style="background-color: #8668FF; border-color: #8668FF;">
                    <i class="bi bi-save me-1"></i> Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Aperu00e7u de l'image
        const photoInput = document.getElementById('photo');
        const previewImage = document.getElementById('preview-image');
        const previewContainer = document.getElementById('preview-container');
        
        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush
@endsection
