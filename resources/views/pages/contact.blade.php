@extends('layouts.simple')
@section('title', 'Contactez-nous')
@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold gradient-text mb-2" style="font-size:2.2rem;">Contactez-nous</h1>
            <p class="text-muted" style="font-size:1.1rem;">Notre équipe est à votre disposition pour répondre à toutes vos questions sur la plateforme.</p>
        </div>
        <div class="row justify-content-center g-4">
            <!-- Infos de contact -->
            <div class="col-lg-5">
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4 mb-lg-0 h-100">
                    <h4 class="fw-bold mb-4" style="color:#7B57F9;">Informations de contact</h4>
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3 bg-light">
                        <span class="fs-2" style="color:#7B57F9;"><i class="bi bi-telephone"></i></span>
                        <div>
                            <div class="fw-semibold">Téléphone</div>
                            <div class="text-muted small">+212 600 000 000</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3 bg-light">
                        <span class="fs-2" style="color:#7B57F9;"><i class="bi bi-envelope"></i></span>
                        <div>
                            <div class="fw-semibold">Email</div>
                            <div class="text-muted small">e-taalim@gmail.com</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Formulaire -->
            <div class="col-lg-7">
                <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                    <h4 class="fw-bold mb-4" style="color:#7B57F9;">Envoyer un message</h4>
                    <form method="POST" action="#">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control rounded-pill px-4 border-2" style="border-color:#7B57F9;" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control rounded-pill px-4 border-2" style="border-color:#7B57F9;" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control rounded-4 px-3 border-2" style="border-color:#7B57F9;" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="main-btn btn px-5 py-2 rounded-pill d-flex align-items-center gap-2 mx-auto mt-3" style="font-size:1.1rem;">
                            <i class="bi bi-send"></i> Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 