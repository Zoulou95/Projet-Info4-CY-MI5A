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
    <link rel="stylesheet" type="text/css" href="../css/confirmation_style.css" />
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
        $trip = $_SESSION['trip'];
        $number_of_participants = intval($_POST['number_of_participants']);

        // Calculate the total price
        $total_price = priceCalc($trip, $number_of_participants);
        $_SESSION['total_price'] = $total_price;
    } else {
        displayError("Invalid trip configuration.");
        exit;
    }
    ?>

    <!-- Trip recapitulation -->
    <header class="recap_header">
        <h1>Récapitulatif de votre Voyage</h1>
        <p>Voici les détails complets de votre aventure à venir</p>
    </header>

    <!-- General informations -->
    <section class="recap_general_info">
        <h2>Informations Générales</h2>
        <div class="recap_info_box">
            <p><strong>Nombre de participants : </strong><?php echo $number_of_participants; ?> personnes</p>
            <p><strong>Transport : </strong><?php echo $_POST['transports']; ?></p>
            <p><strong>Prix total : </strong><?php echo $total_price; ?>€</p>
            <p><strong>Prix par personne : </strong><?php echo $total_price / $number_of_participants; ?>€</p>
            <p><strong>Date de départ : </strong><?php echo $trip['dates']['start_date']; ?></p>
            <p><strong>Date de retour : </strong><?php echo $trip['dates']['end_date']; ?></p>
            <p><strong>Réduction : </strong>
            <?php
            // $_SESSION['user']['status'] == "VIP" quand ce sera set
            if(1 == 0) {
                echo "-10% sur le prix total";
            } else {
                echo "Aucune";
            }
            ?>
        </p>
        </div>
    </section>

    <section class="recap_trip_steps">
    <h2>Étapes du Voyage</h2>

    <?php
        $nb_steps = 4;
        for($i=1; $i<$nb_steps; $i++) {
            echo
            '
            <div class="recap_step">
                <h3>Étape ' . $i . ' : ' . $trip['step_' . $i]['title'] . '</h3>
                <div class="recap_step_details">
                    <p><strong>Hôtel : </strong>' . $_POST['hotel_' . $i] . '</p>
                    <p><strong>Pension : </strong>' . $_POST['pension_' . $i] . '</p>
                    <p><strong>Activité choisie : </strong>' . $_POST['activite_' . $i] . '</p>
                    <p><strong>Participants à cette activité : </strong>' . $_POST['participants_' . $i] . ' personnes</p>
                </div>
            </div>
            ';
        }
    ?>
    </section>

    <!-- Payment -->
    <section class="recap_payment">
        <h2>Paiement</h2>
        <div class="recap_payment_details">
            <p><b>Montant total à payer : </b>
            <?php
            $points = $total_price / 100;
            echo $total_price . "€ (" . $points . " points fidelité)";
            ?></p>
            <button class="recap_pay_now" onclick="window.location.href='payment.php';">Payer maintenant (Sécurisé 🔒)</button>
        </div>
    </section>

    <!-- Footer -->
    <?php displayFooter();?>
</div>
</body>
</html>