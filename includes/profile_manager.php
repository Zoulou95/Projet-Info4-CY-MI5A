<?php
    include('../includes/error.php');

    // Read the 'user_data.json' file and convert it into a PHP array
    function dataReader($data_file) {
        if (file_exists($data_file)) {
            $json_data = file_get_contents($data_file);
            $data = json_decode($json_data, true); 
        }  
        else
        {
            displayError("'user_data.json' file is missing.");
        }

        // Verification of data structure
        if (!isset($data) || !is_array($data)) {
            displayError("data decode failed.");
        }

        return $data;
    }

    // Update account informations
    function updateInfo($data, $data_file) {

        // Change the user role to VIP if he has enough fidelity points
        if($_SESSION['user']['role'] == "standard" && $_SESSION['user']['points'] >= 300) {
            $user_id = $_SESSION['user']['id'];

            // Find user and update information
            foreach ($data as $key => $user) {
                if ($user['id'] == $user_id) {
                    $data[$key]['role'] = "vip";
                }
            }
    
            $_SESSION['user']['role'] = "vip";
    
            // Save new data to JSON file
            $new_json_data = json_encode($data, JSON_PRETTY_PRINT);
            if (!file_put_contents($data_file, $new_json_data)) {
                displayError("Error updating user_data.json file.");
            }
        }

        // Find user and update information
        foreach ($data as $key => $user) {
            if ($user['id'] == $_SESSION['user']['id']) {
                $_SESSION['user']['travel_history'] = $data[$key]['travel_history'];
            }
        }
    }

    // Uploads a user's profile photo to the server
    function pictureUpload() {
        if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
            $max_size = 6 * 1024 * 1024;; // 6 Mo
            $file = $_FILES['profile_picture'];
    
            if (!in_array($file['type'], $allowed_types)) {
                echo "<script>alert('Le format de l'image n'est pas supporté (doit être au format JPG ou PNG).'); window.history.back();</script>";
                exit;
            } elseif ($file['size'] > $max_size) {
                echo "<script>alert('Votre image est trop grande (maximum: 6 Mo).'); window.history.back();</script>";
                exit;
            } else {
                $filename = "user" . $_SESSION['user']['id'] . "_profile_picture.jpg";
                $destination = "../assets/profile_pic/" . $filename;
    
                // Convert to JPG if required
                if ($file['type'] == 'image/png') {
                    $image = imagecreatefrompng($file['tmp_name']); // Create image from PNG file
                    imagejpeg($image, $destination, 90); // Converts image to '.jpg' at 90% quality rate
                    imagedestroy($image);
                } else {
                    move_uploaded_file($file['tmp_name'], $destination);
                }
            }
        } else {
            return;
        }
    }

    function editInfo($data, $data_file) {
        
        if(isset($_POST['name']) || isset($_POST['forename']) || isset($_POST['email']) || isset($_POST['telephone'])) {

            $user_id = $_SESSION['user']['id'];

            // Find user and update information
            foreach ($data as $key => $user) {
                if ($user['id'] == $user_id) {

                    if (isset($_POST['forename']) && !empty($_POST['forename'])) {
                        $forename = trim(htmlspecialchars($_POST['forename']));
                        $data[$key]['forename'] = $forename; // Update forename in json file
                        $_SESSION['user']['forename'] = $forename;  // Update forename in user session
                    }
                    
                    if (isset($_POST['name']) && !empty($_POST['name'])) {
                        $name = trim(htmlspecialchars($_POST['name']));
                        $data[$key]['name'] = $name;
                        $_SESSION['user']['name'] = $name;  // Update name
                    }
                    
                    if (isset($_POST['email']) && !empty($_POST['email'])) {
                        $email = trim(htmlspecialchars($_POST['email']));
                        $data[$key]['email'] = $email;
                        $_SESSION['user']['email'] = $email;  // Update email
                    }
                    
                    if (isset($_POST['telephone']) && !empty($_POST['telephone'])) {
                        $telephone = trim(htmlspecialchars($_POST['telephone']));
                        $data[$key]['telephone'] = $telephone;
                        $_SESSION['user']['telephone'] = $telephone;  // Update mobile
                    }
                    break;
                }
            }
    
            // Save new data to JSON file
            $new_json_data = json_encode($data, JSON_PRETTY_PRINT);
            if (!file_put_contents($data_file, $new_json_data)) {
                displayError("Error updating user_data.json file.");
            }

        } else {
            return;
        }
    }

    function updatePassword() {
        if(isset($_POST['new_password']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
            $confirm_password = $_POST['confirm_password'];
            $password = $_POST['password'];
            $new_password = $_POST['new_password'];
            
            if($confirm_password != $new_password) {
                echo "<script>alert('Les mots de passe ne sont pas identiques.'); window.history.back();</script>";
                exit;
            }

            if (strlen($new_password) < 8) {
                echo "<script>alert('Votre nouveau mot de passe doit contenir au moins 8 caractères.'); window.history.back();</script>";
                exit;
            }

            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $data_file = "../data/user_data.json";
            $data = dataReader($data_file);

            $user_id = $_SESSION['user']['id'];
            $user_found = 0;

            // Find user and update information
            foreach ($data as $key => $user) {
                if ($user['id'] == $user_id) {

                    if(password_verify($password, $data[$key]['password'])) {
                        $data[$key]['password'] = $new_hashed_password;

                        // Save new data to JSON file
                        $new_json_data = json_encode($data, JSON_PRETTY_PRINT);
                        if (!file_put_contents($data_file, $new_json_data)) {
                            displayError("Error updating user_data.json file.");
                        }

                        echo "<script>alert('Mot de passe changé avec succès.'); window.history.back();</script>";
                        exit;
                    } else {
                        echo "<script>alert('Votre mot de passe actuel est erroné.'); window.history.back();</script>";
                        exit;
                    }
                    $user_found = 1;
                    break;
                }
            }
            if($user_found == 0) {
                displayError("User not found for password change.");
            }
        } else {
            displayError("Password modification failed.");
        }
    }

    // Find a trip with its id
    function tripFinder($data, $trip_id) {
        // Check that the trip match the ID in 'trip_data.json'
        $trip = null;
        foreach ($data['trip'] as $journey) {
            if ($journey['id'] == $trip_id) {
                $trip = $journey;
                break;
            }
        }
        if ($trip === null) {
            displayError("trip not found.");
        }
        return $trip;
    }

    // Display trip presentation cards according to id provided
    function displayHistory($id_list, $data_file) {
        $data = dataReader($data_file);
    

        
        if(empty($id_list)) {
            echo '<h1 class="history_text"><b>Aucun voyage réservé 🥹</b></h1>';
            exit;
        } else {
            echo '<h1 class="history_text"><b>Historique de vos voyages</b></h1>';
        }
        
        echo '<br /><br />';
        echo '<div class="card-container">';

        foreach ($id_list as $trip_id) {
            $trip = tripFinder($data, $trip_id);
            if (!$trip) {
                displayError("Trip not found on cards display.");
            }
            echo
            '<div class="card">
                <img src="../assets/presentation/' . $trip['presentation_img_1'] . '" alt="Trip image" />
                <div class="card_content">
                    <h2>' . $trip['presentation_title'] . '</h2>
                    <a href="../src/trip.php?id=' . $trip['id'] . '" class="explore">➤ Consulter ma réservation</a>
                </div>
            </div>';
        }
    
        echo '</div>';
    }

    // Update a user's loyalty points and travel history
    function confirmPurchaseUpdate() {
        $data_file = "../data/user_data.json";
        $data = dataReader($data_file);

        $user_id = $_SESSION['user']['id'];
        $user_found = 0;

        // Find user and update information
        foreach ($data as $key => $user) {
            if ($user['id'] == $user_id) {
                $_SESSION['user']['points'] += $_SESSION['points_win'];
                $data[$key]['points'] = $_SESSION['user']['points'];

                // Create an empty array if necessary
                if (!isset($data[$key]['travel_history']) || !is_array($data[$key]['travel_history'])) {
                    $data[$key]['travel_history'] = []; 
                }

                $data[$key]['travel_history'][] = $_SESSION['trip']['id'];

                // Save new data to JSON file
                $new_json_data = json_encode($data, JSON_PRETTY_PRINT);
                if (!file_put_contents($data_file, $new_json_data)) {
                    displayError("Error updating user_data.json file.");
                }

                $user_found = 1;
                break;
            }
        }
        if($user_found == 0) {
            displayError("User not found for update profile after purchase.");
        }
    }
?>