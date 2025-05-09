<?php
// picture_update.php : update user's personal profile

require_once('error.php');
require_once('trip_functions.php'); // For dataReader() usage

// Security check
if (!isset($_SESSION['user'])) {
    displayError('User not found.');
    exit;
} else {
    $user_id = $_SESSION['user']['id'];
}

// Handle profile picture upload ONLY if a file was submitted --> NON FONCTIONNEL
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
    $allowed_types = ['image/jpeg', 'image/jpg'];
    $max_size = 6 * 1024 * 1024;; // 6 Mo
    $file = $_FILES['profile_picture'];

    // Prevents the user from sending anything other than an image to the server
    if (!in_array($file['type'], $allowed_types)) {
        echo "<script>alert('Le format de l'image n'est pas supporté (doit être au format JPG ou PNG).'); window.history.back();</script>";
        exit;
    } elseif ($file['size'] > $max_size) {
        echo "<script>alert('Votre image est trop grande (maximum: 6 Mo).'); window.history.back();</script>";
        exit;
    } else {
        $filename = "user" . $_SESSION['user']['id'] . "_profile_picture.jpg";
        $destination = "../assets/profile_pic/" . $filename;

        move_uploaded_file($file['tmp_name'], $destination);
    }
}

// Read 'user_data.json' JSON data file
$data_file = '../data/user_data.json';
$data = dataReader($data_file);

// Find and update the user based on their ID
foreach ($data as $key => $user) {
    if ($user['id'] == $user_id) {

        // Update informations only if they changed
        if (isset($_POST['name']) && $_POST['name'] !== $user['name']) {
            $user['name'] = htmlspecialchars(trim($_POST['name']));
            $_SESSION['user']['name'] = $user['name']; // Update the user in the session
            $data[$key] = $user; // Update the user in the JSON
        }

        if (isset($_POST['forename']) && $_POST['forename'] !== $user['forename']) {
            $user['forename'] = htmlspecialchars(trim($_POST['forename']));
            $_SESSION['user']['forename'] = $user['forename'];
            $data[$key] = $user;
        }

        if (isset($_POST['email']) && $_POST['email'] !== $user['email']) {
            $user['email'] = htmlspecialchars(trim($_POST['email']));
            $_SESSION['user']['email'] = $user['email'];
            $data[$key] = $user;
        }

        if (isset($_POST['telephone']) && $_POST['telephone'] !== $user['telephone']) {
            $user['telephone'] = htmlspecialchars(trim($_POST['telephone']));
            $_SESSION['user']['telephone'] = $user['telephone'];
            $data[$key] = $user;
        }
        break;
    }
}

// Save updated data
if (file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode([
        "status" => "success",
    ]);
} else {
    echo json_encode([
        "status" => "error",
    ]);
}
?>