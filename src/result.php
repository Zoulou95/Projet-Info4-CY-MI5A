

<?php
    session_start();
    
    include("../includes/trip_functions.php");
    include('../includes/header.php');

    $data_file = '../data/trip_data.json';
    $data = dataDecode($data_file);
?>

<!-- result.php : result of a specific or non-specific search -->

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
        <?php displayHeader(); ?>

    <?php // Script to filter trips by a specific tag (quicksearch)

        // If the tag is included in the url, the result requested by the user may be a quick search
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
    <?php displayFooter();?>
</body>
</html>