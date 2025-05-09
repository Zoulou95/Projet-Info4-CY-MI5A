// userpage.js - Script pour gérer l'édition des champs du profil utilisateur

document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner tous les champs de saisie
    const inputFields = document.querySelectorAll('#last_name, #first_name, #email, #tel_number');
    
    // Stockage des valeurs originales
    const originalValues = {};
    
    // Référencer les boutons existants
    const saveButton = document.getElementById('save_button');
    const resetButton = document.getElementById('reset_button');
    const logoutButton = document.getElementById('logout_button');
    
    // S'assurer que les boutons ne soumettent pas le formulaire par défaut
    saveButton.type = 'button';
    resetButton.type = 'button';
    
    // Créer le bouton "Modifier"
    const editButton = document.createElement('button');
    editButton.type = 'button';
    editButton.id = 'edit_button';
    editButton.innerText = 'Modifier';
    
    // Insérer le bouton "Modifier" avant le bouton "Sauvegarder"
    saveButton.parentNode.insertBefore(editButton, saveButton);
    
    // Masquer initialement les boutons "Sauvegarder" et "Réinitialiser"
    saveButton.style.display = 'none';
    resetButton.style.display = 'none';
    
    // Stocker les valeurs originales initiales
    function updateOriginalValues() {
        inputFields.forEach(function(field) {
            originalValues[field.id] = field.value;
        });
    }
    
    // Initialiser les valeurs originales
    updateOriginalValues();
    
    // Désactiver tous les champs par défaut
    inputFields.forEach(function(field) {
        field.disabled = true;
    });
    
    // Mode édition
    let isEditMode = false;
    
    // Gérer le clic sur le bouton "Modifier"
    editButton.addEventListener('click', function(event) {
        // Empêcher tout comportement par défaut
        event.preventDefault();
        
        // Activer tous les champs
        inputFields.forEach(function(field) {
            field.disabled = false;
        });
        
        // Masquer le bouton "Modifier" et afficher les boutons "Sauvegarder" et "Réinitialiser"
        editButton.style.display = 'none';
        saveButton.style.display = 'inline-block';
        resetButton.style.display = 'inline-block';
        
        // Activer le mode édition
        isEditMode = true;
    });
    
    // Gérer le clic sur le bouton "Sauvegarder"
    saveButton.addEventListener('click', function(event) {
        // Empêcher la soumission du formulaire pour le moment
        event.preventDefault();
        
        // Vérifier si des modifications ont été effectuées
        let hasChanges = false;
        inputFields.forEach(function(field) {
            if (field.value !== originalValues[field.id]) {
                hasChanges = true;
            }
        });
        
        // Si des modifications ont été faites, soumettre le formulaire
        if (hasChanges) {
            // Créer un bouton de soumission temporaire
            const submitBtn = document.createElement('input');
            submitBtn.type = 'submit';
            submitBtn.style.display = 'none';
            
            // Ajouter le bouton au formulaire et cliquer dessus
            const form = document.querySelector('form');
            form.appendChild(submitBtn);
            submitBtn.click();
            
            // Supprimer le bouton après utilisation
            form.removeChild(submitBtn);
            
            // Mémoriser qu'une soumission a eu lieu
            localStorage.setItem('formSubmitted', 'true');
        } 
        else {
            // Si aucune modification, simplement mettre à jour les valeurs originales
            updateOriginalValues();
        }
        
        // Dans tous les cas, désactiver les champs
        inputFields.forEach(function(field) {
            field.disabled = true;
        });
        
        // Masquer les boutons "Sauvegarder" et "Réinitialiser" et afficher le bouton "Modifier"
        saveButton.style.display = 'none';
        resetButton.style.display = 'none';
        editButton.style.display = 'inline-block';
        
        // Désactiver le mode édition
        isEditMode = false;
    });
    
    // Gérer le clic sur le bouton "Réinitialiser"
    resetButton.addEventListener('click', function(event) {
        // Empêcher la soumission du formulaire
        event.preventDefault();
        
        // Réinitialiser tous les champs à leur valeur d'origine
        inputFields.forEach(function(field) {
            field.value = originalValues[field.id];
            field.disabled = true;
        });
        
        // Masquer les boutons "Sauvegarder" et "Réinitialiser" et afficher le bouton "Modifier"
        saveButton.style.display = 'none';
        resetButton.style.display = 'none';
        editButton.style.display = 'inline-block';
        
        // Désactiver le mode édition
        isEditMode = false;
    });
    
    // Empêcher la soumission du formulaire par défaut
    document.querySelector('form').addEventListener('submit', function(event) {
        // Si c'est le bouton de déconnexion, laisser passer
        if (event.submitter && event.submitter.id === 'logout_button') {
            return true;
        }
        
        // Si ce n'est pas une soumission intentionnelle du formulaire (après édition),
        // empêcher la soumission
        if (!isEditMode && !event.isTrusted) {
            event.preventDefault();
        }
    });
    
    // Vérifier si une soumission réussie a eu lieu lors d'une visite précédente
    if (localStorage.getItem('formSubmitted') === 'true') {
        // Réinitialiser l'indicateur
        localStorage.removeItem('formSubmitted');
        // Mettre à jour les valeurs originales
        updateOriginalValues();
    }
});