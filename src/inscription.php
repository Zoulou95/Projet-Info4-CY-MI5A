<?php
include('../includes/logs.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = trim(htmlspecialchars($_POST['prenom']));
    $nom = trim(htmlspecialchars($_POST['nom']));
    $email = trim(htmlspecialchars($_POST['email']));
    $telephone = trim(htmlspecialchars($_POST['tel']));
    $password = trim(htmlspecialchars($_POST['password'])); 

    if (empty($prenom) || empty($nom) || empty($email) || empty($telephone) || empty($password)) {
        echo "<script>alert('Veuillez remplir tous les champs');</script>";
    } else {
        $user_data = [
            "prenom" => $prenom,
            "nom" => $nom,
            "email" => $email,
            "telephone" => $telephone,
            "password" => $password
        ];

        $data_file = __DIR__ . '/../data/user_data.json';

        if (file_exists($data_file)) {
            $json_data = file_get_contents($data_file);
            $data = json_decode($json_data, true);
        } else {
            $data = []; 
        }

     
        $data[] = $user_data;

        file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));

        writeToServerLog($user_data['email'] . " has successfully registered.");

        header("Location: search.php");
        exit;
    }
}
?>