<?php

include('includes/logs.php');
require_once('includes/trip_functions.php');

$data_file = 'data/trip_data.json';
?>

<!-- index.php : user home and welcome page -->

<!-- Header display -->
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
<?php displayFooter(); ?>
</div>
</div>
</body>

</html>