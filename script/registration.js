// registration.js : functions for displaying the registration and login overlay

function openSignUpOverlay(event) {
    if (event) event.preventDefault(); // Prevents page change
    closeSignInOverlay(); // Close the other overlay
    document.getElementById("signupOverlay").classList.add("active");
    document.body.classList.add("no-scroll");
}

function closeSignUpOverlay() {
    document.getElementById("signupOverlay").classList.remove("active");
    document.body.classList.remove("no-scroll");
}

function openSignInOverlay(event) {
    if (event) event.preventDefault(); // Prevents page change
    closeSignUpOverlay(); // Close the other overlay
    document.getElementById("signinOverlay").classList.add("active");
    document.body.classList.add("no-scroll");
}

function closeSignInOverlay() {
    document.getElementById("signinOverlay").classList.remove("active");
    document.body.classList.remove("no-scroll");
}

function switchToSignUp() {
    closeSignInOverlay(); // // Close the login overlay
    openSignUpOverlay(); // Open registration overlay 
}

function switchToSignIn() {
    closeSignUpOverlay(); // Close registration overlay
    openSignInOverlay();  // Open login overlay    
}