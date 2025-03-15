<?php

$data_file = '../data/user_data.json';
 
    if (file_exists($data_file)) {
        $json_data = file_get_contents($data_file);
        $data = json_decode($json_data, true);
    } else {
    	header("Location: error.php");
	}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if(in_array($email, $data) && in_array($password, $data)) {
    	header("Location: userpage.php");
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




