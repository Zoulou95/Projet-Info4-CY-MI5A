<?php
    session_start();
    
    include('../includes/trip_functions.php');
    include('../includes/header.php');

    $data_file = '../data/trip_data.json';
?>

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
    <link rel="stylesheet" type="text/css" href="../css/base_style.css" />
    <link rel="stylesheet" type="text/css" href="../css/search_style.css" />
</head>
<body>
    <div class="container">
        <!-- Navigation bar -->
        <?php displayHeader(); ?>

        <!-- Quick search implementation -->
        <video autoplay muted loop id="background-video">
            <source src="../assets/presentation/island_loop_video.mp4" type="video/mp4">
            <p class="error_text">Votre navigateur ne supporte pas la vidéo !</p>
        </video>
        <div class="text_above">L'aventure vous attend, où allons-nous ?</div>
        <div class="search_overlay">
            <form class="search_form" action="result.php" method="get">
                <input type="text" class="search_input" list="destinations" placeholder="Recherchez un mot clé... 🔎" name="tag" />
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
        // Trip presentations are displayed randomly
        $id_list = [];

        while (count($id_list) < 5) {
            $num = rand(1, 15);
            if (!in_array($num, $id_list)) {
                $id_list[] = $num;
            }
        }

        displayCards($id_list, $data_file);
    ?>
    </div>

    <!-- Footer -->
    <?php displayFooter();?>
</body>
</html>