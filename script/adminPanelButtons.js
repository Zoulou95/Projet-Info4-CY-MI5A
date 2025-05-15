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
            
            // Temporary form
            const tempForm = document.createElement('form');
            tempForm.method = 'POST';
            tempForm.action = 'update_role.php';
            tempForm.style.display = 'none';
            
            // Add the necessary fields
            const userIdInput = document.createElement('input');
            userIdInput.type = 'hidden';
            userIdInput.name = 'user_id';
            userIdInput.value = userId;
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;
            
            // Add fields to the form
            tempForm.appendChild(userIdInput);
            tempForm.appendChild(actionInput);
            
            // Add form to document
            document.body.appendChild(tempForm);
            
            // Wait 2 seconds, then submit the form (intentional delay for cognitive purpose)
            setTimeout(() => {
                tempForm.submit();
            }, 2000);
        });
    });
});