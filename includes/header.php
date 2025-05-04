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
            <button id="darkModeToggle" style="background: none; border: none; font-size: 2.5vh; color: white; cursor: pointer;">
             🌙 Mode Sombre
             </button>
              <script src="'.$path_parent.'script/darkmode.js"></script>
              <script src="'.$path_parent.'script/formFeatures.js"></script>
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
    
    
        <div class="overlay" id="signinOverlay">
            <div class="overlay_content">
                <span class="close_btn" onclick="closeSignInOverlay()">&times;</span>
                <h2>Connexion</h2>
                <form action="path_to_connexion.php" method="POST">
                    <div class="input_wrapper">
                        <input class="overlay_input" type="email" name="email" id="emailInputLogin" placeholder="Email" maxlength="50" required>
                        <span class="char_counter" id="emailCounterLogin">0 / 50</span>
                    </div>
                    <div class="input_wrapper">
                        <input class="overlay_input" type="password" name="password" id="passwordInputLogin" placeholder="Mot de passe" maxlength="30" required>
                        <button type="button" class="toggle_password" onclick="togglePassword(\'passwordInputLogin\', this)">Afficher</button>
                        <span class="char_counter" id="passwordCounterLogin">0 / 30</span>
                    </div>
    
                    <button class="overlay_button" type="submit">Se connecter</button>
                    <p class="switch_text">
                        Vous n\'avez pas de compte ?
                        <a href="#" onclick="switchToSignUp()">S\'inscrire</a>
                    </p>
                </form>
            </div>
        </div>
    
        <!-- Overlay d\'Inscription -->
        <div class="overlay" id="signupOverlay">
            <div class="overlay_content">
                <span class="close_btn" onclick="closeSignUpOverlay()">&times;</span>
                <h2>Inscription</h2>
                <form action="path_to_inscription.php" method="POST">
                    <div class="input_wrapper">
                        <input class="overlay_input" type="text" name="forename" id="forenameInput" placeholder="Prénom" maxlength="50" required>
                        <span class="char_counter" id="forenameCounter">0 / 50</span>
                    </div>
                    <div class="input_wrapper">
                        <input class="overlay_input" type="text" name="name" id="nameInput" placeholder="Nom" maxlength="50" required>
                        <span class="char_counter" id="nameCounter">0 / 50</span>
                    </div>
    
                    <div class="input_wrapper">
                        <input class="overlay_input" type="email" name="email" id="emailInputSignup" placeholder="Email" maxlength="50" required>
                        <span class="char_counter" id="emailCounterSignup">0 / 50</span>
                    </div>
    
                    <div class="input_wrapper">
                        <input class="overlay_input" type="password" name="password" id="passwordInputSignup" placeholder="Mot de passe (8 caractères minimum)" minlength="8" maxlength="30" required>
                        <button type="button" class="toggle_password" onclick="togglePassword(\'passwordInputSignup\', this)">Afficher</button>
                        <span class="char_counter" id="passwordCounterSignup">0 / 30</span>
                    </div>
    
                    <div class="input_wrapper">
                        <input class="overlay_input" type="tel" name="tel" id="telInput" placeholder="Numéro de téléphone" maxlength="15" required>
                        <span class="char_counter" id="telCounter">0 / 15</span>
                    </div>
                    <button class="overlay_button" type="submit">S\'inscrire</button>
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