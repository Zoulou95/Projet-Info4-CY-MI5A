<?php
$fichier = "inscriptions.txt";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (($handle = fopen($fichier, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";", '"', "")) !== FALSE) { //Taille de la lecture à voir plus tard (dynamique plutot que statique)
            if ($data[2] === $email && $data[4] === $password) { // Soit on le hache soit on le passe en clair (à voir)
                fclose($handle);
                header("Location: src/userpage.html");
                exit;
            }
        }
        fclose($handle);
    }

    //Modification plus tard
    echo "<script>alert('Email ou mot de passe incorrect. Veuillez réessayer.');</script>";
    echo "<script>window.history.back();</script>";
    exit;
} else {
    header("Location: index.html");
    exit;
}
?>

