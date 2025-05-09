<?php
require_once('error.php');
require_once('session_start.php');

// Read the 'user_data.json' file and convert it into a PHP array
function dataReader($data_file) {
    if (file_exists($data_file)) {
        $json_data = file_get_contents($data_file);
        $data = json_decode($json_data, true); 
    }  
    else
    {
        displayError("'user_data.json' file is missing.");
    }

    // Verification of data structure
    if (!isset($data) || !is_array($data)) {
        displayError("data decode failed.");
    }

    return $data;
}

// Update account informations
function updateInfo($data, $data_file) {
    if(isset($_SESSION['user'])) {
        // Change the user role to VIP if he has enough fidelity points
        if($_SESSION['user']['role'] === "standard" && $_SESSION['user']['points'] >= 300) {
            $user_id = $_SESSION['user']['id'];

            // Find user and update information
            foreach ($data as $key => $user) {
                if ($user['id'] == $user_id) {
                    $data[$key]['role'] = "vip";
                }
            }

            $_SESSION['user']['role'] = "vip";

            // Update travel history
            if(isset($data[$key]['travel_history'])) {
                $_SESSION['user']['travel_history'] = $data[$key]['travel_history'];
            }

            // Save new data to JSON file
            $new_json_data = json_encode($data, JSON_PRETTY_PRINT);
            if (!file_put_contents($data_file, $new_json_data)) {
                displayError("Error updating user_data.json file.");
            }
        }
    } else {
        echo "<script>alert('Vous devez être connecté pour réserver votre voyage !'); window.history.back();</script>";
        exit;
    }
}

// Update password
function updatePassword() {
    if(isset($_POST['new_password']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $confirm_password = $_POST['confirm_password'];
        $password = $_POST['password'];
        $new_password = $_POST['new_password'];
        
        if($confirm_password != $new_password) {
            echo "<script>alert('Les mots de passe ne sont pas identiques.'); window.history.back();</script>";
            exit;
        }

        if (strlen($new_password) < 8) {
            echo "<script>alert('Votre nouveau mot de passe doit contenir au moins 8 caractères.'); window.history.back();</script>";
            exit;
        }

        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $data_file = "../data/user_data.json";
        $data = dataReader($data_file);

        $user_id = $_SESSION['user']['id'];
        $user_found = 0;

        // Find user and update information
        foreach ($data as $key => $user) {
            if ($user['id'] == $user_id) {

                if(password_verify($password, $data[$key]['password'])) {
                    $data[$key]['password'] = $new_hashed_password;

                    // Save new data to JSON file
                    $new_json_data = json_encode($data, JSON_PRETTY_PRINT);
                    if (!file_put_contents($data_file, $new_json_data)) {
                        displayError("Error updating user_data.json file.");
                    }

                    echo "<script>alert('Mot de passe changé avec succès.'); window.history.back();</script>";
                    exit;
                } else {
                    echo "<script>alert('Votre mot de passe actuel est erroné.'); window.history.back();</script>";
                    exit;
                }
                $user_found = 1;
                break;
            }
        }
        if($user_found == 0) {
            displayError("User not found for password change.");
        }
    } else {
        displayError("Password modification failed.");
    }
}

// Find a trip with its id
function tripFinder($data, $trip_id) {
    // Check that the trip match the ID in 'trip_data.json'
    $trip = null;
    foreach ($data['trip'] as $journey) {
        if ($journey['id'] == $trip_id) {
            $trip = $journey;
            break;
        }
    }
    if ($trip === null) {
        echo "<script>alert('Erreur lors de la réception des données'); window.history.back();</script>";
        error_log("ERROR: trip not found.");
    }
    return $trip;
}

// Update a user's loyalty points and travel history
function confirmPurchaseUpdate() {
    $data_file = "../data/user_data.json";
    $data = dataReader($data_file);

    $user_id = $_SESSION['user']['id'];
    $user_found = 0;

    // Find user and update information
    foreach ($data as $key => $user) {
        if ($user['id'] == $user_id) {
            $_SESSION['user']['points'] += $_SESSION['points_win'];
            $data[$key]['points'] = $_SESSION['user']['points'];

            // Create an empty array if necessary
            if (!isset($data[$key]['travel_history']) || !is_array($data[$key]['travel_history'])) {
                $data[$key]['travel_history'] = []; 
            }

            for ($i = 0; $i < count($_SESSION['user_choice']); $i++) {
                $data[$key]['travel_history'][] = $_SESSION['user_choice'][$i]['trip_id'];
            }

            // Save new data to JSON file
            $new_json_data = json_encode($data, JSON_PRETTY_PRINT);
            if (!file_put_contents($data_file, $new_json_data)) {
                displayError("Error updating user_data.json file.");
            }

            $user_found = 1;
            break;
        }
    }
    if($user_found == 0) {
        displayError("User not found for update profile after purchase.");
    }
}

// Save in 'purchase_data.json' all purchase details
function savePurchaseDetails() {
    // Check if the file purchase_data.json exists, if not create it
    $purchase_file = "../data/purchase_data.json";
    if (file_exists($purchase_file)) {
        $purchases = json_decode(file_get_contents($purchase_file), true);
        if (!is_array($purchases)) {
            $purchases = [];
        }
    } else {
        $purchases = [];
    }

    // Retrieve all transaction data from the session and GET
    for ($i = 0; $i < count($_SESSION['user_choice']); $i++) {

        $purchase_data = $_SESSION['user_choice'][$i];

        $purchase_data['id'] = uniqid('purchase_');
        $purchase_data['purchase_date'] = date("Y-m-d H:i:s");
        $purchase_data['transaction_id'] = $_GET['transaction'] ?? '';
        $purchase_data['transaction_status'] = $_GET['status'] ?? '';
        
        // Add purchase data to table
        $purchases[] = $purchase_data;
        
        // Save file
        file_put_contents($purchase_file, json_encode($purchases, JSON_PRETTY_PRINT));
    }

    return $purchase_data['id'] ?? null;
}

// Displays trip history from purchase_data.json and trip_data.json files
function displayPurchaseHistory($user_id, $purchase_file) {
    if (file_exists($purchase_file)) {
        $purchases = json_decode(file_get_contents($purchase_file), true);
        $trip_data_file = '../data/trip_data.json';
        $trip_data = dataReader($trip_data_file);

        if (!is_array($purchases) || empty($purchases)) {
            echo '<h1 class="history_text"><b>Aucun voyage réservé 😭</b></h1>';
            return;
        }

        // Filter purchases for current user
        $user_purchases = array_filter($purchases, function($purchase) use ($user_id) {
            return $purchase['user_id'] == $user_id;
        });

        if (empty($user_purchases)) {
            echo '<h1 class="history_text"><b>Aucun voyage réservé 😭</b></h1>';
            return;
        }

        echo '<h1 class="history_text"><b>Historique de vos voyages</b></h1>';
        echo '<p class="fidelity_text">Points de fidelité  : <b>' . $_SESSION["user"]["points"] . '</b></p>';
        echo '<br /><br />';
        echo '<div class="card-container">';

        foreach ($user_purchases as $purchase) {
        // Retrieve complete trip details from trip_data.json
            $trip = tripFinder($trip_data, $purchase['trip_id']);

            if ($trip) {
                echo
                '<div class="card">
                    <img src="../assets/presentation/' . $trip['presentation_img_1'] . '" alt="Trip image" />
                    <div class="card_content">
                        <h2>' . $purchase['trip_title'] . '</h2>
                        <p><b>Dates: </b>' . $purchase['start_date'] . ' au ' . $purchase['end_date'] . '</p>
                        <a href="../src/purchase_details.php?id=' . $purchase['id'] . '" class="explore">➤ Consulter ma réservation</a>
                    </div>
                </div>';
            }
        }
        echo '</div>';
    } else {
        displayError("Le fichier purchase_data.json est introuvable.");
    }
}
?>