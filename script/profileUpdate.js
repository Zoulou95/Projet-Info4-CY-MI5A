// profilteUpdate.js : update user's personal profile using AJAX

document.getElementById("profile_form").addEventListener("submit", function (event) {
    // Prevent default submission by clicking on the submit button
    event.preventDefault();

    // Retrieve input values
    const name = document.getElementById('last_name').value.trim();
    const forename = document.getElementById('first_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('tel_number').value.trim();

    // We use regexes to ensure that the data sent to the server is correct
    // We used https://regexr.com/ to generate custom regex
    const nameRegex = /^[A-Za-z\- ]{2,20}$/; // Letters only, between 2 and 20 characters
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Valid email format (example: user@cylanta.com)
    const phoneRegex = /^[0-9]{10}$/; // 10 digit

    // Verifications
    if (!nameRegex.test(name)) {
        displayBubble(event, "❌ Nom invalide (lettres uniquement, 2 à 20 caractères)");
        return;
    }

    if (!nameRegex.test(forename)) {
        displayBubble(event, "❌ Prénom invalide (lettres uniquement, 2 à 20 caractères)");
        return;
    }

    if (!emailRegex.test(email)) {
        displayBubble(event, "❌ Adresse e-mail invalide");
        return;
    }

    if (!phoneRegex.test(phone)) {
        displayBubble(event, "❌ Numéro de téléphone invalide (10 chiffres)");
        return;
    }

    // Get the form element and create FormData object
    const form = document.getElementById("profile_form");
    const formData = new FormData(form);

    // Create and configure AJAX request
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else  if (window.ActiveXObject)      {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xhr.open("POST", "../includes/profile_update.php", true);

    // Handle server response
    xhr.onload = function () {
        // Check if the request was successful
        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);

                if (!response.success) {
                    // Handle file upload error
                    if (response.message.includes("format")) {
                        displayBubble(event, response.message);
                    } else if (response.message.includes("trop lourde")) {
                        displayBubble(event, response.message);
                    }
                    return;
                }

                // Refresh profile picture on the screen by adding a timestamp parameter
                const profilePicImg = document.querySelectorAll(".user_img, .user_img_nav");
                if (profilePicImg) {
                    profilePicImg.forEach(img => {
                        img.src = img.src.split("?")[0] + "?t=" + new Date().getTime();
                    });
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