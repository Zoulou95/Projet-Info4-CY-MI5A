<?php
session_start();
include_once('../includes/logs.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $forename = trim(htmlspecialchars($_POST['forename']));
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $telephone = trim(htmlspecialchars($_POST['tel']));
    $password = trim(htmlspecialchars($_POST['password'])); 

    if (empty($forename) || empty($name) || empty($email) || empty($telephone) || empty($password)) {
        echo "<script>alert('Veuillez remplir tous les champs.'); window.history.back();</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $user_data = [
            "name" => strtolower($name),
            "forename" => strtolower($forename),
            "email" => $email,
            "telephone" => $telephone,
            "password" => $hashed_password,
            "role" => "standard",
            "points" => 0
        ];

        $data_file = __DIR__ . '/../data/user_data.json';

        if (file_exists($data_file)) {
            $json_data = file_get_contents($data_file);
            $data = json_decode($json_data, true);
        } else {
            $data = []; 
        }

        // Check if the email or mobile number already exists
        foreach ($data as $user) {
            if ($user['email'] === $email) {
                echo "<script>alert('Un compte avec cet email existe déjà.'); window.history.back();</script>";
                exit;
            }
            if ($user['telephone'] === $telephone) {
                echo "<script>alert('Un compte avec ce numéro de téléphone existe déjà.'); window.history.back();</script>";
                exit;
            }
        }

        // Generate a unique ID based on the real-time time-stamping
        $user_data['id'] = uniqid();

        $data[] = $user_data;

        file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));

        $_SESSION['user'] = $user_data;

        writeToLog($user_data['email'] . " has successfully registered.");

        header("Location: search.php");
        exit;
    }
}
?>