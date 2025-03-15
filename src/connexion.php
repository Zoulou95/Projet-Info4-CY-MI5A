<?php
// Fichier contenant les données utilisateur
$data_file = '../data/user_data.json';

// Vérifier si le fichier existe
if (file_exists($data_file)) {
    $json_data = file_get_contents($data_file);
    $data = json_decode($json_data, true);
} else {
    // Si le fichier n'existe pas, rediriger vers la page d'erreur
    header("Location: src/error.php");
    exit;
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $email = isset($_POST['email']) ? trim(strtolower($_POST['email'])) : ''; // Nettoyer l'email
    $password = isset($_POST['password']) ? $_POST['password'] : ''; // Récupérer le mot de passe

    // Debug: afficher l'email saisi et vérifier s'il est bien récupéré
    // echo "Email saisi: " . $email . "<br>"; // Décommenter pour tester

    if (empty($email)) {
        // Si l'email est vide, renvoyer une erreur
        echo "<script>alert('L\'email est requis');</script>";
        exit;
    }

    // Vérifier si l'email existe dans les données
    $user_found = false; // Variable pour savoir si l'utilisateur a été trouvé

    // Parcours des utilisateurs
    foreach ($data as $user) {
        $user_email = trim(strtolower($user['Email'])); // Nettoyer l'email de l'utilisateur

        // Debug: afficher les emails des utilisateurs pour vérifier
        // echo "Email utilisateur: " . $user_email . "<br>"; // Décommenter pour tester

        // Vérifier si l'email correspond
        if ($user_email === $email) {
            $user_found = true;
            // Vérifier le mot de passe (non sécurisé, mais simple pour cet exemple)
            if ($user['MotDePasse'] === $password) {
                // Connexion réussie, rediriger vers la page utilisateur
                session_start();
                $_SESSION['user'] = $user; // Stocker l'utilisateur dans la session
                header("Location: userpage.html");
                exit;
            } else {
                // Mot de passe incorrect
                echo "<script>alert('Mot de passe incorrect.');</script>";
                header("Location: src/connexion.php"); // Rediriger vers la page de connexion
                exit;
            }
        }
    }

    // Si l'email n'a pas été trouvé dans les données
    if (!$user_found) {
        echo "<script>alert('Email non trouvé.');</script>";
        header("Location: src/connexion.php"); // Rediriger vers la page de connexion
        exit;
    }
} else {
    // Rediriger vers la page d'accueil si ce n'est pas une requête POST
    header("Location: index.php");
    exit;
}
?>

