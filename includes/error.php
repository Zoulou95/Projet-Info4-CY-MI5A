<?php

require_once('header.php');
require_once('footer.php');

// Display error message
function displayError($message) {

    displayHeader();

    // Display error message in the console (for admins, in red color)
    error_log("\033[31mERROR : ". $message . "\033[0m");

    // Display error message for users
    echo 
    "
    <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/base_style.css\" />
    <h3 class=\"invalid_page_text\">Page web non disponible</h3>
    <button class=\"back_to_index_button\" onclick=\"window.location.href='advanced_search.php'\">
        <a class=\"back_to_index_text\" href=\"../index.php\">Cliquez ici pour retourner à l'accueil</a> 
    </button>";

    displayFooter();

    exit;
}
?>

