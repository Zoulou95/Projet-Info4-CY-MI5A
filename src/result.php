<!-- result.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta user informations page" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="base_style.css" />
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

<?php // Script to filter trips by a specific tag (quicksearch)
    include("trip_functions.php");

    // If the tag is included in the url, the result requested by the user is a quick search
    if (isset($_GET['tag'])) {
        $tag = urldecode(trim($_GET['tag']));
        $tag = strtolower($tag);
        $tag = addslashes($tag);
        $tag = str_replace(' ', '', $tag);

        $data_file = '../data/trip_data.json';
        $data = dataDecode($data_file);
    
        $trip_number = getTripNumber($data, $tag);
    
        // Shows travel cards matching the search
        displayTrip($data, $tag, $trip_number);
    }


?>

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
                <a href="https://cytech.cyu.fr/" target="_blank"><img src="../assets/visuals/cytech_icon.png"alt="Partenaire 2" /></a>
                <a href="https://www.cergy.fr/accueil/" target="_blank"><img src="../assets/visuals/cergy_ville.jpg" alt="Partenaire 3" /></a>
            </div>
        </div>
    </footer>
</body>
</html>