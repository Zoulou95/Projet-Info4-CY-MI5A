<?php
// Tells administrators when an account has been created or a user has logged in
function writeToServerLog($message) {

    $log_path = '../data/server.log';
    
    if(!file_exists($log_path)) {
        touch($log_path);
    }

    if(file_exists($log_path)) {

        $ip = $_SERVER['REMOTE_ADDR'];

        $formattedMessage = "[" . date("Y-m-d H:i:s") . "] " . $message . " (" . $ip . ")\n"; // Display date and IP

        file_put_contents($log_path, $formattedMessage, FILE_APPEND);
    
        error_log($formattedMessage);
    } else {
        error_log("\nERROR: Unable to open log file.\n");
    }
}
?>