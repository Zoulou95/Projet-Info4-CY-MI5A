<?php
require_once('../includes/trip_functions.php');

$data_file = '../data/trip_data.json';
?>

<!-- search.php : allow the user to search for a non-specific trip using a destination -->

<!-- Header display -->
<?php displayHeader(); ?>

<!-- Quick search implementation -->
<video autoplay muted loop id="background-video">
    <source src="../assets/presentation/island_loop_video.mp4" type="video/mp4">
    <p class="error_text">Votre navigateur ne supporte pas la vidéo !</p>
</video>
<div class="text_above">L'aventure vous attend, où allons-nous ?</div>
<div class="search_overlay">

    <form id="search_form" class="search_form" action="result.php" method="get">
        <input type="text" class="search_input" id="search_input" list="destinations" placeholder="Recherchez un mot clé (aventure, famille, ...) 🔎" name="tag" />

        <div id="bubble" class="hidden"></div>

        <script>
            // Checks that the search field is not empty
            document.getElementById('search_form').addEventListener('submit', function(event) {

                let inputField = document.getElementById('search_input');
                if (inputField.value.trim() === '') {
                    displayBubble(event, '❌ Votre recherche est vide !');
                }
            });
        </script>
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
<?php displayFooter(); ?>
</body>

</html>