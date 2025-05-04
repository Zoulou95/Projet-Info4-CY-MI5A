<?php
session_start();

require_once('profile_manager.php');
require_once('error.php');

function banishment() {
    echo "<script>alert('Vous êtes banni de CyLanta.'); window.location.href = 'https://google.com/';</script>";
    session_unset();
    session_destroy();
    setcookie("identification", "", time() - 3600, "/");
    exit();
}

// Recovering information from a json file
function recoverInfo($id) {

    $user_found = 0;

    $data_file = __DIR__ . '/../data/user_data.json';

    $data = dataReader($data_file);

    // Find user and update information
    foreach ($data as $key => $user) {
        if ($user['id'] == $id) {
            $_SESSION["user"] = $user;
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
        displayError("User not found for update profile with cookie.");
    }
}

if (isset($_SESSION["user"]["id"]) && isset($_COOKIE["identification"])) {
    recoverInfo($_COOKIE["identification"]);
    if($_SESSION["user"]["role"] === "banni") {
        banishment();
    } else {
        return;
    }
}

if (isset($_SESSION["user"]["id"])) {
    if (!isset($_COOKIE["identification"])) {
        setcookie("identification", $_SESSION["user"]["id"], time() + 30 * 24 * 60 * 60, "/"); // Store encrypted ID in the cookie
    }
} elseif (!isset($_SESSION["user"]["id"]) && isset($_COOKIE["identification"])) {
    recoverInfo($_COOKIE["identification"]); // Restore the user ID from the cookie
}

// Prevent banned users from accessing the site at log in
if (isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === "banni") {
    banishment();
}
?>