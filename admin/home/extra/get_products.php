<?php
include('../../include/config.php');

header('Content-Type: text/html; charset=UTF-8');

// Input validation
if (!isset($_POST['brSuId']) || !is_numeric($_POST['brSuId']) || !isset($_POST['catId']) || !is_numeric($_POST['catId']) || !isset($_POST['subCatId']) || !is_numeric($_POST['subCatId'])) {
    echo '<option value="">Invalid Category</option>';
    exit;
}

$brSuId = intval($_POST['brSuId']);
$catId = intval($_POST['catId']);
$subCatId = intval($_POST['subCatId']);

// Query products by brSuId, catId, subCatId
$query = mysqli_query($con, "SELECT id, productName, productName_bn 
    FROM products 
    WHERE brSuId = $brSuId AND catId = $catId AND subCatId = $subCatId");

if (!$query) {
    echo '<option value="">Database error: ' . mysqli_error($con) . '</option>';
    exit;
}

if (mysqli_num_rows($query) == 0) {
    echo '<option value="">No Products found</option>';
    exit;
}

// Build options
while ($row = mysqli_fetch_assoc($query)) {
    echo "<option value='" . htmlentities($row['id']) . "'>" .
         htmlentities($row['productName']) . " - " .
         htmlentities($row['productName_en']) .
         "</option>";
}
?>


