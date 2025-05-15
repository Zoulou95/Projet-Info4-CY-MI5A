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
            // Handle errors
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
                return;
            })
            .catch(error => {
                console.error('Action failed:', error);
            });
        });
    });
});