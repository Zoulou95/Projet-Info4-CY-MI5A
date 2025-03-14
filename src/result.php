<!-- result.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta user informations page" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="../css/base_style.css" />
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
    include("../includes/trip_functions.php");

    $data_file = '../data/trip_data.json';
    $data = dataDecode($data_file);

    // If the tag is included in the url, the result requested by the user is a quick search
    if (!empty($_GET['tag'])) {
        $tag = urldecode(trim($_GET['tag']));
        $tag = htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); // Escape special characters: XSS protection
        $tag = strtolower($tag);
        $tag = addslashes($tag);
        $tag = str_replace(' ', '', $tag);
    
        $trip_number = getTripNumber($data, $tag);
    
        // Shows travel cards matching the search
        displayByTag($data, $tag, $trip_number);
    }

    // If the tag is not included in the url, the result requested by the user is a specific search
    else if (isValidAdvancedSearch()) {
        // Shows travel cards matching the search
        displayByFilter($data);
    } else {
        displayNoResult();
    }

?>
    <!-- Footer -->
    <div class="separate"></div>
    <?php include('../includes/footer.php'); displayFooter();?>
</body>
</html>