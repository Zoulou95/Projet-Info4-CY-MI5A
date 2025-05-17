<?php
include('../includes/profile_manager.php');

// Check that the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Vous devez être connecté pour voir les détails de votre voyage !'); window.location.href='login.php';</script>";
    exit;
}

// Displays details depending on whether the user is on the history or on the shopping cart
if (isset($_GET['from']) && $_GET['from'] === 'cart') {

    // Read data from purchase_data.json
    $cart_data_file = '../data/cart_history_data.json';
    $cart_data = json_decode(file_get_contents($cart_data_file), true);

    // Find trip details corresponding to the ID
    $purchase_details = null;
    foreach ($cart_data as $data) {
        if ($data['user_id'] == $_SESSION['user']['id'] && $data['trip_id'] == $_GET['id']) {
            $purchase_details = $data;
            break;
        }
    }
} else {
    $purchase_id = $_GET['id'] ?? null;

    if (!$purchase_id) {
        echo "<script>alert('Identifiant de voyage manquant !'); window.history.back();</script>";
        exit;
    }

    $purchase_data_file = '../data/purchase_data.json';
    $purchase_data = json_decode(file_get_contents($purchase_data_file), true);

    $purchase_details = null;
    foreach ($purchase_data as $purchase) {
        if ($purchase['id'] == $purchase_id) {
            $purchase_details = $purchase;
            break;
        }
    }
}

// Retrieve transaction ID or unique identifier from URL
if (!$purchase_details) {
    echo "<script>alert('Détails du voyage non trouvés !'); window.history.back();</script>";
    exit;
}
?>

<!-- purchase_details.php : provides travel booking information-->

<!-- Header display -->
<?php displayHeader(); ?>

<!-- Trip recapitulation -->
<header class="recap_header">
    <h1>Détails de votre Voyage</h1>
    <p>Voici les détails complets de votre aventure</p>
</header>

<!-- General informations -->
<section class="recap_general_info">
    <h2><?php echo $purchase_details['trip_title']; ?></h2>
    <div class="recap_info_box">
        <p><strong>Voyageurs : </strong><?php echo $purchase_details['number_of_participants']; ?> personnes</p>
        <p><strong>Au départ de : </strong><?php echo $purchase_details['departure_city']; ?></p>
        <p><strong>Classe de cabine : </strong><?php echo $purchase_details['flight']; ?></p>
        <p><strong>Transport : </strong><?php echo $purchase_details['transport']; ?></p>
        <p><strong>Prix total : </strong><?php echo $purchase_details['price']; ?>€</p>
        <p><strong>Prix par personne : </strong><?php echo round((int)$purchase_details['price'] / (int)$purchase_details['number_of_participants']); ?>€</p>
        <p><strong>Date de départ : </strong><?php echo $purchase_details['start_date']; ?></p>
        <p><strong>Date de retour : </strong><?php echo $purchase_details['end_date']; ?></p>
        <p><strong>Réduction : </strong>
            <?php
            if (isset($purchase_details['reduction']) && $purchase_details['reduction'] === "10%") {
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
    $i = 0;
    foreach ($purchase_details['steps'] as $step) {
        $i++;
        echo
        '
        <div class="recap_step">
            <h3>Étape ' . $i . ' : ' . $step['title'] . '</h3>
            <div class="recap_step_details">
                <p><strong>Hôtel : </strong>' . $step['hotel'] . '</p>
                <p><strong>Pension : </strong>' . $step['pension'] . '</p>
                <p><strong>Activité choisie : </strong>' . $step['activity'] . '</p>
                <p><strong>Participants à cette activité : </strong>' . $step['participants'] . ' personnes</p>
            </div>
        </div>
        ';
    }
    ?>
</section>

<?php
// If the trip has not yet been paid for, we propose a return to the basket page
if (isset($_GET['from']) && $_GET['from'] === 'cart') {
    echo '<button class="back_to_cart" onclick="history.back();">Retour au panier 🛒</button>';
    echo '<br /><br />';
}
?>

<!-- Footer -->
<?php displayFooter(); ?>

</div>
</body>

</html>