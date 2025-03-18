<!-- advanced_search.php : search for a trip based on specific characteristics -->

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
    <link rel="stylesheet" type="text/css" href="../css/advanced_search_style.css" />
</head>
<body>
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
                <a class="headbar_item" href="search.php">Destinations</a>
                <a class="headbar_item" href="advanced_search.php">Rechercher un voyage</a>
            </div>
            <div class="headbar_right">
                <a class="headbar_my_space" href="userpage.php">Mon espace</a>
                <a href="userpage.php"><img class="user_img_nav" src="../assets/profile_pic/example_pfp.jpg" /></a>
            </div>
        </div>

        <div class="text_above">Trouvez votre escapade idéale en quelques clics</div>
        <div class="search_bar">
            <form class="search_bar_form" action ="result.php" method="get">
                <table class="search_bar_tab">
                    <tr>
                        <!-- Search bar -->
                        <td>
                            <input class="search_bar_input" list="destinations" placeholder="Sélectionnez une île... 🔎" name="destination" />
                            <datalist id="destinations">
                                <option value="Tahiti"></option>
                                <option value="Bora-Bora"></option>
                                <option value="Moorea"></option>
                                <option value="Huahine"></option>
                                <option value="Raiatea"></option>
                                <option value="Taha'a"></option>
                                <option value="Rangiroa"></option>
                                <option value="Fakarava"></option>
                                <option value="Nuku Hiva"></option>
                                <option value="Rangiroa"></option>
                                <option value="Tetiaroa"></option>
                            </datalist>
                        </td>
                        <!-- Drop-down list to select a trip -->
                        <td>
                            <div class="dropdown">
                                <button type="button" class="dropdown_button price_button">Prix/pers</button>
                                <div class="dropdown_content price_content">
                                    <label>
                                        <input type="checkbox" name="price_range" value="-2000" /> Moins de 2000€
                                    </label>
                                    <label>
                                        <input type="checkbox" name="price_range" value="2000-3000" /> 2000€ - 3000€
                                    </label>
                                    <label>
                                        <input type="checkbox" name="price_range" value="3000-4000" /> 3000€ - 4000€
                                    </label>
                                    <label>
                                        <input type="checkbox" name="price_range" value="4000-5000" /> 4000€ - 5000€
                                    </label>
                                    <label>
                                        <input type="checkbox" name="price_range" value="+5000" /> Plus de 5000€
                                    </label>
                                </div>
                            </div>
                        </td>
                        <!-- Type of trip selection -->
                        <td>
                            <div class="dropdown">
                                <button type="button" class="dropdown_button type_button">Type de voyage</button>
                                <div class="dropdown_content type_content">
                                    <label>
                                        <input type="checkbox" name="travel_type" value="noces" /> Voyage de Noces
                                    </label>
                                    <label>
                                        <input type="checkbox" name="travel_type" value="découverte" /> Voyage Découverte
                                    </label>
                                    <label>
                                        <input type="checkbox" name="travel_type" value="aventure" /> Voyage d'Aventure
                                    </label>
                                    <label>
                                        <input type="checkbox" name="travel_type" value="détente" /> Voyage Détente
                                    </label>
                                    <label>
                                        <input type="checkbox" name="travel_type" value="luxe" /> Séjour de Luxe
                                    </label>
                                </div>
                            </div>
                        </td>
                        <!-- Date selection -->
                        <td>
                            <div class="date_container">
                                <div class="date_box">
                                    <input type="date" name="date" id="date_input" class="date_input" />
                                </div>
                            </div>
                        </td>
                        <!-- Duration selection -->
                        <td>
                            <div class="dropdown">
                                <button type="button" class="dropdown_button duration_button">Durée</button>
                                <div class="dropdown_content duration_content">
                                    <label>
                                        <input class="range" type="range" name="travel_length" min="8" max="12" step="1" />
                                    </label>
                                </div>
                            </div>
                        </td>
                        <!-- Submit button -->
                        <td>
                            <button type="submit" class="search_bar_submit">Rechercher</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    <!-- Footer -->
    <?php include('../includes/footer.php'); displayFooter();?>

    <!-- Script to display drop-down lists -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to manage the display of drop-down lists
            function setupDropdown(buttonClass, contentClass) {
                const dropdownButton = document.querySelector(`.${buttonClass}`);
                const dropdownContent = document.querySelector(`.${contentClass}`);

                if (dropdownButton && dropdownContent) {
                    dropdownButton.addEventListener("click", function (event) {
                        event.stopPropagation(); // Prevents immediate closing
                        const isVisible = dropdownContent.style.display === "block";
                        closeAllDropdowns(); // Closes all other menus
                        dropdownContent.style.display = isVisible ? "none" : "block"; // Toggle display
                    });

                    dropdownContent.addEventListener("click", function (event) {
                        event.stopPropagation(); // Prevents closing on internal click
                    });
                }
            }

            // Function to close all dropdowns
            function closeAllDropdowns() {
                document.querySelectorAll(".dropdown_content").forEach(content => {
                    content.style.display = "none";
                });
            }

            // Close menus when clicked elsewhere
            document.addEventListener("click", closeAllDropdowns);

            // Initialize dropdowns
            setupDropdown("price_button", "price_content");
            setupDropdown("type_button", "type_content");
            setupDropdown("duration_button", "duration_content");
        });
    </script>

    <!-- Script for entering a valid travel time -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const durationInput = document.querySelector('input[name="travel_length"]');
            const durationButton = document.querySelector('.duration_button');

            // Updates the button with the selected duration
            durationInput.addEventListener("input", function () {
                let value = parseInt(durationInput.value, 10);

                // Check that the value is a number between 8 and 15
                if (!isNaN(value)) {
                    if (value < 8) {
                        durationInput.value = 8;
                    }
                    else if (value > 12) {
                        durationInput.value = 12;
                    }
                }

                // Updates the button when a number of days is entered
                if (durationInput.value) {
                    durationButton.textContent = durationInput.value + " jours";
                } else {
                    durationButton.textContent = "Durée";
                }
            });
        });
    </script>
    </body>
</html>