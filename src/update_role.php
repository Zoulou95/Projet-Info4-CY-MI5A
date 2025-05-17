<?php
// update_role.php : allows an administrator to change a user's role or ban them

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('../data/user_data.json');
    $users = json_decode($json_data, true);

    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    foreach ($users as &$user) {
        if ($user['id'] == $user_id) {
            if ($action == 'promote') {
                $user['role'] = 'vip';
            } else if ($action == 'demote') {
                $user['role'] = 'standard';
            } else if ($action == 'ban') {
                $user['role'] = 'banni';
            } else if ($action == 'unban'){
                $user['role'] = 'standard';
            }
            break;
        }
    }

    // Save file
    file_put_contents('../data/user_data.json', json_encode($users, JSON_PRETTY_PRINT));
    $past_link = $_SERVER['HTTP_REFERER'];
    header("Location: $past_link");
    exit;
}
?>