<?php
require_once('../includes/profile_manager.php');

$data = dataReader('../data/user_data.json');

if (isset($_SESSION["user"])) {
    updateInfo($data, '../data/user_data.json');
}
?>

<!-- Header display -->
<?php
displayHeader();

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

<!-- User security menu (password) -->
<div class="user_security_menu">
    <div class="password_fields">
        <form id="security_form" method="post" action="userpage_security.php">
            <div>
                <label for="current_password">Mot de passe actuel</label><br><br>
                <div class="input-container">
                    <input class="overlay_input" type="password" id="current_password" name="password" placeholder="Mot de passe actuel" maxlength="20" required>
                    <div class="counter-container">
                        <span id="current_password_counter">0 / 30</span>
                    </div>
                    <button type="button" class="toggle-password" onclick="togglePassword('current_password', this)"><img class="eye_image" src="../assets/visuals/eye_close.png" alt="Afficher le mot de passe" /></button>
                </div>
            </div>
            <div>
                <label for="new_password">Nouveau mot de passe</label><br><br>
                <div class="input-container">
                    <input class="overlay_input" type="password" id="new_password" name="new_password" placeholder="Nouveau mot de passe" maxlength="20" required>
                    <div class="counter-container">
                        <span id="new_password_counter">0 / 30</span>
                    </div>
                    <button type="button" class="toggle-password" onclick="togglePassword('new_password', this)"><img class="eye_image" src="../assets/visuals/eye_close.png" alt="Afficher le mot de passe" /></button>
                </div>
            </div>
            <div>
                <label for="confirmation_password">Confirmer le mot de passe</label><br><br>
                <div class="input-container">
                    <input class="overlay_input" type="password" id="confirmation_password" name="confirm_password" placeholder="Confirmer le mot de passe" maxlength="20" required>
                    <div class="counter-container">
                        <span id="confirm_password_counter">0 / 30</span>
                    </div>
                    <button type="button" class="toggle-password" onclick="togglePassword('confirmation_password', this)"><img class="eye_image" src="../assets/visuals/eye_close.png" alt="Afficher le mot de passe" /></button>
                </div>
            </div>
            <div class="button_group">
                <button type="submit" name="submit" id="save_button" value="Sauvegarder">Sauvegarder</button>
                <button type="reset" id="reset_button" value="Réinitialiser">Réinitialiser</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<!-- Footer -->
<?php displayFooter(); ?>

<div id="bubble" class="hidden"></div>
<script src="../script/passwordUpdate.js"></script>

</body>

</html>