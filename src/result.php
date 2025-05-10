<?php
require_once("../includes/trip_functions.php");

$data_file = '../data/trip_data.json';
$data = dataDecode($data_file);
?>

<!-- result.php : result of a specific or non-specific search -->

<!-- Header display -->
<?php displayHeader();

// Script to filter trips by a specific tag (quicksearch)

// If the tag is included in the url, the result requested by the user may be a quick search
if (!empty($_GET['tag'])) {
    $tag = urldecode(trim($_GET['tag']));
    $tag = htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); // Escape special characters: XSS protection
    $tag = strtolower($tag);
    $tag = addslashes($tag);

    $trip_number = getTripNumber($data, $tag);

    // Shows travel cards matching the search
    displayByTag($data, $tag, $trip_number);
}

// If the tag is not included in the url, the result requested by the user is a specific search
else if (isValidAdvancedSearch()) {
    // Shows travel cards matching the search
    displayByFilter($data);
} else {
    displayNoResult();
}
?>

<!-- Footer -->
<?php displayFooter(); ?>
<script src="../script/sortResult.js"></script>
</body>

</html>