<!-- order_confirmed.php : give to the user a confirmation of his order -->

<?php
    session_start();
    include('../includes/header.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta user informations page" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="../css/base_style.css" />
    <link rel="stylesheet" type="text/css" href="../css/confirmation_style.css" />
</head>
<body>
    <?php require('../includes/footer.php'); ?>
    <div class="container">
        <!-- Navigation bar -->
        <?php displayHeader(); ?>

    <!-- Order confirmed message -->
    <header class="recap_order">
        <h1>Merci pour votre réservation !</h1>
        <p> Votre voyage est confirmé</p>
    </header>

    <!-- Back to index button  -->
    <button class="back_to_index_button">
        <a class="back_to_index_text" href="userpage.php">Cliquez ici pour afficher vos voyages</a>
    </button>

    <!-- Footer -->
    <?php displayFooter(); ?>
</div>
</body>
</html>