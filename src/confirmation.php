<!-- confirmation.php -->

<?php
    session_start();

    include('../includes/header.php');

    // Users must be logged in to configure their trip
    if(!isset($_SESSION['user'])) {
        echo "<script>alert('Vous devez être connecté pour configurer votre voyage !'); window.history.back();</script>";
        exit;
    }
?>

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
        <?php displayHeader(); ?>

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
        <h2><?php echo $trip['title']; ?></h2>
        <div class="recap_info_box">
            <p><strong>Nombre de participants : </strong><?php echo $number_of_participants; ?> personnes</p>
            <p><strong>Transport : </strong><?php echo $_POST['transports']; ?></p>
            <p><strong>Prix total : </strong><?php echo $total_price; ?>€</p>
            <p><strong>Prix par personne : </strong><?php echo $total_price / $number_of_participants; ?>€</p>
            <p><strong>Date de départ : </strong><?php echo $trip['dates']['start_date']; ?></p>
            <p><strong>Date de retour : </strong><?php echo $trip['dates']['end_date']; ?></p>
            <p><strong>Réduction : </strong>
            <?php
            if($_SESSION['user']['role'] == "vip") {
                echo "-10% sur le prix total (VIP)";
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
    <button class="back_to_config" onclick="history.back();">Revoir ma configuration 🔄</button>
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