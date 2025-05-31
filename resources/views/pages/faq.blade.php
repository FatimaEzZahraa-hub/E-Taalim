@extends('layouts.simple')
@section('title', 'FAQ')
@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold gradient-text mb-2" style="font-size:2.2rem;">Questions fréquentes</h1>
            <p class="text-muted" style="font-size:1.1rem;">Trouvez rapidement les réponses à vos questions sur l'utilisation de notre plateforme éducative.</p>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <div class="input-group shadow-sm">
                        <input type="text" id="searchInput" class="form-control form-control-lg rounded-start-pill border-2" style="border-color:#7B57F9;" placeholder="Rechercher une question...">
                        <span class="input-group-text bg-white rounded-end-pill border-2" style="border-color:#7B57F9;"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Général -->
                <h4 class="fw-bold mb-4" style="color:#7B57F9; border-bottom:2px solid #7B57F9; display:inline-block; padding-bottom:0.3rem;">Général</h4>
                <div id="faqContainer">
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-question-circle"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Qu'est-ce que E-Taalim ?</div>
                            <div class="text-muted">E-Taalim est une plateforme éducative en ligne dédiée à l'apprentissage moderne et interactif pour étudiants, enseignants et administration.</div>
                        </div>
                    </div>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-shield-lock"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">La plateforme est-elle sécurisée ?</div>
                            <div class="text-muted">Oui, toutes les données sont protégées et l'accès est réservé aux utilisateurs autorisés par l'administration.</div>
                        </div>
                    </div>

                    <!-- Compte et Connexion -->
                    <h4 class="fw-bold mb-4 mt-5" style="color:#7B57F9; border-bottom:2px solid #7B57F9; display:inline-block; padding-bottom:0.3rem;">Compte et Connexion</h4>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-person-plus"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Comment obtenir un compte ?</div>
                            <div class="text-muted">Les comptes sont créés par l'administration. Contactez l'administration via la page de contact pour demander un accès.</div>
                        </div>
                    </div>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-unlock"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">J'ai oublié mon mot de passe, que faire ?</div>
                            <div class="text-muted">Cliquez sur "Mot de passe oublié ?" sur la page de connexion et suivez les instructions pour réinitialiser votre mot de passe.</div>
                        </div>
                    </div>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-shield-check"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Comment sécuriser mon compte ?</div>
                            <div class="text-muted">Utilisez un mot de passe fort, ne le partagez pas et déconnectez-vous après chaque session. Activez l'authentification à deux facteurs si disponible.</div>
                        </div>
                    </div>

                    <!-- Fonctionnalités -->
                    <h4 class="fw-bold mb-4 mt-5" style="color:#7B57F9; border-bottom:2px solid #7B57F9; display:inline-block; padding-bottom:0.3rem;">Fonctionnalités</h4>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-book"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Comment accéder à mes cours et devoirs ?</div>
                            <div class="text-muted">Après connexion, accédez à votre espace personnel pour retrouver vos cours, devoirs et ressources pédagogiques.</div>
                        </div>
                    </div>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-calendar-check"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Comment consulter mon emploi du temps ?</div>
                            <div class="text-muted">Votre emploi du temps est accessible depuis votre tableau de bord. Vous pouvez le consulter par jour, semaine ou mois.</div>
                        </div>
                    </div>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-chat-dots"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Comment communiquer avec mes enseignants ?</div>
                            <div class="text-muted">Utilisez la messagerie intégrée de la plateforme pour contacter vos enseignants. Ils répondront généralement dans un délai de 24-48 heures.</div>
                        </div>
                    </div>

                    <!-- Ressources et Documents -->
                    <h4 class="fw-bold mb-4 mt-5" style="color:#7B57F9; border-bottom:2px solid #7B57F9; display:inline-block; padding-bottom:0.3rem;">Ressources et Documents</h4>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-file-earmark-text"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Comment soumettre mes devoirs ?</div>
                            <div class="text-muted">Dans la section du cours concerné, cliquez sur "Soumettre un devoir", sélectionnez votre fichier et validez. Vérifiez bien le format et la taille du fichier.</div>
                        </div>
                    </div>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-download"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Quels formats de fichiers sont acceptés ?</div>
                            <div class="text-muted">Les formats PDF, DOCX, PPTX, XLSX sont acceptés. La taille maximale par fichier est de 10MB.</div>
                        </div>
                    </div>

                    <!-- Support et Assistance -->
                    <h4 class="fw-bold mb-4 mt-5" style="color:#7B57F9; border-bottom:2px solid #7B57F9; display:inline-block; padding-bottom:0.3rem;">Support et Assistance</h4>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-headset"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Comment obtenir de l'aide technique ?</div>
                            <div class="text-muted">Pour toute assistance technique, contactez le support via le formulaire de contact ou par email à support@e-taalim.com.</div>
                        </div>
                    </div>
                    <div class="faq-item mb-3 p-4 bg-white rounded-4 shadow-sm d-flex align-items-start gap-3">
                        <span class="fs-3 mt-1" style="color:#7B57F9;"><i class="bi bi-exclamation-circle"></i></span>
                        <div>
                            <div class="fw-semibold mb-1">Que faire en cas de problème technique ?</div>
                            <div class="text-muted">Vérifiez votre connexion internet, videz le cache de votre navigateur, et si le problème persiste, contactez le support technique.</div>
                        </div>
                    </div>
                </div>
                <div id="noResults" class="text-center py-4 d-none">
                    <i class="bi bi-search fs-1 text-muted mb-3"></i>
                    <p class="text-muted">Aucune question ne correspond à votre recherche.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const faqItems = document.querySelectorAll('.faq-item');
    const noResults = document.getElementById('noResults');
    const faqContainer = document.getElementById('faqContainer');
    const categoryHeaders = document.querySelectorAll('h4.fw-bold');

    // Fonction pour mettre en évidence le texte correspondant
    function highlightText(text, searchTerm) {
        if (!searchTerm) return text;
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return text.replace(regex, '<mark style="background-color: #7B57F9; color: white; padding: 0 2px; border-radius: 2px;">$1</mark>');
    }

    // Fonction pour afficher/masquer les catégories
    function toggleCategory(categoryHeader, hasVisibleItems) {
        const nextElement = categoryHeader.nextElementSibling;
        if (nextElement && nextElement.classList.contains('faq-item')) {
            categoryHeader.style.display = hasVisibleItems ? '' : 'none';
        }
    }

    // Fonction de recherche améliorée
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let hasResults = false;
        let currentCategory = null;
        let categoryHasVisibleItems = false;

        // Réinitialiser l'affichage
        faqItems.forEach(item => {
            const question = item.querySelector('.fw-semibold');
            const answer = item.querySelector('.text-muted');
            
            // Restaurer le texte original
            question.innerHTML = question.textContent;
            answer.innerHTML = answer.textContent;
            
            // Trouver la catégorie parente
            let categoryHeader = item.previousElementSibling;
            while (categoryHeader && !categoryHeader.classList.contains('fw-bold')) {
                categoryHeader = categoryHeader.previousElementSibling;
            }

            if (categoryHeader !== currentCategory) {
                if (currentCategory) {
                    toggleCategory(currentCategory, categoryHasVisibleItems);
                }
                currentCategory = categoryHeader;
                categoryHasVisibleItems = false;
            }

            if (searchTerm === '') {
                item.style.display = '';
                categoryHasVisibleItems = true;
                hasResults = true;
            } else {
                const questionText = question.textContent.toLowerCase();
                const answerText = answer.textContent.toLowerCase();
                
                if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                    item.style.display = '';
                    // Mettre en évidence le texte correspondant
                    question.innerHTML = highlightText(question.textContent, searchTerm);
                    answer.innerHTML = highlightText(answer.textContent, searchTerm);
                    categoryHasVisibleItems = true;
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            }
        });

        // Gérer la dernière catégorie
        if (currentCategory) {
            toggleCategory(currentCategory, categoryHasVisibleItems);
        }

        // Afficher/masquer le message "aucun résultat"
        if (!hasResults && searchTerm !== '') {
            noResults.classList.remove('d-none');
            faqContainer.classList.add('d-none');
        } else {
            noResults.classList.add('d-none');
            faqContainer.classList.remove('d-none');
        }
    }

    // Ajouter un délai de frappe pour optimiser les performances
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 300);
    });

    // Exécuter la recherche au chargement de la page
    performSearch();
});
</script>
@endsection 