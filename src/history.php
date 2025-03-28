<?php
    require_once('../includes/profile_manager.php');

    $data = dataReader('../data/user_data.json');
    if(isset($_SESSION["user"])) {
        updateInfo($data, '../data/user_data.json');
    }

?>

<!-- history.php : allow the user to modify his password -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta user informations page" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="../css/base_style.css" />
    <link rel="stylesheet" type="text/css" href="../css/userpage_style.css" />
</head>
<body>
    <div class="container">
        <!-- Navigation bar -->
        <?php displayHeader(); ?>

        <?php
        if(!isset($_SESSION['user'])) {
            displayError("Account not logged in.");
            displayFooter();
        }
        ?>    
        
        <div class="user_container">
            <div class="user_informations">
                <ul class="menu_navigation">
                    <li class="info_link" id="info_link"><a href="userpage.php">Informations</a></li>
                    <li class="security_link" id="security_link"><a href="history.php">Historique</a></li>
                    <li class="security_link" id="security_link"><a href="userpage_security.php">Sécurité</a></li>
                    <?php
                        if($_SESSION['user']['role'] == "admin") {
                            echo '<li class="admin_panel_link" id="admin_panel_link"><a href="admin_panel.php">Administration</a></li>';
                        }
                    ?>
                </ul>
            <hr>


            <!-- User travel history-->
            <?php
                $id_list = $_SESSION['user']['travel_history'];
                $data_file = '../data/trip_data.json';

                displayHistory($id_list, $data_file);
            ?>
        </div>
    </div>
    <!-- Footer -->
    <?php displayFooter();?>
</body>
</html>