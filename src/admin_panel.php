<?php
// Lire le fichier JSON
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

        <!-- Admin panel -->
        <div class="user_container">
            <?php foreach ($users as $user): ?>
                <form class="users">
                    <div class="user">
                    <img class="user_img" src="../assets/profile_pic/<?php echo isset($user['profile_pic']) && !empty($user['profile_pic']) ? $user['profile_pic'] : 'default_pic.jpg'; ?>" alt="Profile Picture" />
                        <div class="user_name">
                            <?php echo ucfirst(strtolower($user['prenom'])) . " " . ucfirst(strtolower($user['nom'])); ?>
                        </div>
                        <div class="user_privilege">
                            <label class="user_privilege">
                                Privilège :
                                <select name="Privilege" class="user_privilege_dropdown">
                                    <option value="administrateur" <?php echo $user['role'] === 'administrateur' ? 'selected' : ''; ?>>Administrateur</option>
                                    <option value="vip" <?php echo $user['role'] === 'vip' ? 'selected' : ''; ?>>VIP</option>
                                    <option value="normal" <?php echo $user['role'] === 'normal' ? 'selected' : ''; ?>>Standard</option>
                                </select>
                            </label>
                        </div>
                        <div class="user_ban">
                            <button class="user_ban_button" type="submit">BANNIR</button>
                        </div>
                    </div>
                </form>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
