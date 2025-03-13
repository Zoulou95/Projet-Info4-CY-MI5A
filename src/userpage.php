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
        
        <div class="user_container">
            <div class="left_informations">
                <h1>Bienvenue M. <b>Dupont</b> !</h1>
                <!-- Upload a profile picture by clicking the actual user image -->

                <input type="file" id="file_input" accept=".png, .jpg" style="display: none;">
                <label for="file_input">
                    <img class="user_img" src="../assets/profile_pic/example_pfp.jpg" />
                </label>
                <p>Changer votre photo de profil</p>
                <input type="file" accept=".png, .jpg, .jpeg" />

                <!-- We will set image size limitations in JavaScript -->
                <!-- We will code a JavaScript script to display a message when the file format is wrong (not png or jpg) -->

                <!-- Table showing user status (e.g. VIP, admin, etc.) -->
                <table class="subscription_table">
                    <tr>
                        <td class="cell1">Statut</td>
                    </tr>
                    <tr>
                        <td class="cell2">Administrateur</td>
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
                        <label for="last_name">Nom</label><br><br>
                        <input type="text" id="last_name" placeholder="Entrez votre nom" maxlength="20" value="Dupont" required />
                    </div>
                    <div>
                        <label for="first_name">Prénom</label><br><br>
                        <input type="text" id="first_name" placeholder="Entrez votre prénom" maxlength="20" value="Jojo" required />
                    </div>
                    <div>
                        <label for="email">E-mail</label><br><br>
                        <input type="email" id="email" placeholder="Entrez votre email" maxlength="30" value="jojodupont@gmail.com" required />
                    </div>
                    <div>
                        <label for="tel_number">Numéro de téléphone</label><br><br>
                        <!-- To remove the ability to enter digits, we use a pattern attribute -->
                        <input type="tel" id="tel_number" pattern="[0-9]{10}" placeholder="Entrez votre mobile" maxlength="10" value="0707070707" required /><br><br>
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
    <footer>
        <div class="footer_section">
            <h3>À Propos</h3>
            <p>Chez CyLanta, nous concevons des voyages sur mesure, uniques et adaptés à vos envies.
                Passionnés d'évasion et grâce à notre réseau de partenaires, nous sélectionnons pour vous les meilleures
                adresses et activités exclusives.
                Que ce soit un safari, un road trip ou un séjour bien-être, chaque voyage est pensé dans les moindres
                détails. Votre aventure commence ici !
            </p>
        </div>
        <div class="footer_section">
            <h3>Nos Contacts</h3>
            <ul class="other">
                <li><a href="mailto:CyLanta@cy-tech.fr">Email: CyLanta@cy-tech.fr</a></li>
                <li><a href="tel:+33123456789">Téléphone: +33 1 23 45 67 89</a></li>
                <li><a href="https://www.google.com/maps?q=49.035290202793036, 2.070567152915135" target="_BLANK">Adresse: Av. du Parc, 95000 Cergy</a></li>
            </ul>
        </div>
        <div class="footer_section">
            <h3>Nos Partenaires</h3>
            <div class="partners">
                <a href="https://www.cyu.fr/" target="_blank"><img src="../assets/visuals/cy_favicon.png" alt="Partenaire 1" /></a>
                <a href="https://cytech.cyu.fr/" target="_blank"><img src="../assets/visuals/cytech_icon.png"alt="Partenaire 2" /></a>
                <a href="https://www.cergy.fr/accueil/" target="_blank"><img src="../assets/visuals/cergy_ville.jpg" alt="Partenaire 3" /></a>
            </div>
        </div>
    </footer>
</body>
</html>