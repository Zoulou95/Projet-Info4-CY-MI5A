// adminPanelButtons.js : ban, demote and upgrade users

document.addEventListener('DOMContentLoaded', function() {
    // Select all buttons
    const allButtons = document.querySelectorAll('.user_button');
    
    allButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Prevent default button behavior
            e.preventDefault();
            
            // Retrieve parent form
            const currentForm = this.closest('form');
            
            // Retrieve action and user ID
            const action = this.value;
            const userId = currentForm.querySelector('input[name="user_id"]').value;
            
            // Disable all page buttons
            allButtons.forEach(btn => {
                btn.disabled = true;
                btn.classList.add('disabled');
            });
            
            const data = {
                action: action,
                user_id: userId
            };
            
            // Send data to PHP using fetch
            fetch('update_role.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error: status ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                if (data.error) {
                    console.error('ERROR:', data.error);
                    throw new Error(data.error);
                }
                
                // Mettre à jour l'interface après succès
                updateButtonsBasedOnAction(currentForm, action);
                
                // Réactiver tous les boutons
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('disabled');
                });
            })
            .catch(error => {
                console.error('Action failed:', error);
                
                // Réactiver tous les boutons même en cas d'erreur
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('disabled');
                });
            });
        });
    });
    
    // Fonction pour mettre à jour les boutons en fonction de l'action effectuée
function updateButtonsBasedOnAction(form, action) {
    // Récupérer les conteneurs de boutons
    const statusButtonContainer = form.querySelector('.user_status');
    const banButtonContainer = form.querySelector('.user_ban');
    const privilegeDiv = form.querySelector('.user_privilege');
    const userNameDiv = form.querySelector('.user_name p');
    
    // Mettre à jour les boutons et affichage selon l'action
    switch (action) {
        case 'promote':
            // L'utilisateur a été promu en VIP
            privilegeDiv.textContent = "Privilège : Vip";
            
            // Changer le bouton "Promouvoir" en "Rétrograder"
            statusButtonContainer.innerHTML = '<button class="user_button user_status_button user_status_button_demote" type="submit" name="action" value="demote">Rétrograder</button>';
            
            // Mettre à jour la couleur du nom (VIP = jaune)
            if (userNameDiv) {
                userNameDiv.className = 'color_vip';
            } else {
                // Si pas de balise p, on met directement le contenu avec la classe
                const userName = form.querySelector('.user_name');
                const content = userName.textContent.trim();
                userName.innerHTML = `<p class="color_vip">${content}</p>`;
            }
            break;
            
        case 'demote':
            // L'utilisateur a été rétrogradé en standard
            privilegeDiv.textContent = "Privilège : Standard";
            
            // Changer le bouton "Rétrograder" en "Promouvoir"
            statusButtonContainer.innerHTML = '<button class="user_button user_status_button user_status_button_promote" type="submit" name="action" value="promote">Promouvoir</button>';
            
            // Mettre à jour la couleur du nom (Standard = gris/noir)
            if (userNameDiv) {
                userNameDiv.className = 'color_standard';
            } else {
                // Si pas de balise p, on met directement le contenu avec la classe
                const userName = form.querySelector('.user_name');
                const content = userName.textContent.trim();
                userName.innerHTML = `<p class="color_standard">${content}</p>`;
            }
            break;
            
        case 'ban':
            // L'utilisateur a été banni
            privilegeDiv.textContent = "Privilège : Banni";
            
            // Supprimer le bouton de statut pour un utilisateur banni
            statusButtonContainer.innerHTML = '';
            
            // Changer le bouton "BANNIR" en "DEBANNIR"
            banButtonContainer.innerHTML = '<button class="user_button user_ban_button" type="submit" name="action" value="unban">DEBANNIR</button>';
            
            // Mettre à jour la couleur du nom (Banni = standard)
            if (userNameDiv) {
                userNameDiv.className = 'color_standard';
            } else {
                // Si pas de balise p, on met directement le contenu avec la classe
                const userName = form.querySelector('.user_name');
                const content = userName.textContent.trim();
                userName.innerHTML = `<p class="color_standard">${content}</p>`;
            }
            break;
            
        case 'unban':
            // L'utilisateur a été débanni (retour à standard)
            privilegeDiv.textContent = "Privilège : Standard";
            
            // Ajouter un bouton "Promouvoir" pour un utilisateur débanni
            statusButtonContainer.innerHTML = '<button class="user_button user_status_button user_status_button_promote" type="submit" name="action" value="promote">Promouvoir</button>';
            
            // Changer le bouton "DEBANNIR" en "BANNIR"
            banButtonContainer.innerHTML = '<button class="user_button user_ban_button" type="submit" name="action" value="ban">BANNIR</button>';
            
            // Mettre à jour la couleur du nom (Standard = gris/noir)
            if (userNameDiv) {
                userNameDiv.className = 'color_standard';
            } else {
                // Si pas de balise p, on met directement le contenu avec la classe
                const userName = form.querySelector('.user_name');
                const content = userName.textContent.trim();
                userName.innerHTML = `<p class="color_standard">${content}</p>`;
            }
            break;
    }
    
    // Ajouter des écouteurs d'événements aux nouveaux boutons
    const newButtons = form.querySelectorAll('.user_button');
    newButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            const action = this.value;
            const userId = form.querySelector('input[name="user_id"]').value;
            
            // Vérifier si l'action est valide en fonction du rôle actuel
            const privilegeDiv = form.querySelector('.user_privilege');
            const currentRole = privilegeDiv.textContent.split(':')[1].trim().toLowerCase();
        
            // Empêcher des actions impossibles ou redondantes
            if ((action === 'promote' && currentRole === 'vip') ||
                (action === 'demote' && currentRole === 'standard') ||
                (action === 'ban' && currentRole === 'banni') ||
                (action === 'unban' && currentRole !== 'banni')) {
                console.log('Action invalide ou redondante:', action, 'pour un utilisateur', currentRole);
                return; // Ne rien faire et sortir de la fonction
            }
            
            // Désactiver tous les boutons
            const allButtons = document.querySelectorAll('.user_button');
            allButtons.forEach(btn => {
                btn.disabled = true;
                btn.classList.add('disabled');
            });
            
            const data = {
                action: action,
                user_id: userId
            };
            
            fetch('update_role.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                updateButtonsBasedOnAction(form, action);
                
                // Réactiver tous les boutons
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('disabled');
                });
            })
            .catch(error => {
                console.error('Action failed:', error);
                
                // Réactiver tous les boutons
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('disabled');
                });
            });
        });
    });
}
});