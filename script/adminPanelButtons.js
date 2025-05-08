document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner tous les boutons
    const allButtons = document.querySelectorAll('.user_button');
    
    allButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Empêcher le comportement par défaut du bouton
            e.preventDefault();
            
            // Récupérer le formulaire parent
            const currentForm = this.closest('form');
            
            // Récupérer l'action et l'ID utilisateur
            const action = this.value;
            const userId = currentForm.querySelector('input[name="user_id"]').value;
            
            // Désactiver tous les boutons de la page
            allButtons.forEach(btn => {
                btn.disabled = true;
                btn.classList.add('disabled');
            });
            
            // Créer un formulaire temporaire
            const tempForm = document.createElement('form');
            tempForm.method = 'POST';
            tempForm.action = 'update_role.php';
            tempForm.style.display = 'none';
            
            // Ajouter les champs nécessaires
            const userIdInput = document.createElement('input');
            userIdInput.type = 'hidden';
            userIdInput.name = 'user_id';
            userIdInput.value = userId;
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;
            
            // Ajouter les champs au formulaire
            tempForm.appendChild(userIdInput);
            tempForm.appendChild(actionInput);
            
            // Ajouter le formulaire au document
            document.body.appendChild(tempForm);
            
            // Attendre 2 secondes puis soumettre le formulaire
            setTimeout(() => {
                tempForm.submit();
            }, 2000);
        });
    });
});