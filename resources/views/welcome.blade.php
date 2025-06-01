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
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
