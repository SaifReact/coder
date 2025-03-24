<?php
session_start();
include('include/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

// Insert Brand
if (isset($_POST['submit'])) {
    $brandsName = trim($_POST['brandsName']);
	$brandsName_en = trim($_POST['brandsName_en']);
    $brandsImage = $_FILES["brandsImage"]["name"];
    $tempImage = $_FILES["brandsImage"]["tmp_name"];
    $uploadError = $_FILES["brandsImage"]["error"];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    // Validate file upload
    if ($uploadError === UPLOAD_ERR_OK && in_array(mime_content_type($tempImage), $allowedTypes)) {
        $stmt = $con->prepare("INSERT INTO brands (brandsName, brandsName_en, brandsImage) VALUES (?, ?, ?)");
        if ($stmt) {
            // Generate unique image name
            $imageExtension = pathinfo($brandsImage, PATHINFO_EXTENSION);
            $newImageName = uniqid("brand_", true) . '.' . $imageExtension;

            // Insert into database
            $stmt->bind_param("sss", $brandsName, $brandsName_en, $newImageName);
            if ($stmt->execute()) {
                $brandsid = $stmt->insert_id;
                $dir = "brandsimages/$brandsid";
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $imagePath = "$dir/$newImageName";

                // Move file to directory
                if (move_uploaded_file($tempImage, $imagePath)) {
                    $_SESSION['msg'] = "Brands Added Successfully!";
                } else {
                    $_SESSION['msg'] = "File upload failed.";
                }
            } else {
                $_SESSION['msg'] = "Database error: Failed to insert brand.";
            }
            $stmt->close();
        }
    } else {
        $_SESSION['msg'] = "Invalid file type or upload error.";
    }
}

// Delete Brand
if (isset($_GET['del']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $brandId = intval($_GET['id']);

    // Fetch image path before deletion
    $stmt = $con->prepare("SELECT brandsImage FROM brands WHERE id = ?");
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $stmt->bind_result($brandImage);
    if ($stmt->fetch()) {
        $stmt->close();

        // Delete record
        $stmt = $con->prepare("DELETE FROM brands WHERE id = ?");
        $stmt->bind_param("i", $brandId);
        if ($stmt->execute()) {
            // Delete image folder
            $brandDir = "brandsimages/$brandId";
            array_map('unlink', glob("$brandDir/*"));
            rmdir($brandDir);
            $_SESSION['delmsg'] = "Brands Deleted Successfully!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete brand.";
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
                                <h3>Add Brands ( ব্র্যান্ডস সংযুক্তকরণ )</h3>
                            </div>
                            <div class="module-body">
                                <?php if (!empty($_SESSION['msg'])) { ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Well done!</strong> <?php echo htmlentities($_SESSION['msg']); ?>
                                    </div>
                                    <?php $_SESSION['msg'] = ""; } ?>

                                <?php if (!empty($_SESSION['delmsg'])) { ?>
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Oh snap!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?>
                                    </div>
                                    <?php $_SESSION['delmsg'] = ""; } ?>

                                <br />

                                <form class="form-horizontal row-fluid" method="post" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label">Brands Name ( ব্র্যান্ডস নাম )</label>
                                        <div class="controls">
                                            <input type="text" name="brandsName" placeholder="Enter Brands Name" class="span6 tip" required>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label">Brands Name Eng ( ব্র্যান্ডস নাম ইং)</label>
                                        <div class="controls">
                                            <input type="text" name="brandsName_en" placeholder="Enter Brands Name English" class="span6 tip" required>
                                        </div>
                                    </div>
									
									<div class="control-group">
										<label class="control-label">Brands Image ( ব্র্যান্ডস ছবি )</label>
										<div class="controls">
											<input type="file" name="brandsImage" class="span6 tip" id="brandsImage" required onchange="previewImage(event)">
											<br><br>
											<img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;" />
										</div>
									</div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit ( সংরক্ষণ করুন )</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="module">
                            <div class="module-head">
                                <h3>Brands Lists ( ব্র্যান্ডস তালিকাসমূহ )</h3>
                            </div>
                            <div class="module-body table">
                                <table class="datatable-1 table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Brands ( ব্র্যান্ডস )</th>
											<th>Brands Eng ( ব্র্যান্ডস ইং )</th>
                                            <th>Image ( ছবি )</th>
                                            <th>Creation Date ( সংরক্ষণ তারিখ )</th>
                                            <th>Action ( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $query = $con->query("SELECT * FROM brands ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt++; ?></td>
                                            <td><?php echo htmlentities($row['brandsName']); ?></td>
											<td><?php echo htmlentities($row['brandsName_en']); ?></td>
                                            <td><img src="brandsimages/<?php echo $row['id']; ?>/<?php echo htmlentities($row['brandsImage']); ?>" width="100" height="100"></td>
                                            <td><?php echo htmlentities($row['postingDate']); ?></td>
                                            <td style="text-align: center;">
                                                <a href="edit-brands.php?id=<?php echo $row['id']; ?>" title="Edit"><i class="icon-edit" style="font-size: 20px; color: blue;"></i></a>
                                                <a href="brands.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure?')" title="Delete"><i class="icon-trash" style="font-size: 20px; color: red;"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('include/footer.php'); ?>
    <?php include('include/js.php'); ?>
</body>
</html>
