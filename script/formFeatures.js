// Fonction pour afficher/masquer le mot de passe
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        btn.textContent = "Cacher";
    } else {
        input.type = "password";
        btn.textContent = "Afficher";
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
