<?php

include('../includes/profile_manager.php');

// Check that the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Vous devez être connecté pour voir les détails de votre voyage !'); window.location.href='login.php';</script>";
    exit;
}

// Retrieve transaction ID or unique identifier from URL
$purchase_id = $_GET['id'] ?? null;

if (!$purchase_id) {
    echo "<script>alert('Identifiant de voyage manquant !'); window.history.back();</script>";
    exit;
}

// Read data from purchase_data.json
$purchase_data_file = '../data/purchase_data.json';
$purchase_data = json_decode(file_get_contents($purchase_data_file), true);

// Find trip details corresponding to the ID
$purchase_details = null;
foreach ($purchase_data as $purchase) {
    if ($purchase['id'] == $purchase_id) {
        $purchase_details = $purchase;
        break;
    }
}

if (!$purchase_details) {
    echo "<script>alert('Détails du voyage non trouvés !'); window.history.back();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Détails du Voyage - CyLanta</title>
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

        <!-- Trip recapitulation -->
        <header class="recap_header">
            <h1>Détails de votre Voyage</h1>
            <p>Voici les détails complets de votre aventure</p>
        </header>

        <!-- General informations -->
        <section class="recap_general_info">
            <h2><?php echo $purchase_details['trip_title']; ?></h2>
            <div class="recap_info_box">
                <p><strong>Nombre de participants : </strong><?php echo $purchase_details['number_of_participants']; ?> personnes</p>
                <p><strong>Transport : </strong><?php echo $purchase_details['transport']; ?></p>
                <p><strong>Prix total : </strong><?php echo $purchase_details['montant']; ?>€</p>
                <p><strong>Prix par personne : </strong><?php echo round($purchase_details['montant'] / $purchase_details['number_of_participants']); ?>€</p>
                <p><strong>Date de départ : </strong><?php echo $purchase_details['start_date']; ?></p>
                <p><strong>Date de retour : </strong><?php echo $purchase_details['end_date']; ?></p>
                <p><strong>Réduction : </strong>
                <?php
                if (isset($purchase_details['reduction']) && purchase_details['reduction'] === "10%") {
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
            foreach ($purchase_details['steps'] as $step) {
                echo '
                <div class="recap_step">
                    <h3>Étape : ' . $step['title'] . '</h3>
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

        <!-- Footer -->
        <?php displayFooter(); ?>
    </div>
</body>
</html>
