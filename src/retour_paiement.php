<?php
session_start();
require('../includes/getapikey.php');

// Récupération des données envoyées par CYBank
$transaction = $_GET['transaction'] ?? '';
$montant = $_GET['montant'] ?? '';
$vendeur = $_GET['vendeur'] ?? '';
$status = $_GET['status'] ?? '';
$control_recu = $_GET['control'] ?? '';

$api_key = getAPIKey($vendeur);
$control_calcule = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

$verification = true;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Résultat du paiement</title>
</head>
<body>
    <h1>Statut du paiement</h1>
    <?php if ($verification): ?>
        <p>Transaction : <?php echo htmlspecialchars($transaction); ?></p>
        <p>Montant : <?php echo htmlspecialchars($montant); ?> €</p>
        <p>Statut : <strong><?php echo htmlspecialchars($status); ?></strong></p>
        <?php if ($status === 'accepted'): ?>
        
            <p style="color:green;">Paiement accepté. Merci pour votre achat !</p>
        <?php else: ?>
            <p style="color:red;">Paiement refusé. Veuillez réessayer.</p>
        <?php endif; ?>
    <?php else: ?>
        <p style="color:red;">Erreur : les données de retour sont invalides (contrôle échoué).</p>
    <?php endif; ?>
    <a href="index.php">Retour à l'accueil</a>
</body>
</html>