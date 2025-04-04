<?php
include('../../include/config.php');

header('Content-Type: text/html; charset=UTF-8');

// Input validation
if (!isset($_POST['catId']) || !is_numeric($_POST['catId'])) {
    echo '<option value="">Invalid Category</option>';
    exit;
}

$catId = intval($_POST['catId']);
$selectedSubCatId = isset($_POST['selectedSubCatId']) ? intval($_POST['selectedSubCatId']) : null;

// Query subcategories by catId
$query = mysqli_query($con, "SELECT * FROM subcategory WHERE catId = $catId");

if (!$query) {
    echo '<option value="">Database error: ' . mysqli_error($con) . '</option>';
    exit;
}

if (mysqli_num_rows($query) == 0) {
    echo '<option value="">No subcategories found</option>';
    exit;
}

// Build options
while ($row = mysqli_fetch_assoc($query)) {
    $selected = ($selectedSubCatId == $row['id']) ? 'selected' : '';
    echo "<option value='" . htmlentities($row['id']) . "' $selected>" .
         htmlentities($row['subCatName']) . " - " .
         htmlentities($row['subCatName_en']) .
         "</option>";
}
?>
