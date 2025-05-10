<?php
require_once("../includes/trip_functions.php");

$data_file = '../data/trip_data.json';
$data = dataDecode($data_file);
?>

<!-- result.php : result of a specific or non-specific search -->

<!-- Header display -->
<?php displayHeader();

// Script to filter trips by a specific tag (quicksearch)


if (isValidAdvancedSearch()) {
    // Shows travel cards matching the search
    displayByFilter($data);
} else if (!empty($_GET['tag'])) {
    $tag = urldecode(trim($_GET['tag']));
    $tag = htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); // Escape special characters: XSS protection
    $tag = strtolower($tag);
    $tag = addslashes($tag);

    $trip_number = getTripNumber($data, $tag);

    // Shows travel cards matching the search
    displayByTag($data, $tag, $trip_number);
}
?>

<!-- Footer -->
<?php displayFooter(); ?>
<script src="../script/sortResult.js"></script>
</body>

</html>