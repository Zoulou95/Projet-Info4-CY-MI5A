<!-- error_page.php -->

<?php
include('../includes/footer.php');

// Display error message
// N.B : We use ’ character to display the html code correctly
function displayError($message) {

    // Display error message in the console (for admins)
    error_log('ERROR : '. $message);

    // Display error message for users
    echo
    '<h3 class="invalid_page_text">Page web non disponible</h3>
    <button class="back_to_index_button">
        <a class="back_to_index_text" href="../index.php">Cliquez ici pour retourner à l’accueil</a>
    </button>';

    displayFooter();

    exit;
}
?>

