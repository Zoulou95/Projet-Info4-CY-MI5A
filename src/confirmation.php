<!-- confirmation.php -->

<?php session_start(); ?>

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
    <link rel="stylesheet" type="text/css" href="../css/trip_style.css" />
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

    <?php
    include('../includes/trip_functions.php');

    if (isConfigValid()) {

        $id = $_SESSION['id'];
        $price_per_pers = intval($_SESSION['price_per_person']);
        $number_of_participants = intval($_POST['number_of_participants']);

        // Calculate the total price
        $total_price = priceCalc($price_per_pers, $number_of_participants);

        echo '<br> ID : ' . $id;
        echo '<br> Participants : ' . intval($_POST['number_of_participants']);
        echo '<br> Prix/pers : ' . $price_per_pers;
        echo '<br> Prix tot : ' . $total_price;

    } else {
        header("Location: ../src/error_page.php");
        exit;
    }
    ?>

    <!-- Footer -->
    <?php include('../includes/footer.php'); displayFooter();?>
</div>
</body>
</html>