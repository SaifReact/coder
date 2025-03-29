<?php
include('../../include/config.php');

if (!empty($_POST["catId"])) {
    $catId = intval($_POST['catId']);

    // Fetch subcategories based on selected category ID
    $query = mysqli_query($con, "SELECT * FROM subcategory WHERE catId = $catId");

    if (mysqli_num_rows($query) > 0) {
        echo '<option value="">Select Subcategory</option>';
        while ($row = mysqli_fetch_array($query)) {
            echo '<option value="' . htmlentities($row['id']) . '">' . htmlentities($row['subcategory']) . '</option>';
        }
    } else {
        echo '<option value="">No subcategory found</option>';
    }
}
?>
