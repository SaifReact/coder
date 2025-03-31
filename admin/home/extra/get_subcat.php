<?php
include('../../include/config.php');

header('Content-Type: text/html; charset=UTF-8'); // Ensure proper encoding

// Debugging: Log incoming POST data
file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);

// Check if `catId` is set and valid
if (!isset($_POST["catId"]) || !is_numeric($_POST["catId"])) {
    echo '<option value="">Invalid request</option>';
    exit;
}

$catId = intval($_POST["catId"]); // Ensure integer value

// Debugging: Log `catId`
file_put_contents('debug.log', "catId received: $catId\n", FILE_APPEND);

$query = mysqli_query($con, "SELECT * FROM subcategory WHERE catId = $catId");

if (!$query) {
    echo '<option value="">Database error: ' . mysqli_error($con) . '</option>';
    exit;
}

if (mysqli_num_rows($query) > 0) {
    echo '<option value="">Select Subcategory</option>';
    while ($row = mysqli_fetch_array($query)) {
        echo "<option value='" . htmlentities($row['id']) . "'>" 
															 . htmlentities($row['subCatName']) . " - " 
															 . htmlentities($row['subCatName_en']) . "</option>";
    }
} else {
    echo '<option value="">No subcategory found</option>';
}
?>


