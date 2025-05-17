<?php
// password_update.php : update user's password using AJAX

require_once('error.php');
require_once('trip_functions.php'); // For dataReader() usage

// Security check
if (!isset($_SESSION['user'])) {
    displayError('User not found.');
    exit;
} else {
    $user_id = $_SESSION['user']['id'];
}

// Update password
if(isset($_POST['new_password']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $confirm_password = $_POST['confirm_password'];
    $password = $_POST['password'];
    $new_password = $_POST['new_password'];
    
    if($confirm_password != $new_password) {
        $response = [
            'success' => false,
            'message' => "❌ Les nouveaux mots de passe ne sont pas identiques"
        ];
        echo json_encode($response);
        exit;
    }

    if (strlen($new_password) < 8 || strlen($new_password) > 20) {
        $response = [
            'success' => false,
            'message' => "❌ Mot de passe invalide (8 à 20 caractères)"
        ];
        echo json_encode($response);
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
                $response = [
                    'success' => true,
                    'message' => "✔️ Mot de passe changé avec succès"
                ];
                echo json_encode($response);
                exit;
            } else {
                $response = [
                    'success' => false,
                    'message' => "❌ Mot de passe actuel invalide"
                ];
                echo json_encode($response);
                exit;
            }
            $user_found = 1;
            break;
        }
    }

    if($user_found == 0) {
        displayError("User not found for password change.");
        exit;
    }

} else {
    $response = [
        'success' => false,
        'message' => "❌ Modification impossible"
    ];
    echo json_encode($response);
    exit;
}
?>