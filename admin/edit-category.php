<?php
session_start();
include('include/config.php');

// Redirect if not logged in
if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
    exit();
}

// Get category ID from URL & validate
$bid = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$bid) {
    die("Invalid category ID.");
}

// Fetch existing category data
$stmt = $con->prepare("SELECT catName, catName_en, catImage FROM category WHERE id = ?");
$stmt->bind_param("i", $bid);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();
$stmt->close();

// If category not found, show error
if (!$category) {
    die("category not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $catName = trim($_POST['catName']);
	$catName_en = trim($_POST['catName_en']);
    $catImage = $_FILES["catImage"]["name"];
    $tmpName = $_FILES["catImage"]["tmp_name"];
    $imageSize = $_FILES["catImage"]["size"];

    // Check if the file is uploaded
    if ($catImage) {
        // Validate image file type & size (Max 2MB)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $imageType = mime_content_type($tmpName);

        if (!in_array($imageType, $allowedTypes)) {
            $_SESSION['msg'] = "Invalid image format. Only JPG, PNG, and WebP allowed.";
        } elseif ($imageSize > 2 * 1024 * 1024) {
            $_SESSION['msg'] = "File is too large. Max 2MB allowed.";
        } else {
            // Create directory if not exists
            $dir = "categoryimages/" . $bid;
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            // Move uploaded file
            $filePath = "$dir/" . basename($catImage);
            move_uploaded_file($tmpName, $filePath);
        }
    } else {
        // If no new image uploaded, keep the existing image
        $catImage = $category['catImage']; // Use the existing image name
    }

    // Update database using prepared statements
    $stmt = $con->prepare("UPDATE category SET catName = ?, catName_en = ?, catImage = ? WHERE id = ?");
    $stmt->bind_param("sssi", $catName, $catName_en, $catImage, $bid);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "category Image Updated Successfully!";
        header('Location: category.php'); // Redirect to category.php after success
        exit();
    } else {
        $_SESSION['msg'] = "Error updating category.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('include/head.php'); ?>
</head>
<body>
    <?php include('include/header.php'); ?>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <?php include('include/sidebar.php'); ?>                
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Update Category (হালনাগাদ ক্যাটাগরি )</h3>
                            </div>
                            <div class="module-body">
                                <?php if (isset($_SESSION['msg'])) { ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Well done!</strong> <?php echo htmlentities($_SESSION['msg']); ?>
                                    </div>
                                    <?php unset($_SESSION['msg']); ?>
                                <?php } ?>

                                <br />

                                <form class="form-horizontal row-fluid" method="post" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">Category Name (ক্যাটাগরি নাম)</label>
                                        <div class="controls">
                                            <input type="text" name="catName" 
                                                value="<?php echo htmlentities($category['catName']); ?>" 
                                                class="span8 tip" required>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="basicinput">Category Name Eng (ক্যাটাগরি নাম ইং)</label>
                                        <div class="controls">
                                            <input type="text" name="catName_en" 
                                                value="<?php echo htmlentities($category['catName_en']); ?>" 
                                                class="span8 tip" required>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">Current Category Image (বর্তমান ক্যাটাগরি ছবি)</label>
                                        <div class="controls">
                                            <img src="categoryimages/<?php echo htmlentities($bid); ?>/<?php echo htmlentities($category['catImage']); ?>" width="200" height="100"> 
                                        </div>
                                    </div>
									
									<div class="control-group">
										<label class="control-label">New Category Image (নতুন ক্যাটাগরি ছবি)</label>
										<div class="controls">
											<input type="file" name="catImage" class="span6 tip" id="catImage" onchange="previewImage(event)">
											<br><br>
											<img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;" />
										</div>
									</div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" name="submit" class="btn btn-success">Update (হালনাগাদ করুন)</button>
                                        </div>
                                    </div>
                                </form>

                            </div> <!-- module-body -->
                        </div> <!-- module -->
                    </div> <!-- content -->
                </div> <!-- span9 -->
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- wrapper -->

    <?php include('include/footer.php'); ?>
    <?php include('include/js.php'); ?>
</body>
</html>
