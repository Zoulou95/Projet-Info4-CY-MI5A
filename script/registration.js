// registration.js : functions for displaying the registration and login overlay

// Display overlay
function openSignUpOverlay(event) {
    if (event) event.preventDefault(); // Prevents page change
    closeSignInOverlay(); // Close the other overlay
    document.getElementById("signup_overlay").classList.add("active");
    document.body.classList.add("no_scroll");
}

// Close Overlay
function closeSignUpOverlay() {
    document.getElementById("signup_overlay").classList.remove("active");
    document.body.classList.remove("no_scroll");
}

function openSignInOverlay(event) {
    if (event) event.preventDefault(); // Prevents page change
    closeSignUpOverlay(); // Close the other overlay
    document.getElementById("signin_overlay").classList.add("active");
    document.body.classList.add("no_scroll");
}

function closeSignInOverlay() {
    document.getElementById("signin_overlay").classList.remove("active");
    document.body.classList.remove("no_scroll");
}

// Switch from one overlay to another
function switchToSignUp() {
    closeSignInOverlay(); // // Close the login overlay
    openSignUpOverlay(); // Open registration overlay 
}

function switchToSignIn() {
    closeSignUpOverlay(); // Close registration overlay
    openSignInOverlay();  // Open login overlay    
}