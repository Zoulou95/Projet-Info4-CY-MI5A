<?php
// get_session_choice.php : when configuring a trip, retrieve the selection in the session variable

// Check if trip id is provided
if (isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];
} else {
    header('Content-Type: application/json');
    echo json_encode(['hasChoices' => false, 'error' => 'Trip ID is missing.']);
    exit;
}

// Create a unique session key for this trip
// We use this to save the user selection according to trip id (example: for trip 1, key is "trip_choices_1")
$session_key = 'trip_choices_' . $trip_id;

// Check if user has saved choices for this trip
if (isset($_SESSION[$session_key])) {
    // If true, return them
    header('Content-Type: application/json');
    echo json_encode(['hasChoices' => true, 'choices' => $_SESSION[$session_key]]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['hasChoices' => false]);
}
?>