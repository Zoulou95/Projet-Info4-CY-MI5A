<?php
include('../includes/error.php');
include('../includes/logs.php');

// Processing the file containing user data
$data_file = '../data/user_data.json';

if (file_exists($data_file)) {
    $json_data = file_get_contents($data_file);
    $data = json_decode($json_data, true);
} else {
    displayError("'user_data.json file is missing.");
    exit;
}

// Processing the login form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST['email']) ? trim(strtolower($_POST['email'])) : ''; // Clean email
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email)) {
        // If the email is empty, return an error
        echo "<script>alert('L\'email est requis');</script>";
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
            if ($user['password'] === $password) {
                // Login successful, redirect to user page
                session_start();
                $_SESSION['user'] = $user; // Store user in session

                writeToServerLog($user['email'] . " has successfully logged in.");

                header("Location: userpage.php");
                exit;
            } else {
                // Incorrect password
                echo "<script>alert('Mot de passe incorrect.');</script>";
                header("Location: src/connexion.php");
                exit;
            }
        }
    }

    // If email not found in data : redirect to the login page
    if (!$user_found) {
        echo "<script>alert('Email non trouvé.');</script>";
        header("Location: src/connexion.php");
        exit;
    }
} else {
    // Redirect to home page if not a POST request
    header("Location: index.php");
    exit;
}
?>