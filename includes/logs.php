<?php
// logs.php : tells administrators when an account has been created or a user has logged in

function writeToLog($message) {

    $log_dir = '../logs';
    $log_path = '../logs/server.log';
    
    // Create logs folder if it doesn't exist
    if (!file_exists($log_dir)) {
        mkdir($log_dir, 0777, true); // 0777 is the writing and reading permission ; true to create the folder recursively
    }

    // Create log file if it doesn't exist
    if (!file_exists($log_path)) {
        touch($log_path);
    }

    if(file_exists($log_path)) {

        $ip = $_SERVER['REMOTE_ADDR'];

        $formattedMessage = "[" . date("Y-m-d H:i:s") . "] " . $message . " (" . $ip . ")\n"; // Display date and user's IP

        file_put_contents($log_path, $formattedMessage, FILE_APPEND);
    
        error_log($formattedMessage);
    } else {
        error_log("\nERROR: Unable to open log file.\n");
    }
}
?>