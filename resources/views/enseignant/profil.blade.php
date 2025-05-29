@extends('layouts.app')

@section('title', 'Profil Enseignant')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mon Profil</h1>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    @if($enseignant->photo)
                        <img src="{{ asset('storage/photos/' . $enseignant->photo) }}" alt="Photo de profil" class="rounded-circle img-thumbnail mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px; font-size: 4rem;">
                            {{ strtoupper(substr($enseignant->prenom, 0, 1)) }}{{ strtoupper(substr($enseignant->nom, 0, 1)) }}
                        </div>
                    @endif
                    
                    <h4 class="mb-0">{{ $enseignant->prenom }} {{ $enseignant->nom }}</h4>
                    <p class="text-muted">Enseignant</p>
                    
                    <div class="mt-3">
                        <p class="mb-1"><i class="fas fa-envelope me-2"></i> {{ $enseignant->utilisateur->email }}</p>
                        @if($enseignant->telephone)
                            <p class="mb-1"><i class="fas fa-phone me-2"></i> {{ $enseignant->telephone }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Modifier mon Profil</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('enseignant.profil.update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom', $enseignant->prenom) }}" required>
                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom', $enseignant->nom) }}" required>
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input id="email" type="email" class="form-control" value="{{ $enseignant->utilisateur->email }}" disabled>
                            <small class="form-text text-muted">L'adresse email ne peut pas être modifiée.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Numéro de Téléphone</label>
                            <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone', $enseignant->telephone) }}">
                            @error('telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo de Profil</label>
                            <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo">
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Formats acceptés : JPG, PNG. Taille maximale : 2 Mo.</small>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Mettre à jour le Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistiques</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="h1 mb-0 font-weight-bold text-primary">
                                {{ $enseignant->cours->count() }}
                            </div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Cours</div>
                        </div>
                        
                        <div class="col-md-4 text-center mb-3">
                            <div class="h1 mb-0 font-weight-bold text-success">
                                @php
                                    $travauxCount = 0;
                                    foreach($enseignant->cours as $c) {
                                        $travauxCount += $c->travauxDevoirs->count();
                                    }
                                    echo $travauxCount;
                                @endphp
                            </div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Travaux & Devoirs</div>
                        </div>
                        
                        <div class="col-md-4 text-center mb-3">
                            <div class="h1 mb-0 font-weight-bold text-info">
                                @php
                                    $examensCount = 0;
                                    foreach($enseignant->cours as $c) {
                                        $examensCount += $c->examens->count();
                                    }
                                    echo $examensCount;
                                @endphp
                            </div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Examens</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
