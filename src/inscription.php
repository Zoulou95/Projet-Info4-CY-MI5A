<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['tel']);
    $password = htmlspecialchars($_POST['password']); 

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
        header("Location: search.php");
        exit;
    }
}
?>
