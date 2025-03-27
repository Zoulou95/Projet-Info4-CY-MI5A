<?php
    session_start();

    include('../includes/profile_manager.php');

    $data = dataReader('../data/user_data.json');
    updateInfo($data, '../data/user_data.json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update a user's password
        updatePassword();
    }
?>

<!-- userpage_security.php : allow the user to modify his password -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta user informations page" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="../css/base_style.css" />
    <link rel="stylesheet" type="text/css" href="../css/userpage_security_style.css" />
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

                <!-- User security menu (password) -->
                <div class="user_security_menu">
                    <div class="password_fields">
                        <form method="post" action="userpage_security.php">
                            <div>
                                <label for="current_password">Mot de passe actuel</label><br><br>
                                <input type="password" name="password" id="current_password" maxlength="30" required />
                            </div>
                            <div>
                                <label for="new_password">Nouveau mot de passe</label><br><br>
                                <input type="password" name="new_password" id="new_password" maxlength="30" required />
                            </div>
                            <div>
                                <label for="confirmation_password">Confirmer le mot de passe</label><br><br>
                                <input type="password" name="confirm_password" id="confirmation_password" maxlength="30" required />
                            </div>
                            <div class="button_group">
                                <button type="submit" name="submit" id="save_button" value="Sauvegarder">Sauvegarder</button>
                                <button type="reset" id="reset_button" value="Réinitialiser">Réinitialiser</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Footer -->
    <?php displayFooter();?>
</body>
</html>