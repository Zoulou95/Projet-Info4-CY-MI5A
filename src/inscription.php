<?php
include('../includes/logs.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $forename = trim(htmlspecialchars($_POST['forename']));
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $telephone = trim(htmlspecialchars($_POST['tel']));
    $password = trim(htmlspecialchars($_POST['password'])); 

    if (empty($forename) || empty($name) || empty($email) || empty($telephone) || empty($password)) {
        echo "<script>alert('Veuillez remplir tous les champs.');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $user_data = [
            "role" => "Basique",
            "name" => strtolower($name),
            "forename" => strtolower($forename),
            "email" => $email,
            "telephone" => $telephone,
            "password" => $hashed_password
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
                echo "<script>alert('Un compte avec cet email existe déjà.');</script>";
                exit;
            }
            if ($user['telephone'] === $telephone) {
                echo "<script>alert('Un compte avec ce numéro de téléphone existe déjà.');</script>";
                exit;
            }
        }

        // Generate a unique ID based on the number of existing users
        $user_data['id'] = count($data) + 1;

        $data[] = $user_data;

        file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));

        writeToServerLog($user_data['email'] . " has successfully registered.");

        header("Location: search.php");
        exit;
    }
}
?>