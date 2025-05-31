@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center bg-white">
    <div class="row w-100 justify-content-center align-items-center" style="min-height:80vh;">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="shadow rounded-4 bg-white p-0 d-flex flex-column flex-md-row overflow-hidden" style="max-width:900px; min-height:380px; margin:auto;">
                <!-- Formulaire -->
                <div class="flex-fill p-5 d-flex flex-column justify-content-center" style="min-width:0; max-width:440px;">
                    <h2 class="fw-bold mb-2" style="font-size:2rem; letter-spacing:-1px; color:#222;">Entrez votre email et mot de passe</h2>
                    <p class="text-muted mb-4" style="font-size:1.08rem;">Besoin d'un compte? <a href="{{ route('contact.admin') }}" style="color:#7B57F9;font-weight:600;text-decoration:none;">Contactez l'administration</a></p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST" class="mb-2">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input id="email" name="email" type="email" required value="{{ old('email') }}" class="form-control form-control-lg rounded-pill px-4" placeholder="deniel123@gmail.com" style="border:1.5px solid #7B57F9; background: #fff; box-shadow:none; font-size:1.08rem;">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Mot de passe</label>
                            <input id="password" name="password" type="password" required class="form-control form-control-lg rounded-pill px-4" placeholder="••••••••" style="border:1.5px solid #7B57F9; background: #fff; box-shadow:none; font-size:1.08rem;">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check d-flex align-items-center" style="gap:0.5rem;">
                                <input class="form-check-input rounded-circle border-2 border-primary" type="checkbox" id="remember-me" name="remember" style="width:1.1em;height:1.1em;">
                                <label class="form-check-label" for="remember-me" style="font-size:0.97rem;">Se souvenir de moi</label>
                            </div>
                            <a href="{{ route('password.request') }}" style="color:#7B57F9;font-weight:600;text-decoration:none; font-size:0.97rem;">Mot de passe oublié?</a>
                        </div>
                        <button type="submit" class="main-btn btn w-100 rounded-pill fw-bold" style="font-size:1.08rem; padding:0.7rem 0; letter-spacing:0.5px;">Se connecter</button>
                    </form>
                </div>
                <!-- Illustration -->
                <div class="flex-fill d-none d-md-block position-relative p-0" style="min-width:0; max-width:460px; height:100%;">
                    <img src="{{ asset('images/Login.png') }}" alt="Illustration" style="object-fit:cover; object-position:center right; width:100%; height:100%; min-height:380px; display:block;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 