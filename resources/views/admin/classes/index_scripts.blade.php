<!-- Script pour empêcher la fermeture automatique des modals -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pour les modals de création de groupe
        const createGroupeForms = document.querySelectorAll('[id^="createGroupeModal"] form');
        createGroupeForms.forEach(form => {
            form.addEventListener('submit', function() {
                // Stocker l'ID du modal ouvert
                localStorage.setItem('lastOpenedModal', this.closest('.modal').id);
            });
        });
        
        // Réouvrir le dernier modal si nécessaire (après rechargement de la page)
        const lastOpenedModal = localStorage.getItem('lastOpenedModal');
        if (lastOpenedModal && document.getElementById(lastOpenedModal)) {
            const modalElement = document.getElementById(lastOpenedModal);
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            // Effacer après ouverture
            localStorage.removeItem('lastOpenedModal');
        }
        
        // Empêcher la fermeture du modal en cas d'erreur de validation
        @if($errors->any())
            const formWithErrors = document.querySelector('form.needs-validation');
            if (formWithErrors) {
                const modalId = formWithErrors.closest('.modal')?.id;
                if (modalId) {
                    const modalElement = document.getElementById(modalId);
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        @endif
    });
</script>
