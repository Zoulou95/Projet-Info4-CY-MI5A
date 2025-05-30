<?php

require_once('error.php');

// Function to retrieve useful data from 'trip_data.json file
function dataDecode($data_file) {
    // Read the 'trip_data.json' file and convert it into a PHP array
    if (file_exists($data_file)) {
        $json_data = file_get_contents($data_file);

        if ($json_data === false) {
            displayError("unable to read " . $data_file);
        }

        $data = json_decode($json_data, true); 

        if ($data === null) {
            displayError("JSON decode error for " . $data_file);
        }

    }  
    else {
        displayError($data_file ." is missing.");
    }

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
    $tag = isset($_GET['tag']) && !empty($_GET['tag']) ? htmlspecialchars($_GET['tag']) : null;
    $price_range = isset($_GET['price_range']) ? intval($_GET['price_range']) : null;
    $travel_type = isset($_GET['travel_type']) ? $_GET['travel_type'] : null;
    $date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : null;
    $travel_length = isset($_GET['travel_length']) ? intval($_GET['travel_length']) : null;

    // Input verification
    $valid_travel_types = ["noces", "découverte", "aventure", "détente", "luxe"];
    
    if($travel_length !== null && ($travel_length < 8 || $travel_length > 12)) {
        displayError("Wrong travel length input.");
        return;
    }

    if ($travel_type !== null && !in_array($travel_type, $valid_travel_types)) {
        displayError("Wrong travel type input.");
        return;
    }

    echo '<h2 class="result_text">Résultats pour votre recherche</h2>';
    echo '<div class="result_container">';

    $found = false;
    
    foreach ($data['trip'] as $journey) {
        $match = true; // Assume match until proven otherwise
        
        // Check tag if provided
        if ($tag !== null) {
            $tag_match = false;
            foreach ($journey['tags'] as $journey_tag) {
                if (strtolower($tag) === strtolower($journey_tag)) {
                    $tag_match = true;
                    break;
                }
            }
            if (!$tag_match) {
                $match = false;
            }
        }
        
        // Check price range if provided
        if ($match && $price_range !== null) {
            if ($price_range === 5001) {
                // "Plus de 5000€" option
                if ($journey['price_per_person'] <= 5000) {
                    $match = false;
                }
            } else {
                // Other price ranges
                $min_range = $price_range - 1000;
                if ($journey['price_per_person'] < $min_range || $journey['price_per_person'] >= $price_range) {
                    $match = false;
                }
            }
        }
        
        // Check travel type if provided
        if ($match && $travel_type !== null) {
            if ($journey['specificity'] !== $travel_type) {
                $match = false;
            }
        }
        
        // Check date if provided (uncomment if needed)
        if ($match && $date !== null) {
            if ($journey['dates']['start_date'] !== $date) {
                $match = false;
            }
        }
        
        // Check travel length if provided (uncomment if needed)
        if ($match && $travel_length !== null) {
            if ($journey['dates']['length'] !== $travel_length) {
                $match = false;
            }
        }
        
        // Display the journey if it matches all criteria
        if ($match) {
            $found = true;
            printCard($journey);
        }
    }
    
    echo '</div>';
    
    if (!$found) {
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
?>