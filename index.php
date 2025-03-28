<?php
    session_start();

    include('includes/logs.php');
    require_once('includes/trip_functions.php');

    $data_file = 'data/trip_data.json';
?>

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
        <?php displayHeader(); ?>

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
        // Trip presentations are displayed randomly
        $id_list = [];

        while (count($id_list) < 6) {
            $num = rand(1, 15);
            if (!in_array($num, $id_list)) {
                $id_list[] = $num;
            }
        }

        displayCards($id_list, $data_file);
    ?>
    </div>

    <!-- Footer -->
    <div class="separate"></div>
    <?php displayFooter();?>
    </div>
    </div>
</body>
</html>