<!-- admin_panel.php : administrators' page where they can modify their privileges -->

<!DOCTYPE html> 
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta user informations page" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <meta name="keywords" content="travel, travel agency" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="base_style.css" />
    <link rel="stylesheet" type="text/css" href="admin_panel_style.css" />
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
                <a class ="headbar_item" href="advanced_search.php">Rechercher un voyage</a>
            </div>
            <div class="headbar_right">
                <a class="headbar_my_space" href="userpage.php">Mon espace</a>
                <a href="userpage.php"><img  class="user_img_nav" src="../assets/profile_pic/example_pfp.jpg" /></a>
            </div>
        </div>

        <!-- Admin panel -->
        <div class="user_container">
            <div class="user">
                    <img class="user_img" src="../assets/profile_pic/example_pfp.jpg" />
                <div class="user_name">
                    <p class="admin_text">Dupont Jojo</p>
                </div>
                <div class="user_privilege">
                    <form class="user_privilege_form">
                        <label class="user_privilege">
                            Privilège :
                            <select name="Privilege" class="user_privilege_dropdown">
                                <option value="Administrateur" selected>Administrateur</option>
                            </select>
                        </label>
                    </form>
                </div>
            </div>
            <div class="user">
                    <img class="user_img" src="../assets/profile_pic/example_pfp_2.jpg" />
                <div class="user_name">
                    <p class="vip_text">Amélie Lefevre</p>
                </div>
                <div class="user_privilege">
                    <form class="user_privilege_form">
                        <label class="user_privilege">
                            Privilège :
                            <select name="Privilege" class="user_privilege_dropdown">
                                <option value="Administrateur">Administrateur</option>
                                <option value="VIP" selected>VIP</option>
                                <option value="Normal">Standard</option>
                            </select>
                        </label>
                    </form>
                </div>
                <div class="user_ban">
                    <form method="post" action="#">
                        <button class="user_ban_button" type="submit">BANNIR</button>
                    </form>
                </div>
            </div>
            <div class="user">
                    <img class="user_img" src="../assets/profile_pic/example_pfp_3.jpg" />
                <div class="user_name">Sophie Durand
                </div>
                <div class="user_privilege">
                    <form class="user_privilege_form">
                        <label class="user_privilege">
                            Privilège :
                            <select name="Privilege" class="user_privilege_dropdown">
                                <option value="Administrateur">Administrateur</option>
                                <option value="VIP">VIP</option>
                                <option value="Normal" selected>Standard</option>
                            </select>
                        </label>
                    </form>
                </div>
                <div class="user_ban">
                    <form method="post" action="#">
                        <button class="user_ban_button" type="submit">BANNIR</button>
                    </form>
                </div>
            </div>
            <div class="user">
                <div class="user_name">
                    . . .
                </div>
            </div>
    </div>
</body>
</html>