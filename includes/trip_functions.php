<?php

require_once('error.php');

// Function to retrieve useful data from 'trip_data.json file and display specific trip information
function dataDecode($data_file) {
    // Read the 'trip_data.json' file and convert it into a PHP array
    if (file_exists($data_file)) {
        $json_data = file_get_contents($data_file);
        $data = json_decode($json_data, true); 
    }  
    else
    {
        //displayError("'trip_data.json' file is missing."); --> à faire
        error_log($data_file ." is missing.");
    }

    // Verification of data structure --> à faire

    return $data; 
}

// Retrieves the number of results found during a search (for aesthetic reasons)
function getTripNumber($data, $tag) {
    $counter = 0;
    foreach ($data['trip'] as $journey) {
        foreach ($journey['tags'] as $keyword) {
            if ($keyword == $tag) {
                $trip_found = true;
                $counter++;
            }
        }
    }
    return $counter;
}

// Display a card with useful informations
function printCard($journey) {
    echo
    '
    <div class="card" 
        data-price="' . $journey['price_per_person'] . '" 
        data-date="' . $journey['dates']['start_date'] . '" 
        data-duration="' . $journey['dates']['length'] . '" 
        data-steps="' . count($journey['special_features']) . '">
        <img src="../assets/presentation/' . $journey['presentation_img_1'] . '" alt="Card presentation image" />
        <div class="card_content">
            <h2>'. $journey['title'] . '</h2>
            <p>'. $journey['subtitle'] . '</p>
            <p>Date : <b><span class="date_value">' . $journey['dates']['start_date'] . '</span></b> au <b>' . $journey['dates']['end_date'] . '</b></p>
            <p>Spécificité : ' . $journey['special_features'][0] . '</p>
            <p>Frais de prestation : <b><span class="price_value">' . $journey['price_per_person'] . '</span>€</b></p>';
            if(isset($_SESSION['user']['travel_history']) && isPurchased($journey['id'])) {
                echo '<a href="../src/history.php" class="purchased">➤ Voyage acheté</a>';
            } else {
                echo '<a href="../src/trip.php?id=' . $journey['id'] . '" class="explore">➤ Découvrir</a>';
            }
    echo
    '
    </div>
    </div>
    ';
}


// Display a trip as a map according to a user's quicksearch request
function displayByTag($data, $tag, $trip_number) {

    // Manage display when only one result is obtained
    if ($trip_number > 1) {
        $plural = 's';
    } else {
        $plural = '';
    }

    echo '<h2 class="result_text">Résultat' . $plural . ' pour "' . $tag . '" (' . $trip_number . ' voyage' . $plural . ' trouvé' . $plural . ')</h2>';

    if ($trip_number != 0) {
        echo '<div class="result_container">';
        foreach ($data['trip'] as $journey) {
            foreach ($journey['tags'] as $keyword) {
                if ($keyword == $tag) {
                    $trip_found = true;
                    printCard($journey);
                }
            }
        }
        echo '</div>';
    } else {
        displayNoResult();
    }
}

// Display a trip as a map according to a user's specific search request
function displayByFilter($data) {

    // Avoid undefined index errors if certain variables are not sent in the URL
    $destination = htmlspecialchars($_GET['destination']) ?? 0;
    $price_range = $_GET['price_range'] ?? 0;
    $travel_type = $_GET['travel_type'] ?? 0;
    $date = $_GET['date'] ?? 0;
    $travel_length = $_GET['travel_length'] ?? 0;

    // Input verification
    if($travel_length != 0 && $travel_length < 8 || $travel_length > 12) {
        displayError("Wrong travel length input.");
    }

    $valid_price_ranges = ["-2000", "2000-3000", "3000-4000", "4000-5000", "+5000"];

    if ($price_range != 0 && !in_array($price_range, $valid_price_ranges)) {
        displayError("Wrong price range input.");
    }

    $valid_travel_types = ["noces", "découverte", "aventure", "détente", "luxe"];

    if ($travel_type != 0 && !in_array($travel_type, $valid_travel_types)) {
        displayError("Wrong travel type input.");
    }

    echo '<h2 class="result_text">Résultats pour votre recherche</h2>';
    echo '<div class="result_container">';

    $found = false;
    foreach ($data['trip'] as $journey) {
        $match = true;

        // Check island (destination)
        if ($destination && strtolower($journey['destination']) != strtolower($destination)) {
            $match = false;
        }

        // Check price_range
        if ($price_range && $journey['price_range'] != $price_range) {
            $match = false;
        }

        // Check trip type
        if ($travel_type && $journey['specificity'] != $travel_type) {
            $match = false;
        }

        // Check date
        if ($date && $journey['dates']['start_date'] != $date) {
            $match = false;
        }

        // Check duration
        if ($travel_length && $journey['dates']['length'] != $travel_length) {
            $match = false;
        }

        if ($match) {
            printCard($journey);
            $found = true;
        }
    }
    echo '</div>';
    if ($found == false) {
        displayNoResult();
    }
}

// Display trip presentation cards according to id provided
function displayCards($id_list, $data_file) {

    $data = dataDecode($data_file);

    foreach ($id_list as $trip_id) {
        $trip = tripFinder($data, $trip_id);
        if (!$trip) {
            displayError('trip' . $trip_id . 'not found on cards display.');
        }
        echo
        '<div class="card">
            <img src="../assets/presentation/' . $trip['presentation_img_1'] . '" alt="Trip image" />
            <div class="card_content">
                <h2>' . $trip['presentation_title'] . '</h2>
                <p>' . $trip['description'] . '</p>';

                if(isset($_SESSION['user']['travel_history']) && isPurchased($trip_id)) {
                    echo '<a href="../src/history.php" class="purchased">➤ Voyage acheté</a>';
                } else {
                    echo '<a href="../src/trip.php?id=' . $trip['id'] . '" class="explore">➤ Découvrir</a>';
                }
        echo
        '
        </div>
        </div>
        ';
    }
}

// Check if the user's advanced search is valid
function isValidAdvancedSearch() {
    return !empty($_GET['destination']) || !empty($_GET['price_range']) || !empty($_GET['travel_type']) || !empty($_GET['date']) || !empty($_GET['travel_length']);
}

// Check if the user has configured his trip correctly
function isConfigValid() {
    $res = 1; // 1 = OK ; 0 = ERROR

    for ($i=1; $i<4; $i++) {
        if (!isset($_POST['hotel_' . $i]) || !isset($_POST['pension_' . $i]) || !isset($_POST['activite_' . $i]) || !isset($_POST['participants_' . $i])) {
            $res = 0;
            break;
        }
    }

    if (!isset($_POST['number_of_participants']) || !isset($_POST['transports']) || !isset($_POST['flight'])) {
        $res = 0;
    }

    return $res;
}

// Display a message if no result found
function displayNoResult() {
    echo
    '<h3 class="result_not_found">Aucun voyage ne correspond à votre recherche</h3>
    <button class="back_to_search_button">
        <a class="back_to_search_text" href="search.php">Cliquez ici pour retourner à la recherche</a>
    </button>';
}

// Check if a trip is already purchased by an user
function isPurchased($trip_id) {
    $trip_id = (string) $trip_id;
    if (isset($_SESSION['user']['travel_history']) && in_array($trip_id, $_SESSION['user']['travel_history'])) {
        return true;
    } else {
        return false;
    }
}

// Calculate the travel final price
function priceCalc($trip, $number_of_participants) {
    $step_number = 4;
    $tripDuration = intval($trip['dates']['duration']);
    $service = intval($trip['price_per_person']);
    $transportMode = $_POST['transports'];

    // Initial total with base price
    $total = $service * $number_of_participants;

    // Add flight price
    switch ($_POST['flight']) {
        case "Classe Économique":
            $flightPrice = 800;
            break;
        case "Classe Confort":
            $flightPrice = 1200;
            break;
        case "Classe Affaires":
            $flightPrice = 1400;
            break;
        case "Première Classe":
            $flightPrice = 2000;
            break;
        default:
            $flightPrice = 800;
            break;
    }
    $total += $flightPrice * $number_of_participants;

    // Transport costs
    $transportRates = [
        "Aucun" => 0,
        "Vélo" => 30,
        "Voiture" => 90,
        "Bâteau" => 100,
        "Chauffeur" => 300,
        "Hélicoptère" => 900
    ];
    $transportCost = $transportRates[$transportMode];
    $total += $transportCost * $number_of_participants * $tripDuration;

    // Steps 1 to 3
    for ($i = 1; $i < $step_number; $i++) {
        $stepDuration = $trip['step_' . $i]['dates']['duration'];
        $participants = intval($_POST['participants_' . $i]);

        // Hotel price
        $hotelName = $_POST['hotel_' . $i];
        $hotelIndex = array_search($hotelName, $trip['hotel']);
        $hotelPrice = $trip['hotel_price'][$hotelIndex];
        
        $total += $hotelPrice * $participants * $stepDuration;

        // Pension
        $pension = $_POST['pension_' . $i];
        if ($pension === "Tout inclus") {
            $total += 50 * $participants * $stepDuration;
        }

        // Activity price
        $activityName = $_POST['activite_' . $i];
        $activityIndex = array_search($activityName, $trip['step_' . $i]['activities']) ?? 0;
        $activityPrice = $trip['step_' . $i]['activities_price'][$activityIndex];
        
        $total += $activityPrice * $participants;
    }

    // Apply VIP discount
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === "VIP") {
        $total *= 0.9;
    }
    return $total;
}
?>