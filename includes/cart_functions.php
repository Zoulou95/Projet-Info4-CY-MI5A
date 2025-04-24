<?php

require_once('error.php');
require_once('trip_functions.php');

// Display the number of items in the user's cart on the navigation bar
function cartHeader($id) {
    $data = dataDecode($_SERVER['DOCUMENT_ROOT'] . '/data/cart_history_data.json');
    $count = 0;

    // Check for existing trip
    if($data != NULL) {
        foreach ($data as $key) {
            if ($key['user_id'] === $id) {
                $count++;
            }
        }
    }

    return $count;
}

// Write user cart data in 'cart_history_data.json' in order to save it
function cartToJson() {
    $file = '../data/cart_history_data.json';

    // Prepare data to write
    $cart_data = [
        'user_id' => $_SESSION['user']['id'],
        'user_name' => $_SESSION['user']['name'] . ' ' . $_SESSION['user']['forename'],
        'trip_id' => $_SESSION['trip']['id'],
        'trip_title' => $_SESSION['trip']['title'],
        'price' => $_SESSION['total_price'],
        'number_of_participants' => $_SESSION['number_of_participants'] ?? 0,
        'start_date' => $_SESSION['trip']['dates']['start_date'],
        'end_date' => $_SESSION['trip']['dates']['end_date'],
        'flight' => $_SESSION['flight'],
        'departure_city' => $_SESSION['departure_city'],
        'steps' => [
            'step_1' => [
                'title' => $_SESSION['trip']['step_1']['title'],
                'hotel' => $_SESSION['step_1_hotel'] ?? '',
                'pension' => $_SESSION['step_1_pension'] ?? '',
                'activity' => $_SESSION['step_1_activity'] ?? '',
                'participants' => $_SESSION['step_1_participants'] ?? ''
            ],
            'step_2' => [
                'title' => $_SESSION['trip']['step_2']['title'],
                'hotel' => $_SESSION['step_2_hotel'] ?? '',
                'pension' => $_SESSION['step_2_pension'] ?? '',
                'activity' => $_SESSION['step_2_activity'] ?? '',
                'participants' => $_SESSION['step_2_participants'] ?? ''
            ],
            'step_3' => [
                'title' => $_SESSION['trip']['step_3']['title'],
                'hotel' => $_SESSION['step_3_hotel'] ?? '',
                'pension' => $_SESSION['step_3_pension'] ?? '',
                'activity' => $_SESSION['step_3_activity'] ?? '',
                'participants' => $_SESSION['step_3_participants'] ?? ''
            ]
        ],
        'transport' => $_SESSION['transport'] ?? '',
        'points_earned' => $_SESSION['points_win'] ?? 0
    ];

    // Load existing data
    $existing_data = [];
    if (file_exists($file)) {
        $json_content = file_get_contents($file);
        $existing_data = json_decode($json_content, true);
    }

    $updated = false;

    // Check for existing trip to update
    foreach ($existing_data as $key => $entry) {
        if ($entry['user_id'] == $_SESSION['user']['id'] && $entry['trip_id'] == $_SESSION['trip']['id']) {
            $existing_data[$key] = $cart_data;
            $updated = true;
            break;
        }
    }

    // If not found, add new cart
    if (!$updated) {
        $existing_data[] = $cart_data;
    }

    // Save updated content
    $new_json = json_encode($existing_data, JSON_PRETTY_PRINT);
    if (!file_put_contents($file, $new_json)) {
        displayError("'cart_history_data.json' file is missing.");
    }
}

// Displays user cart
function displayCart($user_id, $data_file) {
    global $is_empty;
    $is_empty = 0;

    $total = 0;

    if (file_exists($data_file)) {
        $cart = json_decode(file_get_contents($data_file), true);
        $trip_data_file = '../data/trip_data.json';
        $trip_data = dataReader($trip_data_file);
        
        $_SESSION['user_choice'] = [];

        if (!is_array($cart) || empty($cart)) {
            echo '<h1 class="cart_title">Votre panier est vide</h1>';
            echo '<p class="cart_desc">Retrouvez ici les voyages que vous avez configuré</p>';
            echo "<button class=\"back_to_index_button\" onclick=\"window.location.href='search.php'\">
            <a class=\"back_to_index_text\" href=\"search.php\">Cliquez ici pour rechercher un voyage</a> 
            </button>";
            $is_empty = 1;
            return;
        }

        // Filter cart for current user
        $user_cart = array_filter($cart, function($entry) use ($user_id) {
            return $entry['user_id'] == $user_id;
        });

        if (empty($user_cart)) {
            echo '<h1 class="cart_title">Votre panier est vide</h1>';
            echo '<p class="cart_desc">Retrouvez ici les voyages que vous avez configuré</p>';
            echo "<button class=\"back_to_index_button\" onclick=\"window.location.href='search.php'\">
            <a class=\"back_to_index_text\" href=\"search.php\">Cliquez ici pour rechercher un voyage</a> 
            </button>";
            $is_empty = 1;
            return;
        }

        echo '<h1 class="cart_title">Mon panier 🛒</h1>';
        echo '<p class="cart_desc">Retrouvez ici les voyages que vous avez configuré</p>';
        echo '<br /><br />';
        echo '<div class="card_container">';

        foreach ($user_cart as $entry) {
        
            // Retrieve complete trip details from trip_data.json
            $trip = tripFinder($trip_data, $entry['trip_id']);

            echo '<script src="../script/removeTripFromCart.js"></script>';

            if ($trip) {
                echo
                '<div class="card">
                    <div class="remove_bubble">
                        <span class="remove_cross" onclick="removeTripFromCart(' . $entry['trip_id'] . ')">🗑️</span>
                    </div>
                    <img src="../assets/presentation/' . $trip['presentation_img_1'] . '" alt="Trip image" />
                    <div class="card_content">
                        <h2>' . $trip['title'] . '</h2>
                        <p>Dates: <b>' . $trip['dates']['start_date'] . '</b> au <b>' . $trip['dates']['end_date'] . '</b></p>
                        <p>Prix total: <b>' . $entry['price'] . '€</b></p>
                        <a href="trip.php?id=' . $trip['id'] . '" class="explore">➤ Modifier votre voyage</a>
                        <br />
                        <a href="purchase_details.php?id=' . $entry['trip_id'] . '&from=cart" class="explore_details">➤ Voir les détails</a>
                    </div>
                </div>';
                $total += $entry['price'];

                // Recover trips from cart for travel history at time of purchase
                $trip_ids = array_column($_SESSION['user_choice'], 'trip_id'); // Extract all trip_ids from session
                if (!in_array($entry['trip_id'], $trip_ids)) {
                    $_SESSION['user_choice'][] = $entry; // Add only if the trip_id is not already in the session
                }
            }
        }
        echo '</div>';
    } else {
        displayError($data_file . 'is missing.');
    }
    return $total;
}

// Delete user's cart after purchase
function deleteCart() {
    $purchase_file = $_SERVER['DOCUMENT_ROOT'] . '/data/cart_history_data.json';
    $purchases = dataDecode($purchase_file);

    $user_id = $_SESSION['user']['id'];
    
    // Filter the array to remove the entry with matching user_id
    $new_purchases = array_filter($purchases, function ($purchase) use ($user_id) {
        return !($purchase['user_id'] === $user_id);
    });

    // Reset array keys
    $new_purchases = array_values($new_purchases);

    // Save the updated data
    file_put_contents($purchase_file, json_encode($new_purchases, JSON_PRETTY_PRINT));
}
?>