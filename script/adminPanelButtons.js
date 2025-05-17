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
            
            // Disable all buttons
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
                
                // Update interface after success
                updateButtonsBasedOnAction(currentForm, action);
                
                // Reactivate all buttons
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('disabled');
                });
            })
            .catch(error => {
                console.error('Action failed:', error);
                
                // Reactivate all buttons
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('disabled');
                });
            });
        });
    });
    
    // Function to update buttons according to the action performed
function updateButtonsBasedOnAction(form, action) {
    // Retrieve button containers
    const statusButtonContainer = form.querySelector('.user_status');
    const banButtonContainer = form.querySelector('.user_ban');
    const privilegeDiv = form.querySelector('.user_privilege');
    const userNameDiv = form.querySelector('.user_name p');
    
    // Update buttons and display based on the action
    switch (action) {
        case 'promote':
            privilegeDiv.textContent = "Privilège : Vip";
            statusButtonContainer.innerHTML = '<button class="user_button user_status_button user_status_button_demote" type="submit" name="action" value="demote">Rétrograder</button>';
            userNameDiv.className = 'color_vip';
            break;

        case 'demote':
            privilegeDiv.textContent = "Privilège : Standard";
            statusButtonContainer.innerHTML = '<button class="user_button user_status_button user_status_button_promote" type="submit" name="action" value="promote">Promouvoir</button>';
            userNameDiv.className = 'color_standard';
            break;
            
        case 'ban':
            privilegeDiv.textContent = "Privilège : Banni";
            statusButtonContainer.innerHTML = '';
            banButtonContainer.innerHTML = '<button class="user_button user_ban_button" type="submit" name="action" value="unban">DEBANNIR</button>';
            userNameDiv.className = 'color_standard';
            break;
            
        case 'unban':
            privilegeDiv.textContent = "Privilège : Standard";
            statusButtonContainer.innerHTML = '<button class="user_button user_status_button user_status_button_promote" type="submit" name="action" value="promote">Promouvoir</button>';
            banButtonContainer.innerHTML = '<button class="user_button user_ban_button" type="submit" name="action" value="ban">BANNIR</button>';
            userNameDiv.className = 'color_standard';
            break;
        default:
            console.error('Unknown action:', action);
            break;
    }
    
    // Add event listeners to new buttons
    const newButtons = form.querySelectorAll('.user_button');
    newButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            const action = this.value;
            const userId = form.querySelector('input[name="user_id"]').value;
            
            // Check if the action is valid for the current role
            const privilegeDiv = form.querySelector('.user_privilege');
            const currentRole = privilegeDiv.textContent.split(':')[1].trim().toLowerCase();
        
            // Prevent impossible actions
            if ((action === 'promote' && currentRole === 'vip') ||
                (action === 'demote' && currentRole === 'standard') ||
                (action === 'ban' && currentRole === 'banni') ||
                (action === 'unban' && currentRole !== 'banni')) {
                console.log('Invalid action:', action, 'for a user with role', currentRole);
                return; // Do nothing and exit the function
            }
            
            // Diable all buttons
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
                
                // Reactivate all buttons
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('disabled');
                });
            })
            .catch(error => {
                console.error('Action failed:', error);
                
                // Reactivate all buttons
                allButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('disabled');
                });
            });
        });
    });
}
});