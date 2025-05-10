<?php
// header.php : navigation bar and header code

require_once('session_start.php');
require_once('cart_functions.php');

// Display <head> and navigation bar
function displayHeader() {

    $current_file = $_SERVER['PHP_SELF'];

    // Reading files according to our position in the directory
    if (basename($current_file) === 'index.php') {
    $path_parent = "";
    $path_src = "src/";
    } else {
        $path_parent = "../";
        $path_src = "";
    }

    // Load error handle script
    echo '<script src="' . $path_parent . 'script/bubble.js"></script>';

    // Display dark mode or bright mode by default
    $dark_mode_class = '';

    if (isset($_COOKIE['dark-mode']) && $_COOKIE['dark-mode'] === 'true') {
        $dark_mode_class = 'dark-mode';
    }

    $current_file = $_SERVER['PHP_SELF'];

    // Get current page name without extension
    $page_name = pathinfo(basename($current_file), PATHINFO_FILENAME);
    // Define the CSS linked to the page you are on
    $optional_css = $path_parent . 'css/' . $page_name . '_style.css';

    // Display <head> section
    echo '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <title>CyLanta</title>
        <meta charset="utf-8" />
        <meta name="description" content="CyLanta travel agency website" />
        <meta name="author" content="Developped by MI5-A TEAM" />
        <meta name="keywords" content="voyage, agence de voyage, séjour, escapade, vacances, rechercher une destination" />
        <link rel="icon" type="image/png" href="' . $path_parent . 'assets/visuals/ico_island.png" />
        <link rel="stylesheet" type="text/css" href="' . $path_parent . 'css/base_style.css" />';

    if ($optional_css) {
        echo '<link rel="stylesheet" type="text/css" href="' . $optional_css . '" />';
    }

    echo '</head>';

    echo '<body class="' . $dark_mode_class . '">';
    echo '<div class="container">';

    echo '
    <div class="headbar">
        <div class="headbar_left">
            <a href="'.$path_parent.'index.php">
                <img class="logo_img" src="'.$path_parent.'assets/visuals/cylanta_logo.png" alt="Logo created by MI-A team" />
            </a>
        </div>
        <div class="headbar_rest">
            <a class="headbar_item" href="'.$path_parent.'index.php">Accueil</a>
            <a class="headbar_item" href="'.$path_src.'search.php">Destinations</a>
            <a class="headbar_item" href="'.$path_src.'advanced_search.php">Rechercher</a>
            <button id="darkModeToggle" style="header_dark_mode">
            🌙 Mode Sombre
            </button>
            <script src="'.$path_parent.'script/darkMode.js"></script>
        </div>';

    if (isset($_SESSION['user'])) {
        echo '
        <div class="headbar_right">
            <a id="cart_display" class="headbar_my_space" href="'.$path_src.'cart.php">Panier';

            // Display the number of items in the user's cart on the navigation bar
            $count = cartHeader($_SESSION['user']['id']);
            if($count > 0) {
                echo ' (' . $count . ')';
            }

            echo ' 🛒</a>
            <a class="headbar_my_space" href="'.$path_src.'userpage.php">Mon espace</a>
            <a href="'.$path_src.'userpage.php">
                <img class="user_img_nav" src="'.$path_parent.'assets/profile_pic/';

                if (file_exists(''.$path_parent.'assets/profile_pic/user' . $_SESSION['user']['id'] . '_profile_picture.jpg')) {
                    echo 'user' . $_SESSION['user']['id'] . '_profile_picture.jpg';
                } else {
                    echo 'base_profile_picture.jpg';
                }

                echo '" alt="User\'s profile picture" />
            </a>
        </div>';
    } else {
        echo '
        <div class="headbar_right">
            <a class="headbar_item" href="#" onclick="openSignInOverlay()">Connexion</a>
            <a class="headbar_item" href="#" onclick="openSignUpOverlay()">S\'inscrire</a>
        </div>
            <div class="overlay" id="signin_overlay">
        <div class="overlay_content">
            <span class="close_btn" onclick="closeSignInOverlay()">&times;</span>
            <h2>Connexion</h2>
                <form id="signin_form" action="'.$path_parent.'src/connexion.php" method="POST">
                    <div class="input-container">
                        <input class="overlay_input" type="text" id="emailInputLogin" name="email" placeholder="Email" maxlength="50" required>
                        <div class="counter-container">
                            <span id="emailCounterLogin">0 / 50</span>
                        </div>
                    </div>
                    
                    <div class="input-container">
                        <input class="overlay_input" type="text" id="passwordInputLogin" name="password" placeholder="Mot de passe" maxlength="30" required>
                        <div class="counter-container">
                            <span id="passwordCounterLogin">0 / 30</span>
                        </div>
                        <button type="button" class="toggle-password" onclick="togglePassword(\'passwordInputLogin\', this)"><img class="eye_image" src="'.$path_parent.'/assets/visuals/eye_open.png" /></button>
                    </div>
                    
                    <button class="overlay_button" type="submit">Se connecter</button>
                    <p class="switch_text">' .
                       "Vous n'avez pas de compte ?" . '
                        <a href="#" onclick="switchToSignUp()">S\'inscrire</a>
                    </p>
                </form>
        </div>
    </div>
    <div class="overlay" id="signup_overlay">
        <div class="overlay_content">
            <span class="close_btn" onclick="closeSignUpOverlay()">&times;</span>
            <h2>Inscription</h2>
            <form id="signup_form" action="'.$path_parent.'src/inscription.php" method="POST">
                <div class="input-container">
                    <input class="overlay_input" type="text" id="forenameInput" name="forename" placeholder="Prénom" required>
                    <div class="counter-container">
                        <span id="forenameCounter">0 / 50</span>
                    </div>
                </div>
                
                <div class="input-container">
                    <input class="overlay_input" type="text" id="nameInput" name="name" placeholder="Nom" required>
                    <div class="counter-container">
                        <span id="nameCounter">0 / 50</span>
                    </div>
                </div>
                
                <div class="input-container">
                    <input class="overlay_input" type="text" id="emailInputSignup" name="email" placeholder="Email" required>
                    <div class="counter-container">
                        <span id="emailCounterSignup">0 / 50</span>
                    </div>
                </div>
                
                <div class="input-container">
                    <input class="overlay_input" type="text" id="passwordInputSignup" name="password" placeholder="Mot de passe (8 caractères minimum)" required>
                    <div class="counter-container">
                        <span id="passwordCounterSignup">0 / 30</span>
                    </div>
                    <button type="button" class="toggle-password" onclick="togglePassword(\'passwordInputSignup\', this)"><img class="eye_image" src="'.$path_parent.'/assets/visuals/eye_open.png" /></button>
                </div>
                
                <div class="input-container">
                    <input class="overlay_input" type="text" id="telInput" name="tel" placeholder="Numéro de téléphone" required>
                    <div class="counter-container">
                        <span id="telCounter">0 / 15</span>
                    </div>
                </div>
                
                <button id="signup_button" class="overlay_button" type="submit">S\'inscrire</button>
                <p class="switch_text">
                    Vous avez déjà un compte ?
                    <a href="#" onclick="switchToSignIn()">Se connecter</a>
                </p>
            </form>
        </div>
    </div>
    <script src="'.$path_parent.'script/registration.js"></script>';
    }

    echo '</div>';

    // Bubble display
    echo '<div id="bubble" class="hidden"></div>';

    echo '<script src="'.$path_parent.'script/formFeatures.js"></script>';
}
?>