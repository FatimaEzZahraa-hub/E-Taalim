<<<<<<< HEAD
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
=======
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Taalim - Plateforme Éducative</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #4a6bff 0%, #2541b2 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        
        .feature-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #4a6bff;
        }
        
        .btn-primary {
            background-color: #4a6bff;
            border-color: #4a6bff;
        }
        
        .btn-primary:hover {
            background-color: #2541b2;
            border-color: #2541b2;
        }
        
        .btn-outline-light:hover {
            background-color: rgba(255,255,255,0.2);
        }
        
        .footer {
            background-color: #343a40;
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stats-card {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .stats-card h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .testimonial-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .section-title {
            margin-bottom: 50px;
            position: relative;
        }
        
        .section-title:after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: #4a6bff;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <h1 class="h3 mb-0">E-Taalim</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fonctionnalités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary ms-2">Tableau de bord</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary ms-2">Connexion</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary ms-2">S'inscrire</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Bienvenue sur E-Taalim</h1>
                    <p class="lead mb-4">La plateforme éducative qui transforme l'expérience d'apprentissage pour les enseignants et les étudiants.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Commencer</a>
                        <a href="#features" class="btn btn-outline-light btn-lg">En savoir plus</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="stats-card">
                                <h3>500+</h3>
                                <p class="mb-0">Cours disponibles</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="stats-card">
                                <h3>1000+</h3>
                                <p class="mb-0">Étudiants actifs</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="stats-card">
                                <h3>50+</h3>
                                <p class="mb-0">Enseignants</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="stats-card">
                                <h3>95%</h3>
                                <p class="mb-0">Taux de satisfaction</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 my-5">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Nos Fonctionnalités</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3>Gestion des groupes</h3>
                        <p>Créez et gérez facilement vos groupes, partagez du contenu pédagogique et suivez la progression des étudiants.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>Devoirs et Examens</h3>
                        <p>Créez des devoirs et des examens, notez les soumissions et fournissez des commentaires détaillés aux étudiants.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Suivi des Progrès</h3>
                        <p>Suivez la progression des étudiants avec des tableaux de bord intuitifs et des rapports détaillés.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 my-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400" alt="À propos d'E-Taalim" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title">À Propos d'E-Taalim</h2>
                    <p class="lead">E-Taalim est une plateforme éducative innovante conçue pour faciliter l'enseignement et l'apprentissage.</p>
                    <p>Notre mission est de fournir aux enseignants et aux étudiants les outils nécessaires pour réussir dans un environnement éducatif numérique. Nous croyons que la technologie peut transformer l'éducation et rendre l'apprentissage plus accessible et plus engageant.</p>
                    <p>Avec E-Taalim, les enseignants peuvent créer des cours interactifs, assigner des devoirs, organiser des examens et suivre les progrès de vos étudiants par groupe et par module, le tout à partir d'une seule plateforme intuitive.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 my-5">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Ce que disent nos utilisateurs</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/70" alt="Témoignage" class="testimonial-img">
                            <div>
                                <h5 class="mb-0">Mohammed Alami</h5>
                                <p class="text-muted mb-0">Professeur de Mathématiques</p>
                            </div>
                        </div>
                        <p>"E-Taalim a révolutionné ma façon d'enseigner. Je peux maintenant facilement gérer mes cours et suivre les progrès de mes étudiants."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/70" alt="Témoignage" class="testimonial-img">
                            <div>
                                <h5 class="mb-0">Fatima Zahra</h5>
                                <p class="text-muted mb-0">Professeure de Sciences</p>
                            </div>
                        </div>
                        <p>"La plateforme est intuitive et facile à utiliser. Mes étudiants sont plus engagés et leurs résultats se sont améliorés depuis que j'utilise E-Taalim."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/70" alt="Témoignage" class="testimonial-img">
                            <div>
                                <h5 class="mb-0">Ahmed Benani</h5>
                                <p class="text-muted mb-0">Directeur d'École</p>
                            </div>
                        </div>
                        <p>"E-Taalim a transformé notre école. La communication entre enseignants et étudiants s'est améliorée et l'administration est devenue beaucoup plus efficace."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 my-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Contactez-nous</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-body p-5">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Sujet</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h3>E-Taalim</h3>
                    <p>La plateforme éducative qui transforme l'expérience d'apprentissage pour les enseignants et les étudiants.</p>
                </div>
                <div class="col-lg-2 mb-4 mb-lg-0">
                    <h5>Liens Rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Accueil</a></li>
                        <li><a href="#features" class="text-white">Fonctionnalités</a></li>
                        <li><a href="#about" class="text-white">À propos</a></li>
                        <li><a href="#contact" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <h5>Ressources</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Centre d'aide</a></li>
                        <li><a href="#" class="text-white">Documentation</a></li>
                        <li><a href="#" class="text-white">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>Suivez-nous</h5>
                    <div class="d-flex gap-3 mb-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <p>© 2023 E-Taalim. Tous droits réservés.</p>
>>>>>>> interface-enseignant
                </div>
            </div>
        </div>
    </footer>
<<<<<<< HEAD
@endsection
=======

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
>>>>>>> interface-enseignant
