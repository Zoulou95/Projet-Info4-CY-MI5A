<?php
require_once('../includes/error.php');

$json_data = file_get_contents('../data/user_data.json');
$users = json_decode($json_data, true);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$users_per_page = 20;
$page_index = ($page-1)*$users_per_page;
$current_users = array_slice($users, $page_index, $users_per_page);
$total_pages = ceil(count($users) / $users_per_page);

// Rajouter plus de vérifs
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== "admin") {
    displayError($_SESSION['user']['name'] . "is not an admin.");
    displayFooter();
}
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
        <!-- Navigation bar -->
        <?php displayHeader(); ?>

        <!-- Admin panel -->
        <div class="user_container">
            <?php foreach ($current_users as $user): ?>
                <form class="users" method="post" action="update_role.php">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <div class="user">
                    <?php
                        if (file_exists('../assets/profile_pic/user' . $user['id'] . '_profile_picture.jpg')) {
                            echo '<img class="user_img" src="../assets/profile_pic/user' . $user['id'] . '_profile_picture.jpg" />';
                        } else {
                            echo '<img class="user_img" src="../assets/profile_pic/base_profile_picture.jpg" />';
                        }
                    ?>
                        <div class="user_name">
                            <?php
                            switch($user['role']) {
                                case "admin":
                                    echo '<p class=color_admin>' . ucfirst(strtolower($user['forename'])) . " " . ucfirst(strtolower($user['name'])) . '</p>';
                                    break;
                                case "vip":
                                    echo '<p class=color_vip>' . ucfirst(strtolower($user['forename'])) . " " . ucfirst(strtolower($user['name'])) . '</p>';
                                    break;
                                default:
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
                                        echo '<button class="user_button user_status_button user_status_button_promote" type="submit" name="action" value="promote">Promouvoir</button>';
                                    } else if($user['role'] == "vip"){
                                        echo '<button class="user_button user_status_button user_status_button_demote" type="submit" name="action" value="demote">Rétrograder</button>';
                                    }
                                ?>
                            </div>
                            <div class="user_ban">
                                <?php
                                    if($user['role'] !== "admin" && $user['role'] !== "banni"){
                                        echo '<button class="user_button user_ban_button" type="submit" name="action" value="ban">BANNIR</button>';
                                    } elseif($user['role'] !== "admin" && $user['role'] === "banni"){
                                        echo '<button class="user_button user_ban_button" type="submit" name="action" value="unban">DEBANNIR</button>';
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