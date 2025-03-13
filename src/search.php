<!-- search.php : allow the user to search for a non-specific trip using a destination -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta travel agency website" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <meta name="keywords" content="voyage, agence de voyage, séjour, escapade, vacances, rechercher une destination" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="base_style.css" />
    <link rel="stylesheet" type="text/css" href="search_style.css" />
</head>
<body>
    <div class="container">
        <!-- Navigation bar -->
        <div class="headbar">
            <div class="headbar_left">
                <a href="../index.php">
                    <img class="logo_img" src="../assets/visuals/cylanta_logo.png" alt="CyLanta Logo" />
                </a>
            </div>
            <div class="headbar_rest">
                <a class="headbar_item" href="../index.php">Accueil</a>
                <a class="headbar_item" href="search.php">Destinations</a>
                <a class="headbar_item" href="advanced_search.php">Rechercher un voyage</a>
            </div>
            <div class="headbar_right">
                <a class="headbar_my_space" href="userpage.php">Mon espace</a>
                <a href="userpage.php"><img class="user_img_nav" src="../assets/profile_pic/example_pfp.jpg" alt="User's profile picture" /></a>
            </div>
        </div>

        <!-- Quick search implementation -->
        <video autoplay muted loop id="background-video">
            <source src="../assets/presentation/island_loop_video.mp4" type="video/mp4">
            <p class="error_text">Votre navigateur ne supporte pas la vidéo !</p>
        </video>
        <div class="text_above">L'aventure vous attend, où allons-nous ?</div>
        <div class="search_overlay">
            <form class="search_form" action="result.php" method="get">
                <input type="text" class="search_input" list="destinations" placeholder="Recherchez votre prochaine aventure... 🔎" name="tag" />
                <button class="button_validate" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
    
    <div class="advanced_search_block">
        <img class="trip_img" src="../assets/presentation/pres_trip_img.jpg" alt="Image of a hotel in Bora Bora" />
        <div class="advanced_search_text">
            <p>Vous cherchez un voyage en particulier ?</p>

            <!-- We use 'oneclick' so when the button is clicked, it takes you to advanced_search.php -->
            <button class="advanced_search_button" onclick="window.location.href='advanced_search.php'">
                <a href="advanced_search.php">Cliquez ici pour accéder à la recherche avancée</a>
                <img class="advanced_search_image" src="../assets/visuals/magnifying_glass_logo.png" />
            </button>
        </div>
    </div>

    <!-- Quick access to destinations -->
    <div class="whitebar_destination">
    <?php
        include('../scripts/trip_functions.php');
        $data_file = '../data/trip_data.json';

        // We choose the ids of the trips we want to display on our page
        $id_list = array("13", "15", "8", "7", "6");
        // id 13 => Séjour Tetiaroa
        // id 15 => Exploration Sous-Marine
        // id 8 => Séjour romantique Bora-Bora
        // id 7 => Évasion à Fakarava
        // id 6 => Aventure à Taha'a

        displayCards($id_list, $data_file);
    ?>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer_section">
            <h3>À Propos</h3>
            <p>Chez CyLanta, nous concevons des voyages sur mesure, uniques et adaptés à vos envies.
                Passionnés d'évasion et grâce à notre réseau de partenaires, nous sélectionnons pour vous les meilleures
                adresses et activités exclusives.
                Que ce soit un safari, un road trip ou un séjour bien-être, chaque voyage est pensé dans les moindres
                détails. Votre aventure commence ici !
            </p>
        </div>
        <div class="footer_section">
            <h3>Nos Contacts</h3>
            <ul class="other">
                <li><a href="mailto:CyLanta@cy-tech.fr">Email: CyLanta@cy-tech.fr</a></li>
                <li><a href="tel:+33123456789">Téléphone: +33 1 23 45 67 89</a></li>
                <li><a href="https://www.google.com/maps?q=49.035290202793036, 2.070567152915135" target="_BLANK">Adresse: Av. du Parc, 95000 Cergy</a></li>
            </ul>
        </div>
        <div class="footer_section">
            <h3>Nos Partenaires</h3>
            <div class="partners">
                <a href="https://www.cyu.fr/" target="_blank"><img src="../assets/visuals/cy_favicon.png" alt="Partenaire 1" /></a>
                <a href="https://cytech.cyu.fr/" target="_blank"><img src="../assets/visuals/cytech_icon.png" alt="Partenaire 2" /></a>
                <a href="https://www.cergy.fr/accueil/" target="_blank"><img src="../assets/visuals/cergy_ville.jpg" alt="Partenaire 3" /></a>
            </div>
        </div>
    </footer>
</body>
</html>