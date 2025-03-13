<!-- trip.php : presentation page for a trip whose values change according to the 'trip_data.json' data file -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>CyLanta</title>
    <meta charset="utf-8" />
    <meta name="description" content="CyLanta travel agency website" />
    <meta name="author" content="Developped by MI5-A TEAM" />
    <meta name="keywords" content="voyage, agence de voyage, séjour, escapade, vacances, rechercher une destination" />
    <link rel="icon" type="image/png" href="../assets/visuals/ico_island.png" />
    <link rel="stylesheet" type="text/css" href="../css/base_style.css" />
    <link rel="stylesheet" type="text/css" href="../css/trip_style.css" />
</head>
<body>

<?php
    include("../includes/trip_functions.php");

    // Get trip ID from URL
    if (isset($_GET['id'])) {
        $trip_id = $_GET['id'];
    } else {
        $trip_id = null;
    }

    $data_file = '../data/trip_data.json';
    $decodedData = dataDecode($data_file);

    $trip = tripFinder($decodedData, $trip_id);
?>

    <div class="container">
        <!-- Navigation bar -->
        <div class="headbar">
            <div class="headbar_left">
                <a href="../index.php">
                    <img class="logo_img" src="../assets/visuals/cylanta_logo.png" alt="CyLanta Logo" />
                </a>
            </div>
            <div class="headbar_rest">
                <a class="headbar_item" href="../index.php">Accueil</a>
                <a class="headbar_item" href="../src/search.php">Destinations</a>
                <a class="headbar_item" href="../src/advanced_search.php">Rechercher un voyage</a>
            </div>
            <div class="headbar_right">
                <a class="headbar_my_space" href="../src/userpage.php">Mon espace</a>
                <a href="../src/userpage.php"><img class="user_img_nav" src="../assets/profile_pic/example_pfp.jpg" /></a>
            </div>
        </div>
        <div class="separate"></div>

        <div class="description">
            <h2><?php echo $trip['title'];?></h2>
            <h3><?php echo $trip['subtitle'];?></h3>
            <br>
        </div>

        <div class="image_container">
            <img class="presentation_img" src="../assets/presentation/<?php echo $trip['presentation_img_1'];?>" alt="<?php echo $trip['presentation_img_1'];?>" />
            <div class="side_images">
                <img class="small_img bottom_img" src="../assets/presentation/<?php echo $trip['presentation_img_2'];?>" alt="<?php echo $trip['presentation_img_2'];?>" />
                <img class="small_img top_img" src="../assets/presentation/<?php echo $trip['presentation_img_3'];?>" alt="<?php echo $trip['presentation_img_3'];?>" />
            </div>
        </div>

        <h3>Aperçu</h3>
        <hr class="underline_info line" />

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
                    src="https://www.google.com/maps/embed?pb=<?php echo $trip['trip_location'];?>"
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
                    <li>Durée du séjour : <?php echo $trip['dates']['duration'];?></li>
                    <li>Spécificité : <?php echo $trip['special_features'][0];?></li>
                    <li><?php echo $trip['special_features'][1];?></li>
                    <li><?php echo $trip['special_features'][2];?></li>
                    <li><?php echo $trip['special_features'][3];?></li>
                </ul>
            </div>
        </div>

        <h3>Configuration des étapes</h3>
        <hr class="underline_timeline line" />
        
        <div class="steps">
            <div class="timeline">
                <div class="step active">1</div>
                <div class="step_line"></div>
                <div class="step">2</div>
                <div class="step_line"></div>
                <div class="step">3</div>
            </div>
        </div>

        <form action="confirmation.php" method="post">
            <!-- First board -->
            <div class="board steps_board">
                <h3 class="legend">Étape 1: <?php echo $trip['step_1']['title'];?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Durée de l'étape</th>
                            <th>Hôtel</th>
                            <th>Pension</th>
                            <th>Activité</th>
                            <th>Participants</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2 jours</td>
                            <td>
                                <select name="hotel_1">
                                    <option value="<?php echo $trip['hotel'][0];?>"><?php echo $trip['hotel'][0];?></option>
                                    <option value="<?php echo $trip['hotel'][1];?>"><?php echo $trip['hotel'][1];?></option>
                                    <option value="<?php echo $trip['hotel'][2];?>"><?php echo $trip['hotel'][2];?></option>
                                </select>
                            </td>
                            <td>
                                <select name="pension_1">
                                    <option value="tout_inclus">Tout inclus</option>
                                    <option value="petit_dejeuner">Petit déjeuner uniquement</option>
                                    <option value="dejeuner">Déjeuner uniquement</option>
                                    <option value="demi_pension">Diner uniquement</option>
                                </select>
                            </td>
                            <td>
                                <select name="activite_1">
                                <option value="<?php echo $trip['step_1']['activities'][0];?>"><?php echo $trip['step_1']['activities'][0];?></option>
                                    <option value="<?php echo $trip['step_1']['activities'][1];?>"><?php echo $trip['step_1']['activities'][1];?></option>
                                    <option value="<?php echo $trip['step_1']['activities'][2];?>"><?php echo $trip['step_1']['activities'][2];?></option>
                                </select>
                            </td>
                            <td>
                                <select name="participants_1">
                                    <option value="2_personnes">2 personnes</option>
                                    <option value="3_personnes">3 personnes</option>
                                    <option value="4_personnes">4 personnes</option>
                                    <option value="4_personnes">5 personnes</option>
                                    <option value="4_personnes">6 personnes</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Second board -->
            <div class="board steps_board">
                <h3 class="legend">Étape 2: <?php echo $trip['step_2']['title'];?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Durée de l'étape</th>
                            <th>Hôtel</th>
                            <th>Pension</th>
                            <th>Activité</th>
                            <th>Participants</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>3 jours</td>
                            <td>
                            <select name="hotel_2">
                                <option value="<?php echo $trip['hotel'][0];?>"><?php echo $trip['hotel'][0];?></option>
                                <option value="<?php echo $trip['hotel'][1];?>"><?php echo $trip['hotel'][1];?></option>
                                <option value="<?php echo $trip['hotel'][2];?>"><?php echo $trip['hotel'][2];?></option>
                            </select>
                            </td>
                            <td>
                                <select name="pension_2">
                                    <option value="tout_inclus">Tout inclus</option>
                                    <option value="petit_dejeuner">Petit déjeuner uniquement</option>
                                    <option value="dejeuner">Déjeuner uniquement</option>
                                    <option value="demi_pension">Diner uniquement</option>
                                </select>
                            </td>
                            <td>
                                <select name="activite_2">
                                    <option value="<?php echo $trip['step_2']['activities'][0];?>"><?php echo $trip['step_2']['activities'][0];?></option>
                                    <option value="<?php echo $trip['step_2']['activities'][1];?>"><?php echo $trip['step_2']['activities'][1];?></option>
                                    <option value="<?php echo $trip['step_2']['activities'][2];?>"><?php echo $trip['step_2']['activities'][2];?></option>
                                </select>
                            </td>
                            <td>
                                <select name="participants_2">
                                    <option value="2_personnes">2 personnes</option>
                                    <option value="3_personnes">3 personnes</option>
                                    <option value="4_personnes">4 personnes</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Third board -->
            <div class="board steps_board">
                <h3 class="legend">Étape 3: <?php echo $trip['step_3']['title'];?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Durée de l'étape</th>
                            <th>Hôtel</th>
                            <th>Pension</th>
                            <th>Activité</th>
                            <th>Participants</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2 jours</td>
                            <td>
                            <select name="hotel_3">
                                    <option value="<?php echo $trip['hotel'][0];?>"><?php echo $trip['hotel'][0];?></option>
                                    <option value="<?php echo $trip['hotel'][1];?>"><?php echo $trip['hotel'][1];?></option>
                                    <option value="<?php echo $trip['hotel'][2];?>"><?php echo $trip['hotel'][2];?></option>
                                </select>
                            <td>
                                <select name="pension_3">
                                    <option value="tout_inclus">Tout inclus</option>
                                    <option value="petit_dejeuner">Petit déjeuner uniquement</option>
                                    <option value="dejeuner">Déjeuner uniquement</option>
                                    <option value="demi_pension">Diner uniquement</option>
                                </select>
                            </td>
                            <td>
                                <select name="activite_3">
                                    <option value="<?php echo $trip['step_3']['activities'][0];?>"><?php echo $trip['step_3']['activities'][0];?></option>
                                    <option value="<?php echo $trip['step_3']['activities'][1];?>"><?php echo $trip['step_3']['activities'][1];?></option>
                                    <option value="<?php echo $trip['step_3']['activities'][2];?>"><?php echo $trip['step_3']['activities'][2];?></option>
                                </select>
                            </td>
                            <td>
                                <select name="participants_3">
                                    <option value="2_personnes">2 personnes</option>
                                    <option value="3_personnes">3 personnes</option>
                                    <option value="4_personnes">4 personnes</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <h3 class="planification_text">Planifiez votre voyage</h3>
        <hr class="underline_planification line" />

        <!-- Planification board -->
        <div class="board">
        <table>
            <thead>
                <tr>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Participants</th>
                    <th>Transports</th>
                    <th>Prix/pers</th>
                    <th>Prix total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b><?php echo $trip['dates']['start_date'];?></b></td>
                    <td><b><?php echo $trip['dates']['end_date'];?></b></td>
                    <td>
                        <select name="nombre_participants">
                            <option value="2_personnes">2 personnes</option>
                            <option value="3_personnes">3 personnes</option>
                            <option value="4_personnes">4 personnes</option>
                            <option value="4_personnes">5 personnes</option>
                            <option value="4_personnes">6 personnes</option>
                        </select>
                    </td>
                    <td>
                        <select name="transports">
                            <option value="bâteau">Aucun</option>
                            <option value="velo">Vélo (30€/J)</option>
                            <option value="voityre">Voiture (90€/J)</option>
                            <option value="bâteau">Bâteau (100€/J)</option>
                            <option value="taxi">Chauffeur privé (500€/J)</option>
                            <option value="hélicoptère">Hélicoptère (900€/J)</option>
                        </select>
                    </td>
                    <td><?php echo $trip['price_per_person'];?>€</td>
                    <td><?php echo $trip['total_price'];?>€</td>
                </tr>
            </tbody>
        </table>
        </div>
            <button class="reservation_button" type="submit">
                <p class="reservation_text">Réserver</p>
            </button>
        </form>

        <div class="separate_footer"></div>

        <!-- Footer -->
        <footer>
            <div class="footer_section">
                <h3>À Propos</h3>
                <p>Chez CyLanta, nous concevons des voyages sur mesure, uniques et adaptés à vos envies.
                    Passionnés d'évasion et grâce à notre réseau de partenaires, nous sélectionnons pour vous les
                    meilleures
                    adresses et activités exclusives.
                    Que ce soit un safari, un road trip ou un séjour bien-être, chaque voyage est pensé dans les
                    moindres
                    détails. Votre aventure commence ici !
                </p>
            </div>
            <div class="footer_section">
                <h3>Nos Contacts</h3>
                <ul class="other">
                    <li><a href="mailto:CyLanta@cy-tech.fr">Email: CyLanta@cy-tech.fr</a></li>
                    <li><a href="tel:+33123456789">Téléphone: +33 1 23 45 67 89</a></li>
                    <li><a href="https://www.google.com/maps?q=49.035290202793036, 2.070567152915135" target="_BLANK">Adresse: Av. du Parc, 95000 Cergy</a></li>
                </ul>
            </div>
            <div class="footer_section">
                <h3>Nos Partenaires</h3>
                <div class="partners">
                    <a href="https://www.cyu.fr/" target="_blank"><img src="../assets/visuals/cy_favicon.png" alt="Partenaire 1" /></a>
                    <a href="https://cytech.cyu.fr/" target="_blank"><img src="../assets/visuals/cytech_icon.png" alt="Partenaire 2" /></a>
                    <a href="https://www.cergy.fr/accueil/" target="_blank"><img src="../assets/visuals/cergy_ville.jpg" alt="Partenaire 3" /></a>
                </div>
            </div>
        </footer>
    <!-- Script to browse a timeline and select steps when choosing a trip -->
    <script src="../includes/timelineBrowse.js"></script>
</body>
</html>