@extends('layouts.simple')
@section('title', 'Demande de compte')
@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold gradient-text mb-2" style="font-size:2.2rem;">Demander un compte</h1>
            <p class="text-muted" style="font-size:1.1rem;">Remplissez ce formulaire pour demander la création d'un compte sur E-Taalim. L'administration vous contactera rapidement.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="bg-white rounded-4 shadow-sm p-4">
                    <form method="POST" action="#">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom complet</label>
                            <input type="text" class="form-control rounded-pill px-4 border-2" style="border-color:#7B57F9;" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control rounded-pill px-4 border-2" style="border-color:#7B57F9;" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message (optionnel)</label>
                            <textarea class="form-control rounded-4 px-3 border-2" style="border-color:#7B57F9;" id="message" name="message" rows="3"></textarea>
                        </div>
                        <button type="submit" class="main-btn btn px-5 py-2 rounded-pill d-flex align-items-center gap-2 mx-auto mt-3" style="font-size:1.1rem;">
                            <i class="bi bi-person-plus"></i> Envoyer la demande
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 