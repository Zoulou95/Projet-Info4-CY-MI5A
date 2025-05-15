<?php
include('../includes/trip_functions.php');
require('../includes/getapikey.php');

// Users must be logged in to configure their trip
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Vous devez être connecté pour réserver votre voyage !'); window.history.back();</script>";
    exit;
}

// If a data entry is detected, a new shopping cart entry is created in the JSON file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
        // Reload page to avoid writing conflicts when adding a trip to the cart
        cartToJson();
        header("Location: cart.php");
        exit;
    }
}
?>

<!-- cart.php : display user's cart -->

<?php
// Load the js-md5 library to enable md5 hashing in JavaScript
echo '<script src="https://cdn.jsdelivr.net/npm/js-md5@0.7.3/src/md5.min.js"></script>';

// Header display
displayHeader();
$total = displayCart($_SESSION['user']['id'], '../data/cart_history_data.json');

$transaction_id = uniqid();
$montant = $total;
$vendeur = "MI-5_A";

$retour_url = "http://localhost:8000/src/order_confirmed.php?session=" . session_id();

$api_key = getAPIKey($vendeur);
if (!preg_match("/^[0-9a-zA-Z]{15}$/", $api_key)) {
    die("Clé API invalide pour le vendeur spécifié.");
}

// Prepare data to dynamically allocate a control key in the event of deletion from the basket
echo '<script>';
echo 'const apiKey = "' . $api_key . '";';
echo "const retourUrl = 'http://localhost:8000/src/order_confirmed.php?session=" . session_id() . "';";
echo '</script>';

$control = md5($api_key . "#" . $transaction_id . "#" . $montant . "#" . $vendeur . "#" . $retour_url . "#");
?>

<!-- Payment -->
<?php
if (!$is_empty) {
    echo '<section class="recap_payment">';
    echo '<h2>Paiement</h2>';
    echo '<div class="recap_payment_details">';
    echo '<p><b>Montant total : </b>';

    echo '<div id="price_display">';

    $points = $total / 100;
    echo $total . "€ (" . floor($points) . " points de fidelité)";
    $_SESSION['points_win'] = $points;

    echo '</div>';

    echo '</p>';
    echo '<form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">';
    echo '<input id="transaction" type="hidden" name="transaction" value="' . $transaction_id . '">';
    echo '<input id="montant" type="hidden" name="montant" value="' . $montant . '">';
    echo '<input id="vendeur" type="hidden" name="vendeur" value="' . $vendeur . '">';
    echo '<input id="retour_url" type="hidden" name="retour" value="' . $retour_url . '">';
    echo '<input id="control" type="hidden" name="control" value="' . $control . '"><br />';
    echo '<button type="submit" class="recap_pay_now">Payement sécurisé 🔒</button>';
    echo '</form>';
    echo '</div>';
    echo '</section>';
} else {
    echo '<div class="separate_empty_cart">';
}

echo '</div>';
?>

<!-- Footer -->
<?php displayFooter(); ?>
</div>

<?php
// Load shopping cart removal script 
echo '<script src="../script/removeCart.js"></script>';
?>

</body>

</html>