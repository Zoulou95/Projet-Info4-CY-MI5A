<?php
session_start();
require('../includes/getapikey.php');

$transaction_id = uniqid(); 
$montant = $_SESSION['total_price'];
$vendeur = "MI-5_A"; 


$retour_url = "http://localhost:8000/src/retour_paiement.php?session=" . session_id();

$api_key = getAPIKey($vendeur);
if (!preg_match("/^[0-9a-zA-Z]{15}$/", $api_key)) {
    die("Clé API invalide pour le vendeur spécifié.");
}

$control = md5($api_key . "#" . $transaction_id . "#" . $montant . "#" . $vendeur . "#" . $retour_url . "#");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Paiement - CyLanta</title>
</head>
<body>
    <h1>Procéder au paiement</h1>
    <p>Montant à régler : <?php echo $montant; ?> €</p>

    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        <input type="hidden" name="transaction" value="<?php echo $transaction_id; ?>">
        <input type="hidden" name="montant" value="<?php echo $montant; ?>">
        <input type="hidden" name="vendeur" value="<?php echo $vendeur; ?>">
        <input type="hidden" name="retour" value="<?php echo $retour_url; ?>">
        <input type="hidden" name="control" value="<?php echo $control; ?>">
        <input type="submit" value="Valider et payer">
    </form>
</body>
</html>
