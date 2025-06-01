@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Connexion</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="mot_de_passe" class="form-label">Mot de Passe</label>
                            <input id="mot_de_passe" type="password" class="form-control @error('mot_de_passe') is-invalid @enderror" name="mot_de_passe" required autocomplete="current-password">
                            @error('mot_de_passe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Se Connecter
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <p class="mb-0">Vous n'avez pas de compte ? <a href="{{ route('register') }}" class="text-decoration-none">S'inscrire</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
