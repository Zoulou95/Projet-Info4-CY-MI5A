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
    
    // Add image if itdoesn't already exist
    if (!btn.querySelector('img')) {
        btn.textContent = '';
        btn.appendChild(img);
    }
}

// Update character counters
function updateCounter(inputId, counterId, maxLength) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(counterId);
    
    if (!input || !counter) {
        console.error(`ERROR: item not found (input=${inputId}, counter=${counterId})`);
        return;
    }

    // Update counter each time a field is changed
    const update = () => {
        const length = input.value.length;
        counter.textContent = `${length} / ${maxLength}`;
    };

    // Update counter in real time
    input.addEventListener("input", update);

    update();
}


// Initialize counters on page load
document.addEventListener("DOMContentLoaded", function() {
    // Login inputs
    if(typeof emailInputLogin !== 'undefined') {
        updateCounter("emailInputLogin", "emailCounterLogin", 50);
    }

    if(typeof passwordInputLogin !== 'undefined') {
        updateCounter("passwordInputLogin", "passwordCounterLogin", 30);
    }

    if(typeof forenameInput !== 'undefined') {
        updateCounter("forenameInput", "forenameCounter", 50);
    }

    if(typeof nameInput !== 'undefined') {
        updateCounter("nameInput", "nameCounter", 50);
    }

    // Sign up inputs
    if(typeof emailInputSignup !== 'undefined') {
        updateCounter("emailInputSignup", "emailCounterSignup", 50);
    }

    if(typeof passwordInputSignup !== 'undefined') {
        updateCounter("passwordInputSignup", "passwordCounterSignup", 30);
    }

    if(typeof telInput !== 'undefined') {
        updateCounter("telInput", "telCounter", 15);
    }
});

// Sign up verification
document.getElementById("signup_form").addEventListener("submit", function (event) {
    // Prevent default submission by clicking on the submit button
    event.preventDefault();

    // Retrieve input values
    const name = document.getElementById('nameInput').value.trim();
    const forename = document.getElementById('forenameInput').value.trim();
    const email = document.getElementById('emailInputSignup').value.trim();
    const phone = document.getElementById('telInput').value.trim();
    const password = document.getElementById('passwordInputSignup').value.trim();

    // We use regexes to ensure that the data sent to the server is correct
    // We used https://regexr.com/ to generate custom regex
    const nameRegex = /^[A-Za-z\- ]{2,20}$/; // Letters only, between 2 and 20 characters
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Valid email format (example: user@cylanta.com)
    const phoneRegex = /^[0-9]{10}$/; // 10 digit
    const passwordRegex = /^.{8,20}$/; // 8 characters

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

    if (!passwordRegex.test(password)) {
        displayBubble(event, "❌ Mot de passe invalide (8 à 20 caractères)");
        return;
    }

    // Submit form
    this.submit();
});

// Sign in verification
document.getElementById("signin_form").addEventListener("submit", function (event) {
    // Prevent default submission by clicking on the submit button
    event.preventDefault();

    // Retrieve input values
    const email = document.getElementById('emailInputLogin').value.trim();
    const password = document.getElementById('passwordInputLogin').value.trim();

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Valid email format (example: user@cylanta.com)
    const passwordRegex = /^.{8,20}$/; // 8 characters

    // Verifications
    if (!emailRegex.test(email)) {
        displayBubble(event, "❌ Adresse e-mail invalide");
        return;
    }

    if (!passwordRegex.test(password)) {
        displayBubble(event, "❌ Mot de passe invalide (8 à 20 caractères)");
        return;
    }

    // Submit form
    this.submit();
});