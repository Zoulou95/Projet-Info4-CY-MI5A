<?php
// Lire le fichier JSON
$json_data = file_get_contents('../data/user_data.json');
$users = json_decode($json_data, true);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$users_per_page = 20;
$page_index = ($page-1)*$users_per_page;
$current_users = array_slice($users, $page_index, $users_per_page);
$total_pages = ceil(count($users) / $users_per_page);
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
            <?php foreach ($current_users as $user): ?>
                <form class="users" method="post" action="update_role.php">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <div class="user">
                        <img class="user_img" src="../assets/profile_pic/<?php echo isset($user['profile_pic']) && !empty($user['profile_pic']) ? $user['profile_pic'] : 'default_pic.jpg'; ?>"/>
                        <div class="user_name">
                            <?php echo ucfirst(strtolower($user['prenom'])) . " " . ucfirst(strtolower($user['nom'])); ?>
                        </div>
                        <div class="user_privilege">
                            <?php echo "Privilège : " . ucfirst(strtolower($user['role'])); ?>
                        </div>
                        <div class="user_button_container">
                            <div class="user_status">
                                <?php
                                    if($user['role'] == "normal"){
                                        echo '<button class="user_button user_status_button user_status_button_promote" type="submit" name="action" value="promote">Promouvoir</button>';
                                    } else if($user['role'] == "vip"){
                                        echo '<button class="user_button user_status_button user_status_button_demote" type="submit" name="action" value="demote">Rétrograder</button>';
                                    }
                                ?>
                            </div>
                            <div class="user_ban">
                                <?php
                                    if ($user['role'] !== "admin" && $user['role'] !== "banni") {
                                        echo '<button class="user_button user_ban_button" type="submit" name="action" value="ban">BANNIR</button>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endforeach; ?>
            <!-- Pagination links -->
            <div class="pagination">
                <?php
                if ($page > 1) {
                    echo '<a href="?page=' . ($page - 1) . '">Précédent</a>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a href="?page=' . $i . '">'.$i.'</a>';
                }
                if ($page < $total_pages) {
                    echo '<a href="?page=' . ($page + 1) . '">Suivant</a>';
                }
                ?>
        </div>
        </div>
    </div>
</body>
</html>
