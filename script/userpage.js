// userpage.js : manage editing of user profile fields

document.addEventListener('DOMContentLoaded', function() {
    // Select all input fields
    const inputFields = document.querySelectorAll('#last_name, #first_name, #email, #tel_number');
    
    // Store original values
    const originalValues = {};
    
    const saveButton = document.getElementById('save_button');
    const resetButton = document.getElementById('reset_button');
    
    saveButton.type = 'button';
    resetButton.type = 'button';
    
    // Create the "Modifier" button
    const editButton = document.createElement('button');
    editButton.type = 'button';
    editButton.id = 'edit_button';
    editButton.innerText = 'Modifier';
    
    // Insert the button before the "Sauvegarder" button
    saveButton.parentNode.insertBefore(editButton, saveButton);
    
    // Initially hide the "Sauvegarder" and "Réinitialiser" buttons
    saveButton.style.display = 'none';
    resetButton.style.display = 'none';
    
    // Store original values
    function updateOriginalValues() {
        inputFields.forEach(function(field) {
            originalValues[field.id] = field.value;
        });
    }
    
    updateOriginalValues();
    
    // Disable all default fields
    inputFields.forEach(function(field) {
        field.disabled = true;
    });
    
    let isEditMode = false;
    
    // Manage the click on the "Modify" button
    editButton.addEventListener('click', function(event) {
        // Prevent default event by clicking on the button
        event.preventDefault();
        
        // Activate all fields
        inputFields.forEach(function(field) {
            field.disabled = false;
        });
        
        // Hide the "Modify" button and display the "Save" and "Reset" buttons
        editButton.style.display = 'none';
        saveButton.style.display = 'inline-block';
        resetButton.style.display = 'inline-block';
        
        isEditMode = true;
    });
    
    // Manage the click on the "Sauvegarder" button
    saveButton.addEventListener('click', function(event) {
        // Prevent default event by clicking on the button
        event.preventDefault();
        
        // Check if changes have been made
        let hasChanges = false;
        inputFields.forEach(function(field) {
            if (field.value !== originalValues[field.id]) {
                hasChanges = true;
            }
        });

        const fileInput = document.getElementById('profile_picture_input');
        if (fileInput.files.length > 0) {
            hasChanges = true;
        }
        
        // If changes have been made, submit form
        if (hasChanges) {
            // Create a temporary submit button
            const submitBtn = document.createElement('input');
            submitBtn.type = 'submit';
            submitBtn.style.display = 'none';
            
            // Add the button to the form
            const form = document.querySelector('form');
            form.appendChild(submitBtn);
            submitBtn.click();
            
            // Delete button after use
            form.removeChild(submitBtn);
            
            localStorage.setItem('formSubmitted', 'true');
        } 
        else {
            // If no change, simply update original values
            updateOriginalValues();
        }
        
        // Disable all fields
        inputFields.forEach(function(field) {
            field.disabled = true;
        });
        
        // Hide the "Save" and "Reset" buttons and display the "Modify" button
        saveButton.style.display = 'none';
        resetButton.style.display = 'none';
        editButton.style.display = 'inline-block';
        

        isEditMode = false;
    });
    
    // Manage clicks on the "Reset" button
    resetButton.addEventListener('click', function(event) {
        // Prevent default submission by clicking on the submit button
        event.preventDefault();
        
        // Reset all fields to their original values
        inputFields.forEach(function(field) {
            field.value = originalValues[field.id];
            field.disabled = true;
        });
        
        // Hide the "Save" and "Reset" buttons and display the "Modify" button
        saveButton.style.display = 'none';
        resetButton.style.display = 'none';
        editButton.style.display = 'inline-block';
        
        isEditMode = false;
    });
    
    // Check whether a successful submission was made during a previous visit
    if (localStorage.getItem('formSubmitted') === 'true') {
        localStorage.removeItem('formSubmitted');
        updateOriginalValues();
    }
});