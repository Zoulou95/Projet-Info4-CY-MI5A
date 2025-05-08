<?php
    // remove_from_cart.php : Deletes an item from the cart, modifies the JSON file in consequence

    require_once('error.php');
    require_once('cart_functions.php');

    // Retrieve data sent via AJAX
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['cart_id'])) {
        $cart_id = $data['cart_id'];

        // Retrieve existing data
        $cart_path = '../data/cart_history_data.json';
        $cart_data = dataDecode('../data/cart_history_data.json');

        // Filter to delete entry with transaction ID
        $updated_cart = [];
        foreach ($cart_data as $entry) {
            if ($entry['cart_id'] !== $cart_id) {
                $updated_cart[] = $entry;
            }
        }

        // Reindex the table when an element is deleted
        $updated_cart = array_values($updated_cart);

        // Save updated data
        if (file_put_contents($cart_path, json_encode($updated_cart, JSON_PRETTY_PRINT))) {
            echo json_encode([
                "status" => "success",
            ]);
        } else {
            echo json_encode([
                "status" => "error",
            ]);
        }

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "ID de transaction manquant."
        ]);
    }
?>