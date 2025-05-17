<?php
// save_session_choice.php : when configuring a trip, save the selection in the session variable

// Get JSON data
$json_data = file_get_contents('php://input');
$data = dataDecode($json_data);

// Check if data is valid
if (!$data || !isset($data['trip_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid data or missing trip ID.']);
    exit;
}

// Create a unique session key for this trip
$session_key = 'trip_choices_' . $data['trip_id'];

// Save the choices in session
$_SESSION[$session_key] = [
    'trip_id' => $data['trip_id'],
    'flight' => $data['flight'],
    'transport' => $data['transport'],
    'number_of_participants' => $data['number_of_participants'],
    'participants' => $data['participants'],
    'hotel_choices' => $data['hotel_choices'],
    'pension_choices' => $data['pension_choices'],
    'activity_choices' => $data['activity_choices']
];

// Return success response
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>