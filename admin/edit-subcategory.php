<?php
session_start();
include('include/config.php');

// Redirect if not logged in
if (!isset($_SESSION['alogin']) || empty($_SESSION['alogin'])) {
    header('Location: index.php');
    exit();
}

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');

// Process update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $category = trim($_POST['category']);
    $subcat = trim($_POST['subcategory']);

    if (!empty($category) && !empty($subcat)) {
        $stmt = $con->prepare("UPDATE subcategory SET categoryid = ?, subcategory = ?, updationDate = ? WHERE id = ?");
        $stmt->bind_param("issi", $category, $subcat, $currentTime, $id);

        if ($stmt->execute()) {
            $_SESSION['msg'] = ["success", "Sub-Category Updated Successfully!"];
            $stmt->close();
            header('Location: subcategory.php'); // Redirect to subcategory.php
            exit(); // Ensure the script stops executing
        } else {
            $_SESSION['msg'] = ["danger", "Update Failed. Try Again!"];
        }
        $stmt->close();
    } else {
        $_SESSION['msg'] = ["warning", "Please fill all required fields!"];
    }
}

// Fetch existing subcategory details
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$categoryId = $categoryName = $subCategory = "";

if ($id > 0) {
    $query = $con->prepare("SELECT category.id, category.catName, subcategory.subcategory 
                            FROM subcategory 
                            JOIN category ON category.id = subcategory.categoryid 
                            WHERE subcategory.id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $categoryId = $row['id'] ?? "";
        $categoryName = $row['catName'] ?? "";
        $subCategory = $row['subcategory'] ?? "";
    }
    $query->close();
}

// Fetch all categories
$categories = $con->query("SELECT id, catName FROM category");
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
                                <h3>Update SubCategory (হালনাগাদ সাব ক্যাটাগরি)</h3>
                            </div>
                            <div class="module-body">
                                <?php if (!empty($_SESSION['msg'])) { ?>
                                    <div class="alert alert-<?php echo $_SESSION['msg'][0]; ?>">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong><?php echo htmlentities($_SESSION['msg'][1]); ?></strong>
                                    </div>
                                    <?php unset($_SESSION['msg']); ?>
                                <?php } ?>

                                <form class="form-horizontal row-fluid" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Category Name (ক্যাটাগরি নাম)</label>
                                        <div class="controls">
                                            <select name="category" class="span8 tip" required>
                                                <option value="<?php echo htmlentities($categoryId); ?>">
                                                    <?php echo htmlentities($categoryName); ?>
                                                </option>
                                                <?php while ($cat = $categories->fetch_assoc()) { ?>
                                                    <?php if ($cat['id'] != $categoryId) { ?>
                                                        <option value="<?php echo $cat['id']; ?>">
                                                            <?php echo htmlentities($cat['catName']); ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">SubCategory Name (সাব ক্যাটাগরি নাম)</label>
                                        <div class="controls">
                                            <input type="text" name="subcategory" value="<?php echo htmlentities($subCategory); ?>"
                                                   class="span8 tip" required placeholder="Enter SubCategory Name">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn btn-success">Update (হালনাগাদ করুন)</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--/.content-->
                </div><!--/.span9-->
            </div>
        </div><!--/.container-->
    </div><!--/.wrapper-->
    <?php include('include/footer.php'); ?>
    <?php include('include/js.php'); ?>
</body>
</html>
