<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('../data/user_data.json');
    $users = json_decode($json_data, true);

    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    foreach ($users as &$user) {
        if ($user['id'] == $user_id) {
            if ($action == 'promote') {
                $user['role'] = 'vip';
            } elseif ($action == 'demote') {
                $user['role'] = 'normal';
            } elseif ($action == 'ban') {
                $user['role'] = 'banni';
            } elseif ($action == 'unban'){
                $user['role'] = 'normal';
            }
            break;
        }
    }

    file_put_contents('../data/user_data.json', json_encode($users, JSON_PRETTY_PRINT));
    $past_link = $_SERVER['HTTP_REFERER'];
    header("Location: $past_link");
    exit;
}
?>
