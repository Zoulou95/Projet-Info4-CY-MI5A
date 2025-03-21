<?php
    include('../includes/error.php');
    //include('../includes/header.php');
    session_start();

    // Read JSON file
    $json_data = file_get_contents('../data/user_data.json');
    $users = json_decode($json_data, true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta user informations page" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <meta name="keywords" content="travel, travel agency" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="../css/base_style.css" />
    <link rel="stylesheet" type="text/css" href="../css/admin_panel_style.css" />
</head>
<body>
    <div class="container">
        <div class="headbar">
            <div class="headbar_left">
                <a href="../index.php">
                <img class="logo_img" src="../assets/visuals/cylanta_logo.png" alt="CyLanta Logo" />
                </a>
            </div>
            <div class="headbar_rest">
                <a class="headbar_item" href="../index.php">Accueil</a>
                <a class="headbar_item" href="search.php">Destinations</a>
                <a class="headbar_item" href="advanced_search.php">Rechercher un voyage</a>
            </div>
            <div class="headbar_right">
                <a class="headbar_my_space" href="userpage.php">Mon espace</a>
                <a href="userpage.php"><img class="user_img_nav" src="../assets/profile_pic/example_pfp.jpg" /></a>
            </div>
        </div>

        <?php
        // Rajouter plus de vérifs
        if(!isset($_SESSION['user'])) {
            displayError($_SESSION['user']['name'] . "is not an admin.");
            displayFooter();
        }
        ?>   

        <!-- Admin panel -->
        <div class="user_container">
            <?php foreach ($users as $user): ?>
                <form class="users">
                    <div class="user">
                        <img class="user_img" src="../assets/profile_pic/<?php echo isset($user['profile_pic']) && !empty($user['profile_pic']) ? $user['profile_pic'] : 'default_pic.jpg'; ?>"/>
                        <div class="user_name">
                            <?php
                            switch($user['role']) {
                                case "admin":
                                    echo '<p class=color_admin>' . ucfirst(strtolower($user['forename'])) . " " . ucfirst(strtolower($user['name'])) . '</p>';
                                    break;
                                case "vip":
                                    echo '<p class=color_vip>' . ucfirst(strtolower($user['forename'])) . " " . ucfirst(strtolower($user['name'])) . '</p>';
                                    break;
                                case "standard":
                                    echo ucfirst(strtolower($user['forename'])) . " " . ucfirst(strtolower($user['name']));
                                    break;
                            }
                            ?>
                        </div>
                        <div class="user_privilege">
                            <?php echo "Privilège : " . ucfirst(strtolower($user['role'])); ?>
                        </div>
                        <div class="user_button_container">
                            <div class="user_status">
                                <?php
                                    if($user['role'] == "standard"){
                                        echo '<button class="user_button user_status_button user_status_button_promote" type="submit">Promouvoir</button>';
                                    } else if($user['role'] == "vip"){
                                        echo '<button class="user_button user_status_button user_status_button_demote" type="submit">Rétrograder</button>';
                                    }
                                ?>
                            </div>
                            <div class="user_ban">
                                <?php
                                    if ($user['role'] !== "admin") {
                                        echo '<button class="user_button user_ban_button" type="submit">BANNIR</button>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>