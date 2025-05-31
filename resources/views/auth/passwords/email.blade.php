@extends('layouts.simple')
@section('title', 'Réinitialisation du mot de passe')
@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="bg-white rounded-4 shadow-sm p-4">
                    <div class="text-center mb-4">
                        <h1 class="fw-bold gradient-text mb-2" style="font-size:2rem;">Réinitialiser le mot de passe</h1>
                        <p class="text-muted">Saisissez votre adresse email pour recevoir un lien de réinitialisation.</p>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input id="email" type="email" class="form-control rounded-pill px-4 border-2 @error('email') is-invalid @enderror" style="border-color:#7B57F9;" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="main-btn btn px-5 py-2 rounded-pill d-flex align-items-center gap-2 mx-auto mt-3" style="font-size:1.1rem;">
                            <i class="bi bi-envelope-arrow-up"></i> Envoyer le lien
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 