<!-- confirmation.php -->

<?php
session_start();

include('../includes/trip_functions.php');
require('../includes/getapikey.php');

// Users must be logged in to configure their trip
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Vous devez être connecté pour ajouter ce voyage à votre panier !'); window.history.back();</script>";
    exit;
}

// If the user is logged in, check if a trip is already purchased
if (isset($_SESSION['user'])) {
    if (isPurchased($_SESSION['trip']['id']) == true) {
        echo "<script>alert('Vous avez déjà acheté ce voyage.'); window.history.back();</script>";
        exit();
    }
}

// Check if the user's trip configuration is valid isConfigValid()
if (isConfigValid()) {
    $trip = $_SESSION['trip'];
    $number_of_participants = intval($_POST['number_of_participants']);

    // Recalculate the total pric, it is more secure because the user can't manipulate it
    $total_price = priceCalc($trip, $number_of_participants);
    $_SESSION['total_price'] = $total_price;

    // Store all form data in the session for retrieval after payment
    $_SESSION['number_of_participants'] = $number_of_participants;
    $_SESSION['transport'] = $_POST['transports'];
    $_SESSION['flight'] = $_POST['flight'];
    $_SESSION['departure_city'] = $_POST['departure_city'];
    $nb_steps = 4;

    // Store stage data
    for ($i = 1; $i < $nb_steps; $i++) {
        $_SESSION['step_' . $i . '_hotel'] = $_POST['hotel_' . $i];
        $_SESSION['step_' . $i . '_pension'] = $_POST['pension_' . $i];
        $_SESSION['step_' . $i . '_activity'] = $_POST['activite_' . $i];
        $_SESSION['step_' . $i . '_participants'] = $_POST['participants_' . $i];
    }
} else {
    displayError("Invalid trip configuration.");
    exit;
}
?>

<!-- Header display -->
<?php displayHeader(); ?>

<!-- Trip recapitulation -->
<header class="recap_header">
    <h1>Récapitulatif de votre Voyage</h1>
    <p>Voici les détails complets de votre aventure à venir</p>
</header>

<!-- General informations -->
<section class="recap_general_info">
    <h2><?php echo $trip['title']; ?></h2>
    <div class="recap_info_box">
        <p><strong>Voyageurs : </strong><?php echo $number_of_participants; ?> personnes</p>
        <p><strong>Au départ de : </strong><?php echo $_POST['departure_city']; ?></p>
        <p><strong>Classe de cabine : </strong><?php echo $_POST['flight']; ?></p>
        <p><strong>Transport : </strong><?php echo $_POST['transports']; ?></p>
        <p><strong>Prix total : </strong><?php echo $total_price; ?>€</p>
        <p><strong>Prix par personne : </strong><?php echo round($total_price / $number_of_participants); ?>€</p>
        <p><strong>Date de départ : </strong><?php echo $trip['dates']['start_date']; ?></p>
        <p><strong>Date de retour : </strong><?php echo $trip['dates']['end_date']; ?></p>
        <p><strong>Réduction : </strong>
            <?php
            if ($_SESSION['user']['role'] == "vip") {
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
    for ($i = 1; $i < $nb_steps; $i++) {
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
    <h2>Ajout au panier</h2>
    <div class="recap_payment_details">
        <p><b>Montant total à payer : </b>
            <?php
            $points = $total_price / 100;
            echo $total_price . "€ (" . floor($points) . " points de fidelité)";
            $_SESSION['points_win'] = $points;
            ?>
        </p>
        <br />
        <form action="cart.php" method="POST">
            <input type="hidden" name="action" value="add_to_cart">
            <button type="submit" class="recap_pay_now">Ajouter au panier</button>
        </form>
    </div>
</section>

<!-- Footer -->
<?php displayFooter(); ?>
</div>
</body>

</html>