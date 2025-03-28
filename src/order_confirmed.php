<?php
session_start();
require('../includes/getapikey.php');
require_once('../includes/profile_manager.php');

// Récupération des données envoyées par CYBank
$transaction = $_GET['transaction'] ?? '';
$montant = $_GET['montant'] ?? '';
$vendeur = $_GET['vendeur'] ?? '';
$status = $_GET['status'] ?? '';
$control_recu = $_GET['control'] ?? '';

$api_key = getAPIKey($vendeur);
$control_calcule = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

$verification = ($control_calcule === $control_recu);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta - Confirmation de paiement</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta user informations page" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="../css/base_style.css" />
    <link rel="stylesheet" type="text/css" href="../css/confirmation_style.css" />
</head>
<body>
    <?php displayHeader(); ?>

    <div class="order_container">
        <header class="recap_order">
            <h1>Merci pour votre réservation !</h1>
            <p>Votre voyage est confirmé</p>
        </header>

        <h2 class="order_text">Statut du paiement</h2>
        <?php if ($verification): ?>
            <p class="order_text">Transaction : <?php echo htmlspecialchars($transaction); ?></p>
            <p class="order_text">Montant : <?php echo htmlspecialchars($montant); ?> €</p>
            <p class="order_text">Statut : <strong><?php echo htmlspecialchars($status); ?></strong></p>
            <?php if ($status === 'accepted'): ?>
                <p class="order_text" style="color:green;">Paiement accepté. Merci pour votre achat !</p>
                <?php
                // Update a user's loyalty points and travel history
                confirmPurchaseUpdate();
                ?>
            <?php else: ?>
                <p class="order_text" style="color:red;">Paiement refusé. Veuillez réessayer.</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="order_text" style="color:red;">Erreur : les données de retour sont invalides (contrôle échoué).</p>
        <?php endif; ?>

        <button class="back_to_index_button">
            <a class="back_to_index_text" href="history.php">Cliquez ici pour afficher vos voyages</a>
        </button>
    </div>

    <?php displayFooter(); ?>
</body>
</html>