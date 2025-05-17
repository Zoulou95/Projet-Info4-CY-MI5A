<?php

session_start();

require_once('../includes/error.php');
require_once('../includes/logs.php');

// Processing the file containing user data
$data_file = '../data/user_data.json';

if (file_exists($data_file)) {
    $json_data = file_get_contents($data_file);
    $data = json_decode($json_data, true);
} else {
    displayError("user_data.json file is missing.");
    exit;
}

// Processing the login form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST['email']) ? htmlspecialchars(trim(strtolower($_POST['email']))) : ''; // Clean email
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

    $password = trim($password);

    // If the email is empty, return an error
    if (empty($email)) {
        echo '<script src="../script/bubble.js"></script>';
        echo '<script>displayBubble(event, "Un email est requis");</script>';
        exit;
    }

    // Check if the email exists in the data
    $user_found = false;

    // Browse each user
    foreach ($data as $user) {
        $user_email = trim(strtolower($user['email']));

        // Check if email matches
        if ($user_email === $email) {
            $user_found = true;
            if (password_verify($password, $user['password'])) {
                // Login successful, redirect to user page
                $_SESSION['user'] = $user; // Store user in session

                writeToLog($user['email'] . " has successfully logged in. (ID: ". $_SESSION['user']['id'] . ")");

                header("Location: userpage.php");
                exit;
            } else {
                // Incorrect password
                echo "<script>alert('Mot de passe incorrect.'); window.history.back();</script>";
                exit;
            }
        }
    }

    // If email not found in data : redirect to the login page
    if (!$user_found) {
        echo "<script>alert('Email non trouvé.'); window.history.back();</script>";
        exit;
    }
} else {
    // Redirect to home page if not a POST request
    displayError("Failed to send log in data.");
    exit;
}
?>