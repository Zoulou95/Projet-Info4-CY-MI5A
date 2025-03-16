<!-- index.php : user home and welcome page -->

<!DOCTYPE html>
<html>
<head>
    <title>CyLanta</title>
    <meta name="description" content="CyLanta travel agency website" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <meta name="keywords" content="travel, travel agency" />
    <link rel="icon" type="image/png" href="assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="css/base_style.css" />
    <link rel="stylesheet" type="text/css" href="css/index_style.css" />
</head>
<body>
    <div class="container">
        <!-- Navigation bar -->
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
            </div>
            <div class="headbar_right">
                <a class="headbar_item" href="#" onclick="openSignInOverlay()">Connexion</a>
                <a class="headbar_item" href="#" onclick="openSignUpOverlay()">S'inscrire</a>
            </div>
        </div>

        <!-- Homepage -->
        <div class="image_container">
            <img src="assets/presentation/welcome_img.jpg" alt="island welcome image">
            <div class="text_above">Cap sur vos envies, direction le sur-mesure !</div>
            <div class="text_overlay">
                <a href="src/search.php" class="btn_explorer">Explorer</a>
            </div>
        </div>
        <div class="secondbar">
            <div class="centerbar">
                <p class="centerbar_text">Laissez-vous surprendre,<br>nous créons votre plus belle aventure</p>
            </div>
        </div>
        <div class="whitebar"></div>

        <div class="voyagebar">
    <?php
    include('includes/logs.php');
    include('includes/trip_functions.php');
    $data_file = 'data/trip_data.json';

    // We choose the ids of the trips we want to display on our page
    $id_list = array("1", "10", "5", "9", "11", "12");
    // id 1 => Lune de miel Bora-Bora ; id 10 => Aventure à Tahiti
    // id 5 => Séjour en famille à Moorea ; id 9 => Expérience inédite à Huahine
    // id 12 => Aventure éco-tourisme à Nuku Hiva

    displayCards($id_list, $data_file);
    ?>
    </div>

    <!-- Footer -->
    <div class="separate"></div>
    <?php displayFooter();?>

    <!-- Signin and login overlay -->
    <div class="overlay" id="signupOverlay">
        <div class="overlay_content">
            <span class="close_btn" onclick="closeSignUpOverlay()">&times;</span>
            <h2>Inscription</h2>
            <form action="src/inscription.php" method="POST">
                <input type="text" name="prenom" placeholder="Prénom" required>
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <input type="tel" name="tel" placeholder="Numéro de téléphone" required>
                <button type="submit">S'inscrire</button>
                <p class="switch_text">
                    Vous avez deja un compte ?
                    <a href="#" onclick="switchToSignIn()">Se connecter</a>
                </p>
            </form>
        </div>
    </div>

    <div class="overlay" id="signinOverlay">
        <div class="overlay_content">
            <span class="close_btn" onclick="closeSignInOverlay()">&times;</span>
            <h2>Connexion</h2>
                <form action="src/connexion.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <button type="submit">Se connecter</button>
                    <p class="switch_text">
                        Vous n'avez pas de compte ?
                        <a href="#" onclick="switchToSignUp()">S'inscrire</a>
                    </p>
                </form>
        </div>
    </div>

    <script>
        //Functions for displaying the registration and login overlay

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
    </script>
    </div>
    </div>
</body>
</html>