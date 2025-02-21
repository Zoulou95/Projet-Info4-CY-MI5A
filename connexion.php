<?php

$utilisateur = [
    "utilisateur1@cyu.fr" => "fzfafaz",
    "utilisateur2@cyu.fr" => "azefa",
    "utilisateur3@cyu.fr" => "azert",
    "utilisateur4@cyu.fr" => "agaga",
    "utilisateur5@cyu.fr" => "agzgzoprz2",
    "utilisateur6@cyu.fr" => "a789R2987R2H",
    "utilisateur7@cyu.fr" => "fzioaofoi34",
    "utilisateur8@cyu.fr" => "aze",
    "utilisateur9@cyu.fr" => "azezaaggagzra4",
    "utilisateur10@cyu.fr" => "zagagaga33",
    ];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

   
    if (isset($utilisateur[$email]) && $utilisateur[$email] === $password) {
        
        header("Location: src/search.html"); 
        exit;
    } else {
        
        echo "<script>alert('Email ou mot de passe incorrect. Veuillez réessayer.');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }
} else {
    
    header("Location: connexion.html");
    exit;
}
?>

