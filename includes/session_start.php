<?php
session_start();

require_once('profile_manager.php');
require_once('error.php');

if (isset($_SESSION["user"]["id"]) && isset($_COOKIE["id"])) {
    return;
}

$secret_key = "kYVnImGiLR"; // Encryption key
$iv = "1234567890123456"; // Initialization vector (16 characters)

// Encrypt the ID (avoid cookies stealing)
function cipherId($id, $key, $iv) {
    return base64_encode(openssl_encrypt($id, "AES-128-CBC", $key, 0, $iv));
}

// Decrypt the ID
function decipherId($id_cipher, $key, $iv) {
    return openssl_decrypt(base64_decode($id_cipher), "AES-128-CBC", $key, 0, $iv);
}

// Recovering information from a json file
function recoverInfo($id) {
    $data = dataReader('../data/user_data.json');
    // Find user and update information
    foreach ($data as $key => $user) {
        if ($user['id'] == $id) {
            $_SESSION['user'] = $user;
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

if (isset($_SESSION["user"]["id"])) {
    if (!isset($_COOKIE["id"])) {
        $id_cipher = cipherId($_SESSION["user"]["id"], $secret_key, $iv);
        setcookie("id", $id_cipher, time() + 30 * 24 * 60 * 60, "/"); // Store encrypted ID in the cookie
    }
} elseif (!isset($_SESSION["user"]["id"]) && isset($_COOKIE["id"])) {
    $id_decipher = decipherId($_COOKIE["id"], $secret_key, $iv);
    $_SESSION["user"]["id"] = (int)$id_decipher; // Restore the user ID from the cookie
    recoverInfo($_SESSION["user"]["id"]);
}
?>