<?php
require_once('../includes/trip_functions.php');
?>

<!-- advanced_search.php : search for a trip based on specific characteristics -->

<!-- Header display -->
<?php displayHeader(); ?>
<div class="text_above">Trouvez votre escapade idéale en quelques clics</div>
<div class="search_bar">
    <form class="search_bar_form" action="result.php" method="get">
        <table class="search_bar_tab">
            <tr>
                <!-- Search bar -->
                <td>
                    <input class="search_bar_input" list="destinations" placeholder="Mot clé (aventure, famille, ...) 🔎" name="tag" />
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
                        <button type="button" class="dropdown_button price_button">Prix/pers ⏷</button>
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
                        <button type="button" class="dropdown_button duration_button">10 jours</button>
                        <div class="dropdown_content duration_content">
                            <label>
                                <input class="range" type="range" name="travel_length" min="8" max="12" step="1" value="" />
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
<?php displayFooter(); ?>

<!-- Script to display drop-down lists -->
<script src="../script/advancedSearch.js"></script>
</body>

</html>