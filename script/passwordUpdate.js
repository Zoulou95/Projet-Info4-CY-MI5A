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

// Display or hide the password input
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const img = btn.querySelector('img') || document.createElement('img');
    
    if (input.type === "password") {
        input.type = "text";
        img.src = "../assets/visuals/eye_open.png";
        img.alt = "Cacher le mot de passe";
        img.class = "eye_image";
    } else {
        input.type = "password";
        img.src = "../assets/visuals/eye_close.png";
        img.alt = "Afficher le mot de passe";
        img.class = "eye_image";
    }
    
    // If the image doesn't already exist in the button, add it
    if (!btn.querySelector('img')) {
        btn.textContent = '';
        btn.appendChild(img);
    }
}

// Fonction pour mettre à jour les compteurs de caractères
function updateCounter(inputId, counterId, maxLength) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(counterId);
    
    if (!input || !counter) {
        console.error(`Élément non trouvé: input=${inputId}, counter=${counterId}`);
        return;
    }

    // Mise à jour du compteur à chaque changement dans le champ
    const update = () => {
        const length = input.value.length;
        counter.textContent = `${length} / ${maxLength}`;
    };

    // Ajout de l'écouteur d'événement pour mettre à jour le compteur en temps réel
    input.addEventListener("input", update);

    // Mise à jour initiale au chargement de la page
    update();
}


// Initialisation des compteurs au chargement de la page
document.addEventListener("DOMContentLoaded", function() {
    // Login
    if(typeof current_password !== 'undefined') {
        updateCounter("current_password", "current_password_counter", 20);
    }

    if(typeof new_password !== 'undefined') {
        updateCounter("new_password", "new_password_counter", 20);
    }

    if(typeof confirmation_password !== 'undefined') {
        updateCounter("confirmation_password", "confirm_password_counter", 20);
    }
});