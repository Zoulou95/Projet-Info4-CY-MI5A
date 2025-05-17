<?php
// price_calculator.php : calculate the total price of a trip selection and returns it for display

require_once('trip_functions.php');

// Accept JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Load trip data
$data = dataDecode('../data/trip_data.json');

// Retrieve the trip
$trip_id = $input['trip_id'];
$trip = null;
foreach ($data['trip'] as $t) {
    if ($t['id'] == $trip_id) {
        $trip = $t;
        break;
    }
}

if (!$trip) {
    echo json_encode(['error' => 'Trip not found']);
    exit;
}

// Prices

$base_price = $trip['price_per_person'];
$steps = [$trip['step_1'], $trip['step_2'], $trip['step_3']];
$participants = $input['number_of_participants'];
$tripDuration = intval($trip['dates']['length']);

// Price tables

$flightPrices = [
    "Classe Économique" => 800,
    "Classe Confort" => 1200,
    "Classe Affaires" => 1400,
    "Première Classe" => 2000
];

$transportPrices = [
    "Aucun" => 0,
    "Vélo" => 30,
    "Voiture" => 90,
    "Bâteau" => 100,
    "Chauffeur" => 300,
    "Hélicoptère" => 900
];

// Service charges
$total = $base_price * $participants;

// Flight price
$total += ($flightPrices[$input['flight']]) * $participants;

// Transport price
$total += ($transportPrices[$input['transport']]) * $participants * $tripDuration;

// Step calculation
for ($i=0; $i<3; $i++) {
    $step = $steps[$i];
    $stepDuration = $step['dates']['duration'];

    // Number of step participants
    $stepParticipants = $input['participants'][$i];

    // Hotel
    $hotelName = $input['hotel_choices'][$i];

    // In the json, prices are stored in an array. Each iteration of the price array corresponds to the iteration of the hotel array
    $hotelIndex = array_search($hotelName, $trip['hotel']) ?? 0;
    
    $hotelPrice = $trip['hotel_price'][$hotelIndex];
    $total += $hotelPrice * $stepParticipants * $stepDuration;

    // Pension
    $pension = $input['pension_choices'][$i];
    if (str_starts_with($pension, "Tout inclus")) {
        $total += 50 * $stepParticipants * $stepDuration;
    }

    // Activity
    $activityName = $input['activity_choices'][$i];
    $activityIndex = array_search($activityName, $step['activities']) ?? 0;
    $activityPrice = $step['activities_price'][$activityIndex];
    $total += $activityPrice * $stepParticipants;
}

// VIP discount
if (isset($_SESSION['user']) && $_SESSION['user']['role'] === "VIP") {
    $total *= 0.9;
}

$_SESSION['total_price'] = $total;

// Return result
echo json_encode(['total_price' => $total]);