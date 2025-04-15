<?php
    include('../includes/trip_functions.php');
    require('../includes/getapikey.php');

    // Users must be logged in to configure their trip
    if(!isset($_SESSION['user'])) {
        echo "<script>alert('Vous devez être connecté pour réserver votre voyage !'); window.history.back();</script>";
        exit;
    }

    //
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        cartToJson();
    }
?>

<!-- cart.php -->

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
        <?php
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
        
            $control = md5($api_key . "#" . $transaction_id . "#" . $montant . "#" . $vendeur . "#" . $retour_url . "#");
        ?>

        <!-- Payment -->
        <?php
            if (!$is_empty) {
                echo '<section class="recap_payment">';
                echo '<h2>Paiement</h2>';
                echo '<div class="recap_payment_details">';
                echo '<p><b>Montant total à payer : </b>';
                
                $points = $total / 100;
                echo $total . "€ (" . $points . " points fidelité)";
                $_SESSION['points_win'] = $points;
                
                echo '</p>';
                echo '<form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">';
                echo '<input type="hidden" name="transaction" value="' . $transaction_id . '">';
                echo '<input type="hidden" name="montant" value="' . $montant . '">';
                echo '<input type="hidden" name="vendeur" value="' . $vendeur . '">';
                echo '<input type="hidden" name="retour" value="' . $retour_url . '">';
                echo '<input type="hidden" name="control" value="' . $control . '"><br />';
                echo '<button type="submit" class="recap_pay_now">Payement sécurisé 🔒</button>';
                echo '</form>';
                echo '</div>';
                echo '</section>';
            } else {
                echo '<div class="separate_empty_cart">';
            }
        ?>

    <!-- Footer -->
    <?php displayFooter();?>
</div>
</body>
</html>