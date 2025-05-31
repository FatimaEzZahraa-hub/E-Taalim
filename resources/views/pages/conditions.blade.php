@extends('layouts.simple')
@section('title', 'Conditions d\'utilisation')
@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold gradient-text mb-2" style="font-size:2.2rem;">Conditions d'utilisation</h1>
            <p class="text-muted" style="font-size:1.1rem;">Veuillez lire attentivement les conditions d'utilisation de la plateforme E-Taalim.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <div class="mb-4 d-flex align-items-start gap-3">
                        <span class="fs-2 mt-1" style="color:#7B57F9;"><i class="bi bi-person-lock"></i></span>
                        <div>
                            <h5 class="fw-bold mb-2">Accès à la plateforme</h5>
                            <p class="text-muted mb-0">L'accès à E-Taalim est réservé aux utilisateurs disposant d'un compte créé par l'administration. Toute tentative d'accès non autorisé est strictement interdite.</p>
                        </div>
                    </div>
                    <div class="mb-4 d-flex align-items-start gap-3">
                        <span class="fs-2 mt-1" style="color:#7B57F9;"><i class="bi bi-people"></i></span>
                        <div>
                            <h5 class="fw-bold mb-2">Utilisation des services</h5>
                            <p class="text-muted mb-0">Les utilisateurs s'engagent à utiliser la plateforme dans le respect des lois en vigueur et des règles de bonne conduite.</p>
                        </div>
                    </div>
                    <div class="mb-4 d-flex align-items-start gap-3">
                        <span class="fs-2 mt-1" style="color:#7B57F9;"><i class="bi bi-c-circle"></i></span>
                        <div>
                            <h5 class="fw-bold mb-2">Propriété intellectuelle</h5>
                            <p class="text-muted mb-0">Tous les contenus présents sur E-Taalim sont protégés par le droit d'auteur. Toute reproduction ou diffusion sans autorisation est interdite.</p>
                        </div>
                    </div>
                    <div class="mb-2 d-flex align-items-start gap-3">
                        <span class="fs-2 mt-1" style="color:#7B57F9;"><i class="bi bi-pencil-square"></i></span>
                        <div>
                            <h5 class="fw-bold mb-2">Modification des conditions</h5>
                            <p class="text-muted mb-0">E-Taalim se réserve le droit de modifier à tout moment les présentes conditions. Les utilisateurs seront informés de toute modification importante.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 