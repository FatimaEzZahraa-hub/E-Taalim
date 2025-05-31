@extends('layouts.simple')
@section('title', 'Politique de confidentialité')
@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold gradient-text mb-2" style="font-size:2.2rem;">Politique de confidentialité</h1>
            <p class="text-muted" style="font-size:1.1rem;">Découvrez comment E-Taalim protège vos données personnelles et respecte votre vie privée.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <div class="mb-4 d-flex align-items-start gap-3">
                        <span class="fs-2 mt-1" style="color:#7B57F9;"><i class="bi bi-shield-lock"></i></span>
                        <div>
                            <h5 class="fw-bold mb-2">Collecte des données</h5>
                            <p class="text-muted mb-0">Nous collectons uniquement les données nécessaires à la gestion de votre compte et à l'amélioration de nos services. Vos informations ne sont jamais partagées sans votre consentement.</p>
                        </div>
                    </div>
                    <div class="mb-4 d-flex align-items-start gap-3">
                        <span class="fs-2 mt-1" style="color:#7B57F9;"><i class="bi bi-gear"></i></span>
                        <div>
                            <h5 class="fw-bold mb-2">Utilisation des données</h5>
                            <p class="text-muted mb-0">Vos données sont utilisées pour personnaliser votre expérience, assurer la sécurité de la plateforme et vous fournir un service optimal.</p>
                        </div>
                    </div>
                    <div class="mb-4 d-flex align-items-start gap-3">
                        <span class="fs-2 mt-1" style="color:#7B57F9;"><i class="bi bi-person-check"></i></span>
                        <div>
                            <h5 class="fw-bold mb-2">Droits des utilisateurs</h5>
                            <p class="text-muted mb-0">Vous pouvez à tout moment accéder, modifier ou supprimer vos données personnelles en contactant notre équipe via la page de contact.</p>
                        </div>
                    </div>
                    <div class="mb-2 d-flex align-items-start gap-3">
                        <span class="fs-2 mt-1" style="color:#7B57F9;"><i class="bi bi-lock"></i></span>
                        <div>
                            <h5 class="fw-bold mb-2">Sécurité</h5>
                            <p class="text-muted mb-0">Nous mettons en œuvre des mesures de sécurité avancées pour protéger vos informations contre tout accès non autorisé.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 