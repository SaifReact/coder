<?php
session_start();
include('include/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

// Insert Category
if (isset($_POST['submit'])) {
    $catName = trim($_POST['catName']);
	$catName_en = trim($_POST['catName_en']);
    $catImage = $_FILES["catImage"]["name"];
    $tempImage = $_FILES["catImage"]["tmp_name"];
    $uploadError = $_FILES["catImage"]["error"];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    // Validate file upload
    if ($uploadError === UPLOAD_ERR_OK && in_array(mime_content_type($tempImage), $allowedTypes)) {
        $stmt = $con->prepare("INSERT INTO category (catName, catName_en, catImage) VALUES (?, ?, ?)");
        if ($stmt) {
            // Generate unique image name
            $imageExtension = pathinfo($catImage, PATHINFO_EXTENSION);
            $newImageName = uniqid("category_", true) . '.' . $imageExtension;

            // Insert into database
            $stmt->bind_param("sss", $catName, $catName_en, $newImageName);
            if ($stmt->execute()) {
                $catid = $stmt->insert_id;
                $dir = "categoryimages/$catid";
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $imagePath = "$dir/$newImageName";

                // Move file to directory
                if (move_uploaded_file($tempImage, $imagePath)) {
                    $_SESSION['msg'] = "Category Added Successfully!";
                } else {
                    $_SESSION['msg'] = "File upload failed.";
                }
            } else {
                $_SESSION['msg'] = "Database error: Failed to insert category.";
            }
            $stmt->close();
        }
    } else {
        $_SESSION['msg'] = "Invalid file type or upload error.";
    }
}

// Delete Category
if (isset($_GET['del']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $catId = intval($_GET['id']);

    // Fetch image path before deletion
    $stmt = $con->prepare("SELECT catImage FROM category WHERE id = ?");
    $stmt->bind_param("i", $catId);
    $stmt->execute();
    $stmt->bind_result($catImage);
    if ($stmt->fetch()) {
        $stmt->close();

        // Delete record
        $stmt = $con->prepare("DELETE FROM category WHERE id = ?");
        $stmt->bind_param("i", $catId);
        if ($stmt->execute()) {
            // Delete image folder
            $catDir = "categoryimages/$catId";
            array_map('unlink', glob("$catDir/*"));
            rmdir($catDir);
            $_SESSION['delmsg'] = "Category Deleted Successfully!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete category.";
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
                                <h3>Add Category ( ক্যাটাগরি সংযুক্তকরণ )</h3>
                            </div>
                            <div class="module-body">
                                <?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Well done!</strong> <?php echo htmlentities($_SESSION['msg']); ?>
                                        <?php $_SESSION['msg'] = ""; ?>
                                    </div>
                                <?php } ?>

                                <?php if (isset($_SESSION['delmsg']) && !empty($_SESSION['delmsg'])) { ?>
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Oh snap!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?>
                                        <?php $_SESSION['delmsg'] = ""; ?>
                                    </div>
                                <?php } ?>
                                <br />

                                <form class="form-horizontal row-fluid" name="insertproduct" method="post" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">Category Name ( ক্যাটাগরি নাম )</label>
                                        <div class="controls">
                                            <input type="text" name="catName" placeholder="Enter Category Name" class="span8 tip" required>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="basicinput">Category Name Eng ( ক্যাটাগরি নাম ইং )</label>
                                        <div class="controls">
                                            <input type="text" name="catName_en" placeholder="Enter Category Name Enlish" class="span8 tip" required>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Category Image ( ক্যাটাগরি ছবি )</label>
                                        <div class="controls">
                                            <input type="file" name="catImage" class="span6 tip" id="catImage" required onchange="previewImage(event)">
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
                                <h3>Category Lists ( ক্যাটাগরি তালিকাসমূহ )</h3>
                            </div>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category ( ক্যাটাগরি )</th>
											<th>Category Eng ( ক্যাটাগরি ইং)</th>
                                            <th>Image ( ছবি )</th>
                                            <th>Creation Date ( সংরক্ষণ তারিখ )</th>
                                            <th>Action ( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $query = mysqli_query($con, "SELECT * FROM category");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) { ?>									
                                            <tr>
                                                <td><?php echo htmlentities($cnt); ?></td>
                                                <td><?php echo htmlentities($row['catName']); ?></td>
												<td><?php echo htmlentities($row['catName_en']); ?></td>
                                                <td><img src="categoryimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['catImage']); ?>" width="100" height="100"></td>
                                                <td><?php echo htmlentities($row['creationDate']); ?></td>
                                                <td style="text-align: center;">
                                                    <a href="edit-category.php?id=<?php echo $row['id']; ?>"><i class="icon-edit" style="font-size: 20px; color: blue;"></i></a>
                                                    <a href="category.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-trash" style="font-size: 20px; color: red;"></i></a>
                                                </td>
                                            </tr>
                                        <?php 
                                            $cnt++; 
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--/.content-->
                </div>
                <!--/.span9-->
            </div>
        </div>
        <!--/.container-->
    </div>
    <!--/.wrapper-->
    <?php include('include/footer.php'); ?>
    <?php include('include/js.php'); ?>
</body>
</html>
