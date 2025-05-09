// formFeature.js : functions on form functionalities and security

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
    // Connexion
    updateCounter("emailInputLogin", "emailCounterLogin", 50);
    updateCounter("passwordInputLogin", "passwordCounterLogin", 30);

    // Inscription
    updateCounter("forenameInput", "forenameCounter", 50);
    updateCounter("nameInput", "nameCounter", 50);
    updateCounter("emailInputSignup", "emailCounterSignup", 50);
    updateCounter("passwordInputSignup", "passwordCounterSignup", 30);
    updateCounter("telInput", "telCounter", 15);
});