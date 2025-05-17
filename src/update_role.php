<?php
// Get JSON data from the request
$json_data = file_get_contents('php://input');
$post_data = json_decode($json_data, true);

if (!empty($post_data)) {
    // Read user data from file
    $user_data_json = file_get_contents('../data/user_data.json');
    $users = json_decode($user_data_json, true);
    
    // Get values from JSON
    $user_id = $post_data['user_id'];
    $action = $post_data['action'];
    
    // Initialize response
    $response = ['success' => true, 'action' => $action];
    
    // Update user role
    foreach ($users as &$user) {
        if ($user['id'] == $user_id) {
            if ($action == 'promote') {
                $user['role'] = 'vip';
                $response['new_role'] = 'vip';
            } elseif ($action == 'demote') {
                $user['role'] = 'standard';
                $response['new_role'] = 'standard';
            } elseif ($action == 'ban') {
                $user['role'] = 'banni';
                $response['new_role'] = 'banni';
            } elseif ($action == 'unban'){
                $user['role'] = 'standard';
                $response['new_role'] = 'standard';
            }
            break;
        }
    }
    
    // Save changes to file
    file_put_contents('../data/user_data.json', json_encode($users, JSON_PRETTY_PRINT));
    
    // 2 seconds delay to simulate latency
    sleep(2);
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    // Return error if no data received
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No data received']);
    exit;
}
?>