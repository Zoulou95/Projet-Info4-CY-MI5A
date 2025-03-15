<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $password = htmlspecialchars($_POST['password']); 

    // On pourrait mettre password_hash($_POST['password'], PASSWORD_DEFAULT); 

    // Format des données à enregistrer
    $ligne = "$nom;$prenom;$email;$telephone;$password\n";

    // Écriture dans le fichier
    $fichier = 'inscriptions.txt';
    file_put_contents($fichier, $ligne, FILE_APPEND | LOCK_EX);

    header("Location: src/search.html");
} else {
    echo "Méthode non autorisée.";
}
?>