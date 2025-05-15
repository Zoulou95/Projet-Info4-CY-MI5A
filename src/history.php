<?php
session_start();

include('../includes/profile_manager.php');

$data = dataReader('../data/user_data.json');
updateInfo($data, '../data/user_data.json');
?>

<!-- history.php : allow the user to see his purchases -->

<!-- Header display -->
<?php displayHeader();
if (!isset($_SESSION['user'])) {
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
            if ($_SESSION['user']['role'] == "admin") {
                echo '<li class="admin_panel_link" id="admin_panel_link"><a href="admin_panel.php">Administration</a></li>';
            }
            ?>
        </ul>
        <hr>

        <!-- User travel history-->
        <?php
        $user_id = $_SESSION['user']['id'];
        $purchase_file = '../data/purchase_data.json';
        displayPurchaseHistory($user_id, $purchase_file);
        ?>
    </div>
</div>
<!-- Footer -->
<?php displayFooter(); ?>
</body>

</html>