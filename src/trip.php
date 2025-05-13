<?php
require_once("../includes/trip_functions.php");

$data_file = '../data/trip_data.json';
$decodedData = dataDecode($data_file);

// Get trip ID from URL
if (isset($_GET['id'])) {
    $trip_id = $_GET['id'];
} else {
    $trip_id = null;
}

$trip = tripFinder($decodedData, $trip_id);

$_SESSION['trip'] = $trip;

if (empty($_SESSION['trip'])) {
    displayError("Trip affectation failed.");
}

// If the user is logged in, check if a trip is already purchased
if (isset($_SESSION['user'])) {
    if (isPurchased($_SESSION['trip']['id']) == true) {
        header("Location: history.php");
        exit;
    }
}
?>

<script>
    // Retrieve data from the json file for JavaScript functions
    const tripData = <?php echo json_encode($trip); ?>;

    // Checks if the user has the “VIP” role
    const isVIP = <?php echo isset($_SESSION['user']) && $_SESSION['user']['role'] === 'VIP' ? 'true' : 'false'; ?>;
</script>

<!-- trip.php : presentation page for a trip whose values change according to the 'trip_data.json' data file -->

<!-- Header display -->
<?php displayHeader(); ?>

<div class="separate"></div>

<div class="description">
    <h2><?php echo $trip['title']; ?></h2>
    <h3><?php echo $trip['subtitle']; ?></h3>
    <br>
</div>

<div class="image_container">
    <img class="presentation_img" src="../assets/presentation/<?php echo $trip['presentation_img_1']; ?>" alt="<?php echo $trip['presentation_img_1']; ?>" />
    <div class="side_images">
        <img class="small_img bottom_img" src="../assets/presentation/<?php echo $trip['presentation_img_2']; ?>" alt="<?php echo $trip['presentation_img_2']; ?>" />
        <img class="small_img top_img" src="../assets/presentation/<?php echo $trip['presentation_img_3']; ?>" alt="<?php echo $trip['presentation_img_3']; ?>" />
    </div>
</div>

<h3>Aperçu</h3>
<hr class="underline_info" />

<div class="overview">
    <div class="service_info">
        <h4>Prestations</h4>
        <!-- List of services -->
        <ul class="service_list">
            <div class="left_column">
                <li><img class="service_icon" src="../assets/visuals/pres_wifi_icon.png" alt="icon1" />WIFI</li>
                <li><img class="service_icon" src="../assets/visuals/pres_sport_icon.png" alt="icon2" />Salle de sport</li>
                <li><img class="service_icon" src="../assets/visuals/pres_love_icon.png" alt="icon3" />Décoration romantique</li>
            </div>
            <div class="right_column">
                <li><img class="service_icon" src="../assets/visuals/pres_pool_icon.png" alt="icon4" />Piscine</li>
                <li><img class="service_icon" src="../assets/visuals/pres_spa_icon.png" alt="icon5" />Spa et bien-être</li>
                <li><img class="service_icon" src="../assets/visuals/pres_key_icon.png" alt="icon6" />Conciergerie personnelle</li>
            </div>
        </ul>
    </div>

    <div class="location_info">
        <h4>Emplacement</h4>
        <iframe
            src="https://www.google.com/maps/embed?pb=<?php echo $trip['trip_location']; ?>"
            width="400"
            height="250"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </div>

    <div class="voyage_info">
        <h4>Informations</h4>
        <ul class="info_list">
            <li>Dates : <?php echo "<b>" . $trip['dates']['start_date'] . "</b> au <b>" . $trip['dates']['end_date'] . "</b>"; ?></li>
            <li>Durée du séjour : <?php echo $trip['dates']['duration']; ?></li>
            <li>Frais de prestation: <?php echo '<b>' . $trip['price_per_person'] . '€</b> par personne'; ?></li>
            <li>Spécificité : <?php echo $trip['special_features'][0]; ?></li>
            <li>Le plus : <?php echo $trip['special_features'][1]; ?></li>
        </ul>
    </div>
</div>

<form action="confirmation.php" method="post">
    <h3 class="planification_text">Planifiez votre voyage</h3>
    <hr class="underline_planification line" />

    <div class="reservation-container">
        <div class="step_container">
            <span class="step_number">1</span>
            <span class="step_title">Configurez votre vol</span>

            <div class="form_row">
                <div class="form_group">
                    <label for="departure_city">Ville de départ</label>
                    <div class="select_wrapper">
                        <select name="departure_city" class="form_control">
                            <option selected>Au départ de Paris</option>
                            <option value="Lyon">Au départ de Lyon</option>
                            <option value="Marseille">Au départ de Marseille</option>
                            <option value="Bordeaux">Au départ de Bordeaux</option>
                        </select>
                    </div>
                </div>

                <div class="form_group">
                    <label for="flight">Classe de cabine</label>
                    <div class="select_wrapper">
                        <select name="flight" class="form_control">
                            <option value="Classe Économique" selected>Économique (800€/pers)</option>
                            <option value="Classe Confort">Classe confort (1200€/pers)</option>
                            <option value="Classe Affaires">Classe affaires (1400€/pers)</option>
                            <option value="Première Classe">Première classe (2000€/pers)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="step_container">
            <span class="step_number">2</span>
            <span class="step_title">Personnalisez votre séjour</span>

            <div class="form_row">
                <div class="form_group">
                    <label for="number_of_participants">Nombre de voyageurs</label>
                    <div class="select_wrapper">
                        <select name="number_of_participants" class="form_control">
                            <option value="2">2 personnes</option>
                            <option value="3">3 personnes</option>
                            <option value="4">4 personnes</option>
                            <option value="5">5 personnes</option>
                            <option value="6">6 personnes</option>
                        </select>
                    </div>
                </div>

                <div class="form_group">
                    <label for="formula">Transports sur place</label>
                    <div class="select_wrapper">
                        <select name="transports" class="form_control">
                            <option value="Aucun" selected>Aucun</option>
                            <option value="Vélo">Vélo (30€/pers/jour)</option>
                            <option value="Voiture">Voiture (90€/pers/jour)</option>
                            <option value="Bâteau">Bâteau (100€/pers/jour)</option>
                            <option value="Chauffeur">Chauffeur (300€/pers/jour)</option>
                            <option value="Hélicoptère">Hélicoptère (900€/pers/jour)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <span class="step_number">3</span>
    <span class="step_title">Composez les étapes de votre voyage</span>

    <!-- Step 1 -->
    <div class="step_card active" data_step="1">
        <h4>Étape 1 : <?php echo $trip['step_1']['title']; ?></h4>
        <p>Durée : <?php echo $trip['step_1']['dates']['duration']; ?> jours</p>

        <div class="field_row">
            <div class="select_label">
                <label>Hôtel
                    <select name="hotel_1" class="dynamic_input" data_price="hotel"></select>
                </label>
            </div>
            <div class="price_label">
                <span>Prix/personne/jour</span>
                <div class="price_display"> €</div>
            </div>
        </div>

        <div class="field_row">
            <div class="select_label">
                <label>Pension
                    <select name="pension_1" class="dynamic_input" data_price="pension"></select>
                </label>
            </div>
            <div class="price_label">
                <div class="price_display">-- €</div>
            </div>
        </div>

        <div class="field_row">
            <div class="select_label">
                <label>Activité
                    <select name="activite_1" class="dynamic_input" data_price="activity">
                    </select>
                </label>
            </div>
            <div class="price_label">
                <div class="price_display"> €</div>
            </div>
        </div>

        <label>Nombre de participants
            <select name="participants_1"></select>
        </label>
    </div>

    <!-- Step 2 -->
    <div class="step_card active" data_step="2">
        <h4>Étape 2 : <?php echo $trip['step_2']['title']; ?></h4>
        <p>Durée : <?php echo $trip['step_2']['dates']['duration'] ?> jours</p>

        <div class="field_row">
            <div class="select_label">
                <label>Hôtel
                    <select name="hotel_2" class="dynamic_input" data_price="hotel"></select>
                </label>
            </div>
            <div class="price_label">
                <span>Prix/personne/jour</span>
                <div class="price_display"> €</div>
            </div>
        </div>

        <div class="field_row">
            <div class="select_label">
                <label>Pension
                    <select name="pension_2" class="dynamic_input" data_price="pension"></select>
                </label>
            </div>
            <div class="price_label">
                <div class="price_display">-- €</div>
            </div>
        </div>

        <div class="field_row">
            <div class="select_label">
                <label>Activité
                    <select name="activite_2" class="dynamic_input" data_price="activity"></select>
                </label>
            </div>
            <div class="price_label">
                <div class="price_display"> €</div>
            </div>
        </div>

        <label>Nombre de participants
            <select name="participants_2"></select>
        </label>
    </div>

    <!-- Step 3 -->
    <div class="step_card active" data_step="3">
        <h4>Étape 3 : <?php echo $trip['step_3']['title']; ?></h4>
        <p>Durée : <?php echo $trip['step_3']['dates']['duration'] ?> jours</p>

        <div class="field_row">
            <div class="select_label">
                <label>Hôtel
                    <select name="hotel_3" class="dynamic_input" data_price="hotel"></select>
                </label>
            </div>
            <div class="price_label">
                <span>Prix/personne/jour</span>
                <div class="price_display"> €</div>
            </div>
        </div>

        <div class="field_row">
            <div class="select_label">
                <label>Pension
                    <select name="pension_3" class="dynamic_input" data_price="pension"></select>
                </label>
            </div>
            <div class="price_label">
                <div class="price_display">-- €</div>
            </div>
        </div>

        <div class="field_row">
            <div class="select_label">
                <label>Activité
                    <select name="activite_3" class="dynamic_input" data_price="activity"></select>
                </label>
            </div>
            <div class="price_label">
                <div class="price_display"> €</div>
            </div>
        </div>

        <label>Nombre de participants
            <select name="participants_3"></select>
        </label>
    </div>

    <div class="steps">
        <div class="timeline">
            <div class="step active" data_step="1">1</div>
            <div class="step_line"></div>
            <div class="step" data_step="2">2</div>
            <div class="step_line"></div>
            <div class="step" data_step="3">3</div>
        </div>
    </div>

    <span class="step_number">4</span>
    <span class="step_title">Confirmez votre voyage</span>

    <p class="price"><b></b></p>
    <?php
    if (!isset($_SESSION['user'])) {
        echo '<div id="bubble" class="hidden"></div>';
        echo '<button class="reservation_button" onclick="displayBubble(event, \'Vous devez être connecté pour confirmer ce voyage !\')">';
    } else {
        echo '<button class="reservation_button" type="submit">';
    }
    ?>
    <p class="reservation_text">Confirmer ma sélection</p>
    </button>
</form>

<!-- Footer -->
<?php displayFooter(); ?>

<!-- Script to browse a timeline and select steps when choosing a trip -->
<script src="../script/timelineBrowse.js"></script>

<!-- Script to dynamically display options and calculate price  -->
<script src="../script/priceCalculator.js"></script>
<script src="../script/optionsLoader.js"></script>
</body>

</html>