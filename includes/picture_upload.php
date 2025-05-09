<?php
    // picture_upload.php : edit user's profile picture

    require_once('error.php');

    // Uploads a user's profile photo to the server
    function pictureUpload() {
        if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg'];
            $max_size = 6 * 1024 * 1024;; // 6 Mo
            $file = $_FILES['profile_picture'];

            // Prevents the user from sending anything other than an image to the server
            
            if (!in_array($file['type'], $allowed_types)) {
                echo "<script>alert('Le format de l'image n'est pas supporté (doit être au format JPG ou PNG).'); window.history.back();</script>";
                exit;
            } elseif ($file['size'] > $max_size) {
                echo "<script>alert('Votre image est trop grande (maximum: 6 Mo).'); window.history.back();</script>";
                exit;
            } else {
                $filename = "user" . $_SESSION['user']['id'] . "_profile_picture.jpg";
                $destination = "../assets/profile_pic/" . $filename;

                move_uploaded_file($file['tmp_name'], $destination);
            }
        } else {
            return;
        }
    }

    // Retrieve data sent via AJAX
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['cart_id'])) {
        $cart_id = $data['cart_id'];

        // Retrieve existing data
        $cart_path = '../data/cart_history_data.json';
        $cart_data = dataDecode('../data/cart_history_data.json');

        // Filter to delete entry with transaction ID
        $updated_cart = [];
        foreach ($cart_data as $entry) {
            if ($entry['cart_id'] !== $cart_id) {
                $updated_cart[] = $entry;
            }
        }

        // Reindex the table when an element is deleted
        $updated_cart = array_values($updated_cart);

        // Save updated data
        if (file_put_contents($cart_path, json_encode($updated_cart, JSON_PRETTY_PRINT))) {
            echo json_encode([
                "status" => "success",
            ]);
        } else {
            echo json_encode([
                "status" => "error",
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "ID de transaction manquant."
        ]);
    }
?>