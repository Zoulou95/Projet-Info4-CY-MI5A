<?php
    include('../includes/error.php');
    //include('../includes/header.php');
    ('../includes/footer.php');
    session_start();
?>

<!-- userpage.php : allow the user to see his personal informations and modify it -->

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
                <a href="userpage.php"><img class="user_img_nav" src="../assets/profile_pic/example_pfp.jpg" alt="User's profile picture" /></a>
            </div>
        </div>

        <?php
        // Rajouter plus de vérifs
        if(!isset($_SESSION['user'])) {
            displayError("Account not logged in.");
            displayFooter();
        }
        ?>      
        
        <div class="user_container">
            <div class="left_informations">
                <?php echo "<h1>Bienvenue M. <b>" . ucfirst($_SESSION['user']['name']) . "</b></h1>"; ?>
                <!-- Upload a profile picture by clicking the actual user image -->

                <input type="file" id="file_input" accept=".jpg" style="display: none;">
                <label for="file_input">
                    <?php
                        if (file_exists('../assets/profile_pic/user' . $_SESSION['user']['id'] . '_profile_picture.jpg')) {
                            echo '<img class="user_img" src="../assets/profile_pic/user' . $_SESSION['user']['id'] . '_profile_picture.jpg" />';
                        } else {
                            echo '<img class="user_img" src="../assets/profile_pic/base_profile_picture.jpg" />';
                        }
                    ?>
                </label>
                <p>Changer votre photo de profil</p>
                <input type="file" accept=".jpg" />

                <!-- We will set image size limitations in JavaScript -->
                <!-- We will code a JavaScript script to display a message when the file format is wrong (not png or jpg) -->

                <!-- Table showing user status (e.g. VIP, admin, etc.) -->
                <table class="subscription_table">
                    <tr>
                        <td class="cell1">Statut</td>
                    </tr>
                    <tr>
                        <td class="cell2"><?php echo ucfirst($_SESSION['user']['role']); ?></td>
                    </tr>
                </table>
            </div>

            <!-- User personal informations menu (name, email, etc.)-->
            <div class="user_informations">
                <ul class="menu_navigation">
                    <li class="info_link" id="info_link"><a href="userpage.php">Informations</a></li>
                    <li class="security_link" id="security_link"><a href="userpage_security.php">Sécurité</a></li>
                    <li class="admin_panel_link" id="admin_panel_link"><a href="admin_panel.php">Administration</a></li>
                </ul>
                <hr>
                <form method="post" action="userpage.php">
                    <div>
                        <label for="forename">Nom</label><br><br>
                        <input name="forename" type="text" id="last_name" placeholder="Entrez votre nom" maxlength="20" value="<?php echo ucfirst($_SESSION['user']['name']); ?>" required />
                    </div>
                    <div>
                        <label for="name">Prénom</label><br><br>
                        <input name="name" type="text" id="first_name" placeholder="Entrez votre prénom" maxlength="20" value="<?php echo ucfirst($_SESSION['user']['forename']); ?>" required />
                    </div>
                    <div>
                        <label for="email">E-mail</label><br><br>
                        <input name="email" type="email" id="email" placeholder="Entrez votre email" maxlength="30" value="<?php echo $_SESSION['user']['email']; ?>" required />
                    </div>
                    <div>
                        <label for="telephone">Numéro de téléphone</label><br><br>
                        <!-- To remove the ability to enter digits, we use a pattern attribute -->
                        <input name="telephone" type="tel" id="tel_number" pattern="[0-9]{10}" placeholder="Entrez votre mobile" maxlength="10" value="<?php echo $_SESSION['user']['telephone']; ?>" required /><br><br>
                    </div>
                    <div class="button_group">
                        <button type="submit" id="save_button" value="Sauvegarder">Sauvegarder</button>
                        <button type="reset" id="reset_button" value="Réinitialiser">Réinitialiser</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php displayFooter(); ?>
</body>
</html>