<?php

function displayHeader() {
    echo '
    <div class="headbar">
        <div class="headbar_left">
            <a href="../index.php">
                <img class="logo_img" src="../assets/visuals/cylanta_logo.png" alt="Logo created by MI-A team" />
            </a>
        </div>
        <div class="headbar_rest">
            <a class="headbar_item" href="../index.php">Accueil</a>
            <a class="headbar_item" href="search.php">Destinations</a>
            <a class="headbar_item" href="advanced_search.php">Rechercher un voyage</a>
        </div>';

    if (isset($_SESSION['user'])) {
        echo '
        <div class="headbar_right">
            <a class="headbar_my_space" href="userpage.php">Mon espace</a>
            <a href="userpage.php">
                <img class="user_img_nav" src="../assets/profile_pic/';

                if (file_exists('../assets/profile_pic/user' . $_SESSION['user']['id'] . '_profile_picture.jpg')) {
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
                <form action="../src/connexion.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <button type="submit">Se connecter</button>
                    <p class="switch_text">' .
                       "Vous n'avez pas de compte ?" . '
                        <a href="#" onclick="switchToSignUp()">S\'inscrire</a>
                    </p>
                </form>
        </div>
    </div>
    <script src="../includes/registration.js"></script>';
    }

    echo '</div>';
}

function displayIndexHeader() {
    echo '
    <div class="headbar">
        <div class="headbar_left">
            <a href="index.php">
                <img class="logo_img" src="assets/visuals/cylanta_logo.png" alt="Logo created by MI-A team" />
            </a>
        </div>
        <div class="headbar_rest">
            <a class="headbar_item" href="index.php">Accueil</a>
            <a class="headbar_item" href="src/search.php">Destinations</a>
            <a class="headbar_item" href="src/advanced_search.php">Rechercher un voyage</a>
        </div>';

    if (isset($_SESSION['user'])) {
        echo '
        <div class="headbar_right">
            <a class="headbar_my_space" href="src/userpage.php">Mon espace</a>
            <a href="src/userpage.php">
                <img class="user_img_nav" src="assets/profile_pic/';

                if (file_exists('assets/profile_pic/user' . $_SESSION['user']['id'] . '_profile_picture.jpg')) {
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
                <form action="src/connexion.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <button type="submit">Se connecter</button>
                    <p class="switch_text">' .
                        "Vous n'avez pas de compte ?" . '
                        <a href="#" onclick="switchToSignUp()">S\'inscrire</a>
                    </p>
                </form>
        </div>
    </div>
    <script src="includes/registration.js"></script>';
    }

    echo '</div>';
}
?>