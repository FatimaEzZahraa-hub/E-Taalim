@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 mb-4 mb-lg-0 animate-fade-in">
                <h1 class="display-4 fw-bold mb-4 text-center text-lg-start">
                    <span class="gradient-text">E-Taalim :</span> Votre espace d'apprentissage digital <span class="gradient-text">sécurisé</span>.
                </h1>
                <p class="lead text-muted mb-4 text-center text-lg-start">
                    Bienvenue sur E-Taalim, votre plateforme éducative en ligne dédiée à l'apprentissage moderne et interactif. Que vous soyez étudiant, enseignant ou membre de l'administration, E-Taalim vous offre un espace intuitif pour accéder aux cours, partager des ressources, communiquer facilement et participer à des événements éducatifs.
                </p>
                <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-lg-start">
                    <a href="{{ route('login') }}" class="main-btn shadow px-4 py-2 fs-6 rounded-pill">Se connecter</a>
                </div>
            </div>
            <div class="col-lg-5 text-center animate-fade-in">
                <img src="{{ asset('images/accueil.jpg') }}" alt="Étudiants travaillant ensemble" class="img-fluid rounded-4 shadow-lg" style="max-width:420px;">
            </div>
        </div>
    </div>
</section>

<!-- Fonctionnalités -->
<section id="fonctionnalites" class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3 gradient-text">Fonctionnalités clés</h2>
            <p class="lead text-muted">Découvrez les outils qui font de E-Taalim la plateforme éducative de référence.</p>
                    </div>
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="feature-card rounded-4 p-4 h-100 text-center">
                    <div class="feature-icon">📚</div>
                    <h5 class="fw-semibold mb-2 main-color">Accès aux cours</h5>
                    <p class="text-muted small">Accès aux cours et aux ressources pédagogiques</p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="feature-card rounded-4 p-4 h-100 text-center">
                    <div class="feature-icon">📝</div>
                    <h5 class="fw-semibold mb-2 main-color">Gestion des devoirs</h5>
                    <p class="text-muted small">Gestion et soumission des devoirs</p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="feature-card rounded-4 p-4 h-100 text-center">
                    <div class="feature-icon">📅</div>
                    <h5 class="fw-semibold mb-2 main-color">Calendrier</h5>
                    <p class="text-muted small">Suivi des événements et calendrier personnalisé</p>
                </div>
                        </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="feature-card rounded-4 p-4 h-100 text-center">
                    <div class="feature-icon">📨</div>
                    <h5 class="fw-semibold mb-2 main-color">Messagerie</h5>
                    <p class="text-muted small">Messagerie interne entre utilisateurs</p>
                </div>
            </div>
                </div>
            </div>
        </section>

<!-- Pour Qui -->
<section class="audience-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3 gradient-text">Pour Qui ?</h2>
            <p class="lead text-muted">Notre plateforme s'adresse à tous les acteurs du monde éducatif, offrant des solutions adaptées à chaque besoin.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="feature-card rounded-4 p-4 h-100 text-center">
                    <div class="feature-icon"><i class="bi bi-people-fill"></i></div>
                    <h5 class="fw-semibold mb-2 main-color">Administration</h5>
                    <p class="text-muted small">Superviser la plateforme, valider les ressources, gérer les utilisateurs et analyser les performances grâce à des tableaux de bord intuitifs.</p>
                </div>
                        </div>
            <div class="col-md-4">
                <div class="feature-card rounded-4 p-4 h-100 text-center">
                    <div class="feature-icon"><i class="bi bi-person-badge-fill"></i></div>
                    <h5 class="fw-semibold mb-2 main-color">Enseignants</h5>
                    <p class="text-muted small">Créer et gérer des contenus pédagogiques, suivre les devoirs, évaluer les étudiants et communiquer efficacement avec toute la classe.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card rounded-4 p-4 h-100 text-center">
                    <div class="feature-icon"><i class="bi bi-mortarboard-fill"></i></div>
                    <h5 class="fw-semibold mb-2 main-color">Étudiants</h5>
                    <p class="text-muted small">Apprendre à son rythme, accéder aux cours et ressources, soumettre des travaux et participer activement aux discussions et événements.</p>
                </div>
            </div>
                </div>
            </div>
        </section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4 text-white">Prêt à révolutionner votre expérience éducative ?</h2>
        <p class="lead text-white-50 mb-4">Rejoignez E-Taalim dès aujourd'hui et découvrez une nouvelle façon d'enseigner et d'apprendre.</p>
        <a href="{{ route('login') }}" class="main-btn btn btn-lg px-5 py-3 rounded-pill">Se connecter</a>
                    </div>
</section>

<!-- Contact/FAQ Section -->
<section class="contact-section">
    <div class="container">
        <div class="row contact-row justify-content-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="contact-box h-100 d-flex flex-column justify-content-center">
                    <div class="contact-title mb-2">Besoin d'aide&nbsp;?</div>
                    <div class="contact-text mb-4">Notre équipe est là pour vous accompagner dans l'utilisation de notre plateforme.</div>
                    <div class="contact-btns">
                        <a href="{{ route('faq') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold" style="border-color:#7B57F9; color:#7B57F9;">Consulter la FAQ</a>
                        <a href="{{ route('contact') }}" class="main-btn rounded-pill px-4 py-2 fw-semibold" style="text-decoration:none;">Contactez-nous</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <img src="{{ asset('images/aide.png') }}" alt="Aide et contact" class="contact-illustration">
            </div>
        </div>
                </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-md-4 d-flex align-items-center mb-3 mb-md-0">
                <img src="{{ asset('images/logoe-taalim.png') }}" alt="Logo E-Taalim" style="height:48px; width:auto; margin-right:12px;">
                <span class="gradient-text fw-bold fs-4">E-Taalim</span>
                            </div>
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Liens rapides</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="/" class="footer-link">Accueil</a></li>
                    <li class="mb-2"><a href="#fonctionnalites" class="footer-link">Fonctionnalités</a></li>
                    <li class="mb-2"><a href="{{ route('faq') }}" class="footer-link">FAQ</a></li>
                    <li><a href="{{ route('contact') }}" class="footer-link">Contactez-nous</a></li>
                    </ul>
                </div>
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Contact</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-envelope main-color me-2"></i>contact@e-taalim.ma</li>
                    <li><i class="bi bi-telephone main-color me-2"></i>+212 5XX XX XX XX</li>
                </ul>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 border-top">
            <p class="mb-2 mb-md-0 text-muted">&copy; {{ date('Y') }} E-Taalim. Tous droits réservés.</p>
            <div class="d-flex gap-3">
                <a href="{{ route('politique') }}" class="footer-link">Politique de confidentialité</a>
                <a href="{{ route('conditions') }}" class="footer-link">Conditions d'utilisation</a>
                </div>
            </div>
        </div>
    </footer>
@endsection
