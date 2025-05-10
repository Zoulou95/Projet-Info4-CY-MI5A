// passwordUpdate.js : update user's password

document.getElementById("security_form").addEventListener("submit", function (event) {
    // Prevent default submission by clicking on the submit button
    event.preventDefault();

    // Retrieve input values
    const currentPassword = document.getElementById('current_password').value.trim();
    const newPassword = document.getElementById('new_password').value.trim();
    const confirmationPassword = document.getElementById('confirmation_password').value.trim();

    // We use regexes to ensure that the data sent to the server is correct
    const passwordRegex = /^.{8,20}$/; // 8 characters

    // Verifications
    if (!passwordRegex.test(currentPassword)) {
        displayBubble(event, "❌ Mot de passe invalide (8 à 20 caractères)");
        return;
    }

    if (!passwordRegex.test(newPassword)) {
        displayBubble(event, "❌ Mot de passe invalide (8 à 20 caractères)");
        return;
    }

    if (!passwordRegex.test(confirmationPassword)) {
        displayBubble(event, "❌ Mot de passe invalide (8 à 20 caractères)");
        return;
    }

    // Get the form element and create FormData object
    const form = document.getElementById("security_form");
    const formData = new FormData(form);

    // Create and configure AJAX request
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else  if (window.ActiveXObject)      {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xhr.open("POST", "../includes/password_update.php", true);

    // Handle server response
    xhr.onload = function () {
        // Check if the request was successful
        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);

                if (!response.success) {
                    // Handle password update errors
                     if (response.message.includes("identiques")) {
                        displayBubble(event, response.message);
                    } else if (response.message.includes("caractères")) {
                        displayBubble(event, response.message);
                    } else if (response.message.includes("actuel")) {
                        displayBubble(event, response.message);
                    } else if (response.message.includes("impossible")) {
                        displayBubble(event, response.message);
                    }
                    return;
                } else {
                    if (response.message.includes("succès")) {
                        displayBubble(event, response.message);
                    }
                }
                
            // Handle errors
            } catch (e) {
            console.error("ERROR: parsing JSON error.", xhr.responseText);
            displayBubble(event, "⚠️ Erreur de traitement du serveur");
        }
    // Handle network errors
    } else {
        console.error("ERROR: HTTP error (code " + xhr.status + ").");
        displayBubble(event, "⚠️ Erreur " + xhr.status);
    }
};

    // Handle errors
    xhr.onerror = function () {
        console.error("ERROR: connection to server failed.");
        displayBubble(event, "⚠️ Connexion au serveur impossible");
    };

    // Send the form data
    xhr.send(formData);
});