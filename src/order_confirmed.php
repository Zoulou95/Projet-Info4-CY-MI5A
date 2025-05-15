<?php
session_start();
require_once('../includes/getapikey.php');
include_once('../includes/profile_manager.php');
include_once('../includes/cart_functions.php');

// Retrieve data sent by CYBank
$transaction = $_GET['transaction'] ?? '';
$montant = $_GET['montant'] ?? '';
$vendeur = $_GET['vendeur'] ?? '';
$status = $_GET['status'] ?? '';
$control_recu = $_GET['control'] ?? '';

$api_key = getAPIKey($vendeur);
$control_calcule = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

$verification = ($control_calcule === $control_recu);
?>

<?php
if ($status === 'accepted') {
    deleteCart();
}
// Header display
displayHeader();
?>

<div class="order_container">
    <header class="recap_order">
        <?php
        if ($status === 'accepted') {
            echo
            '
                    <h1>Merci pour votre réservation !</h1>
                    <p>Votre voyage est confirmé</p>
                    ';
        } else {
            echo
            '
                    <h1>Échec de la réservation</h1>
                    ';
        }
        ?>
    </header>

    <h2 class="order_text">Statut du paiement</h2>
    <?php if ($verification): ?>
        <p class="order_text">Transaction : <?php echo htmlspecialchars($transaction); ?></p>
        <p class="order_text">Montant : <?php echo htmlspecialchars($montant); ?> €</p>
        <p class="order_text">Statut : <strong><?php echo htmlspecialchars($status); ?></strong></p>
        <?php if ($status === 'accepted'): ?>
            <p class="order_text" style="color:green;">Paiement accepté. Merci pour votre achat !</p>
            <?php
            // Update loyalty points and user history
            confirmPurchaseUpdate();

            // Save complete purchase details
            $purchase_id = savePurchaseDetails();
            ?>
            <p class="order_text">Numéro de réservation: <strong><?php echo $purchase_id; ?></strong></p>
            <?php else: ?>
            <p class="order_text" style="color:red;">Paiement refusé. Veuillez réessayer.</p>
            <?php endif; ?>
            <?php else: ?>
            <p class="order_text" style="color:red;">Erreur : les données de retour sont invalides (contrôle échoué).</p>
            <?php endif; ?>
    <button class="back_to_home_button">
        <a class="back_to_index_text" href="history.php">Cliquez ici pour afficher vos voyages</a>
    </button>
</div>

<?php
// Clear the user's cart from session
if (isset($_SESSION['user_choice'])) {
    unset($_SESSION['user_choice']);
}
displayFooter();
?>
</body>

</html>