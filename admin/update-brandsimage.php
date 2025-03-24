<?php
session_start();
include('include/config.php');

// Redirect if not logged in
if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
    exit();
}

// Get brand ID from URL & validate
$bid = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$bid) {
    die("Invalid brand ID.");
}

// Fetch existing brand data
$stmt = $con->prepare("SELECT brandsName, brandsImage FROM brands WHERE id = ?");
$stmt->bind_param("i", $bid);
$stmt->execute();
$result = $stmt->get_result();
$brand = $result->fetch_assoc();
$stmt->close();

// If brand not found, show error
if (!$brand) {
    die("Brand not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $brandsName = trim($_POST['brandsName']);
    $brandsImage = $_FILES["brandsImage"]["name"];
    $tmpName = $_FILES["brandsImage"]["tmp_name"];
    $imageSize = $_FILES["brandsImage"]["size"];

    // Validate image file type & size (Max 2MB)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $imageType = mime_content_type($tmpName);

    if (!in_array($imageType, $allowedTypes)) {
        $_SESSION['msg'] = "Invalid image format. Only JPG, PNG, and WebP allowed.";
    } elseif ($imageSize > 2 * 1024 * 1024) {
        $_SESSION['msg'] = "File is too large. Max 2MB allowed.";
    } else {
        // Create directory if not exists
        $dir = "brandsimages/" . $bid;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Move uploaded file
        $filePath = "$dir/" . basename($brandsImage);
        move_uploaded_file($tmpName, $filePath);

        // Update database using prepared statements
        $stmt = $con->prepare("UPDATE brands SET brandsName = ?, brandsImage = ? WHERE id = ?");
        $stmt->bind_param("ssi", $brandsName, $brandsImage, $bid);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Brand Image Updated Successfully!";
        } else {
            $_SESSION['msg'] = "Error updating brand.";
        }
        $stmt->close();
    }
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
                                <h3>Update Brand Image (হালনাগাদ ব্র্যান্ডস ছবি)</h3>
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
                                        <label class="control-label" for="basicinput">Brand Name (ব্র্যান্ডস নাম)</label>
                                        <div class="controls">
                                            <input type="text" name="brandsName" 
                                                value="<?php echo htmlentities($brand['brandsName']); ?>" 
                                                class="span8 tip" required>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">Current Brand Image (বর্তমান ব্র্যান্ডস ছবি)</label>
                                        <div class="controls">
                                            <img src="brandsimages/<?php echo htmlentities($bid); ?>/<?php echo htmlentities($brand['brandsImage']); ?>" width="200" height="100"> 
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">New Brand Image (নতুন ব্র্যান্ডস ছবি)</label>
                                        <div class="controls">
                                            <input type="file" name="brandsImage" id="brandsImage" class="span8 tip" required>
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
