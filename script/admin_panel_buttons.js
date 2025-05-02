document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner tous les formulaires d'utilisateurs
    const userForms = document.querySelectorAll('.users');
    
    userForms.forEach(form => {
        // Récupérer tous les boutons dans le formulaire
        const buttons = form.querySelectorAll('button');
        
        buttons.forEach(button => {
            // Ajouter un écouteur d'événement sur chaque bouton plutôt que sur le formulaire
            button.addEventListener('click', function(e) {
                // Empêcher le comportement par défaut du bouton
                e.preventDefault();
                
                // Récupérer le formulaire parent du bouton
                const currentForm = this.closest('form');
                
                // Récupérer l'action du bouton
                const action = this.value;
                
                // Désactiver tous les boutons dans ce formulaire utilisateur
                const allButtons = currentForm.querySelectorAll('button');
                allButtons.forEach(btn => {
                    btn.disabled = true;
                    btn.classList.add('disabled');
                });
                
                // Afficher un message de chargement à côté du bouton cliqué
                const loadingSpan = document.createElement('span');
                loadingSpan.textContent = ' ...';
                loadingSpan.className = 'loading-text';
                this.parentNode.appendChild(loadingSpan);
                                
                // Stocker une référence au bouton cliqué pour pouvoir soumettre le formulaire avec la bonne action
                const clickedButton = this;
                
                // Attendre 2 secondes avant d'envoyer le formulaire
                setTimeout(() => {
                    // Créer un champ caché pour l'action si nécessaire
                    let actionInput = currentForm.querySelector('input[name="action"]');
                    if (!actionInput) {
                        actionInput = document.createElement('input');
                        actionInput.type = 'hidden';
                        actionInput.name = 'action';
                        currentForm.appendChild(actionInput);
                    }
                    
                    // Définir la valeur de l'action (celle du bouton cliqué)
                    actionInput.value = action;
                    
                    // Soumettre le formulaire
                    currentForm.submit();
                }, 2000);
            });
        });
    });
});