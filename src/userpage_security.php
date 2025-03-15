<!-- userpage_security.php : allow the user to modify his password -->
<!-- NOTE : This page will be removed when we code in javascript to navigate between the various menus ("information" and "securité")
and remain on a single page (userpage.php)-->

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
        
        <div class="user_container">
            <div class="user_informations">
                <ul class="menu_navigation">
                    <li class="info_link" id="info_link"><a href="userpage.php">Informations</a></li>
                    <li class="security_link" id="security_link"><a href="userpage_security.php">Sécurité</a></li>
                    <li class="admin_panel_link" id="admin_panel_link"><a href="admin_panel.php">Administration</a></li>
                </ul>
                <hr>

                <!-- User security menu (password) -->
                <div class="user_security_menu">
                    <div class="password_fields">
                        <form method="post" action="#">
                            <div>
                                <label for="current_password">Mot de passe actuel</label><br><br>
                                <input type="password" id="current_password" maxlength="30" required />
                            </div>
                            <div>
                                <label for="new_password">Nouveau mot de passe</label><br><br>
                                <input type="password" id="new_password" maxlength="30" required />
                            </div>
                            <div>
                                <label for="confirmation_password">Confirmer le mot de passe</label><br><br>
                                <input type="password" id="confirmation_password" maxlength="30" required />
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
    <?php include('../includes/footer.php'); displayFooter();?>
</body>
</html>