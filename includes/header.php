<?php
$current_file = $_SERVER['PHP_SELF'];

require_once('session_start.php');
require_once('cart_functions.php');

if (basename($current_file) === 'index.php') {
    $path_parent = "";
    $path_src = "src/";
} else {
    $path_parent = "../";
    $path_src = "";
}

echo '<script src="' . $path_parent . '/script/bubble.js"></script>';

function displayHeader() {

    global $path_parent;
    global $path_src;
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
            <a class="headbar_item" href="'.$path_src.'advanced_search.php">Rechercher un voyage</a>
        </div>';

    if (isset($_SESSION['user'])) {
        echo '
        <div class="headbar_right">
            <a class="headbar_my_space" href="'.$path_src.'cart.php">Panier';

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
            <div class="overlay" id="signinOverlay">
        <div class="overlay_content">
            <span class="close_btn" onclick="closeSignInOverlay()">&times;</span>
            <h2>Connexion</h2>
                <form action="'.$path_parent.'src/connexion.php" method="POST">
                    <input class="overlay_input" type="email" name="email" placeholder="Email" required>
                    <input class="overlay_input" type="password" name="password" placeholder="Mot de passe" required>
                    <button class="overlay_button" type="submit">Se connecter</button>
                    <p class="switch_text">' .
                       "Vous n'avez pas de compte ?" . '
                        <a href="#" onclick="switchToSignUp()">S\'inscrire</a>
                    </p>
                </form>
        </div>
    </div>
    <div class="overlay" id="signupOverlay">
        <div class="overlay_content">
            <span class="close_btn" onclick="closeSignUpOverlay()">&times;</span>
            <h2>Inscription</h2>
            <form action="'.$path_parent.'src/inscription.php" method="POST">
                <input class="overlay_input" type="text" name="forename" placeholder="Prénom" required>
                <input class="overlay_input" type="text" name="name" placeholder="Nom" required>
                <input class="overlay_input" type="email" name="email" placeholder="Email" required>
                <input class="overlay_input" type="password" name="password" placeholder="Mot de passe (8 caractères minimum)" required>
                <input class="overlay_input" type="tel" name="tel" placeholder="Numéro de téléphone" required>
                <button class="overlay_button" "type="submit">S\'inscrire</button>
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
}
?>