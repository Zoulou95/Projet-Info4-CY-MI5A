<?php

// Function to retrieve useful data from 'trip_data.json file and display specific trip information
function dataDecode($data_file) {
    // Read the 'trip_data.json' file and convert it into a PHP array
    if (file_exists($data_file)) {
        $json_data = file_get_contents($data_file);
        $data = json_decode($json_data, true); 
    }  
    else
    {
        header("Location: ../src/error_page.php");
        exit();
    }

    // Verification of data structure
    if (!isset($data['trip']) || !is_array($data['trip'])) {
        header("Location: ../src/error_page.php");
        exit();
    }

    return $data;
}

// Find a trip with its id
function tripFinder($data, $trip_id) {
    // Check that the trip match the ID in 'trip_data.json'
    $trip = null;
    foreach ($data['trip'] as $journey) {
        if ($journey['id'] == $trip_id) {
            $trip = $journey;
            break;
        }
    }
    if ($trip === null) {
        header("Location: ../src/error_page.php");
        exit();
    }
    return $trip;
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

function printCard($journey) {
    echo
    '
    <div class="card">
        <img src="../assets/presentation/' . $journey['presentation_img_1'] . '" alt="Card presentation image" />
        <div class="card_content">
            <h2>'. $journey['title'] . '</h2>
            <p>'. $journey['subtile'] . '</p>
            <p>Date : <b>' . $journey['dates']['start_date'] . '</b> au <b>' . $journey['dates']['end_date'] . '</b></p>
            <p>Spécificité : ' . $journey['special_features'][0] . '</p>
            <p>Prix/personne : <b>' . $journey['price_per_person'] . '€</b></p>
            <a href="../src/trip.php?id=' . $journey['id'] . '" class="explore">➤ Découvrir</a>
        </div>
    </div>';
}

// Display a trip as a map according to a user's quicksearch request
function displayByTag($data, $tag, $trip_number) {

    // Manage display when only one result is obtained
    if($trip_number > 1) {
        $plural = 's';
    } else {
        $plural = '';
    }

    echo '<h2 class="result_text">Résultat' . $plural . ' pour "' . $tag . '" (' . $trip_number . ' voyage' . $plural . ' trouvé' . $plural . ')</h2>';

    if($trip_number != 0) {
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

    $destination = $_GET['destination'];
    $price_range = $_GET['price_range'];
    $travel_type = $_GET['travel_type'];
    $date = $_GET['date'];
    $travel_length = $_GET['travel_length'];

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
    if($found == false) {
        displayNoResult();
    }
}

// Display trip presentation cards according to id provided
function displayCards($id_list, $data_file) {

    $data = dataDecode($data_file);

    foreach ($id_list as $trip_id) {
        $trip = tripFinder($data, $trip_id);
        if(!$trip) {
            header("Location: ../src/error_page.php?");
        }
        echo
        '<div class="card">
            <img src="../assets/presentation/' . $trip['presentation_img_1'] . '" alt="Trip image" />
            <div class="card_content">
                <h2>' . $trip['presentation_title'] . '</h2>
                <p>' . $trip['description'] . '</p>
                <a href="../src/trip.php?id=' . $trip['id'] . '" class="explore">➤ Découvrir</a>
            </div>
        </div>';
    }
}

// Check if the user's advanced search is valid
function isValidAdvancedSearch() {
    return !empty($_GET['destination']) || !empty($_GET['price_range']) || !empty($_GET['travel_type']) || !empty($_GET['date']) || !empty($_GET['travel_length']);
}

// Check if the user has configured his trip correctly
function isConfigValid() {
    $res = 1; // 1 = OK ; 0 = ERROR

    for($i=1; $i<4; $i++) {
        if(!isset($_POST['hotel_' . $i]) || !isset($_POST['pension_' . $i]) || !isset($_POST['activite_' . $i]) || !isset($_POST['participants_' . $i])) {
            $res = 0;
            break;
        }
    }

    if(!isset($_POST['number_of_participants']) || !isset($_POST['transports']) || !isset($_SESSION['price_per_person']) || !isset($_SESSION['id'])) {
        $res = 0;
    }

    return $res;
}

function displayNoResult() {
    echo
    '<h3 class="result_not_found">Aucun voyage ne correspond à votre recherche</h3>
    <button class="back_to_search_button">
        <a class="back_to_search_text" href="search.php">Cliquez ici pour retourner à la recherche</a>
    </button>';
}

function priceCalc($price_pers, $total_price) {
    $total = intval($price_pers) * intval($total_price);

    return $total;
}
?>