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
        header("Location: ../src/error_page.php?error=dataNotFound");
        exit();
    }

    // Verification of data structure
    if (!isset($data['trip']) || !is_array($data['trip'])) {
        header("Location: ../src/error_page.php?error=dataCorrupted");
        exit();
    }

    return $data;
}

// Find a trip with its id
function tripFinder($data, $trip_id) {
    // Check that the trip matches the ID in 'trip_data.json'
    $trip = null;
    foreach ($data['trip'] as $journey) {
        if ($journey['id'] == $trip_id) {
            $trip = $journey;
            break;
        }
    }
    if ($trip === null) {
        header("Location: ../src/error_page.php?error=tripNotFound");
        exit();
    }
    return $trip;
}

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

// Display a trip as a map according to a user's search request
function displayTrip($data, $tag, $trip_number) {

    // Manage display when only one result is obtained
    if($trip_number > 1) {
        $plural = 's';
    } else {
        $plural = '';
    }

    echo '<h2 class="result_text">Résultats pour "' . $tag . '" (' . $trip_number . ' voyage' . $plural . ' trouvé' . $plural . ')</h2>';

    if($trip_number != 0) {
        echo '<div class="result_container">';
        foreach ($data['trip'] as $journey) {
            foreach ($journey['tags'] as $keyword) {
                if ($keyword == $tag) {
                    $trip_found = true;
                    echo
                    '
                    <div class="card">
                        <img src="../assets/presentation/' . $journey['presentation_img_1'] . '" alt="Card presentation image" />
                        <div class="card_content">
                            <h2>'. $journey['title'] . '</h2>
                            <p>'. $journey['subtile'] . '</p>
                            <p>Date : <b>' . $journey['dates']['start_date'] . '</b> au <b>' . $journey['dates']['end_date'] . '</b></p>
                            <p>Spécificité : ' . $journey['special_features'][0] . '</p>
                            <p>Prix/personne : ' . $journey['price_per_person'] . '€</p>
                            <a href="../src/trip.php?id=' . $journey['id'] . '" class="explore">➤ Découvrir</a>
                        </div>
                    </div>';
                }
            }
        }
        echo '</div>';
    } else {
        echo
        '<h3 class="result_not_found">Aucun voyage ne correspond à votre recherche</h3>
        <button class="back_to_search_button">
            <a class="back_to_search_text" href="search.php">Cliquez ici pour retourner à la recherche</a>
        </button>';
    }
}

// Display trip presentation cards according to id provided
function displayCards($id_list, $data_file) {

    $data = dataDecode($data_file);

    foreach ($id_list as $trip_id) {
        $trip = tripFinder($data, $trip_id);
        if(!$trip) {
            header("Location: ../src/error_page.php?error=tripNotFound");
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

function isValidAdvancedSearch() {
    return !empty($_GET['destination']) && !empty($_GET['price_range']) && !empty($_GET['travel_type']) && !empty($_GET['date']) && !empty($_GET['travel_length']);
}
?>