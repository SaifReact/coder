<?php
session_start();
include('include/config.php');

if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $category = trim($_POST['category']);
    $subcat = trim($_POST['subcategory']);

    if (!empty($category) && !empty($subcat)) {
        $stmt = $con->prepare("INSERT INTO subcategory (categoryid, subcategory) VALUES (?, ?)");
        $stmt->bind_param("is", $category, $subcat);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "SubCategory Created Successfully!";
        } else {
            $_SESSION['msg'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['msg'] = "Both fields are required!";
    }

    header('location: subcategory.php');
    exit;
}

// Handle delete request
if (isset($_GET['del']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $con->prepare("DELETE FROM subcategory WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['delmsg'] = "SubCategory Deleted Successfully!";
    } else {
        $_SESSION['delmsg'] = "Error: " . $stmt->error;
    }

    $stmt->close();

    header('location: subcategory.php');
    exit;
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
                                <h3>Sub Category ( সাব ক্যাটাগরি সংযুক্তকরণ )</h3>
                            </div>
                            <div class="module-body">
                                <?php if (!empty($_SESSION['msg'])) { 
									$messageType = is_array($_SESSION['msg']) ? $_SESSION['msg'][0] : "success";
									$messageText = is_array($_SESSION['msg']) ? $_SESSION['msg'][1] : $_SESSION['msg'];
								?>
									<div class="alert alert-<?php echo htmlentities($messageType); ?>">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong><?php echo ucfirst($messageType); ?>:</strong> <?php echo htmlentities($messageText); ?>
									</div>
									<?php unset($_SESSION['msg']); ?>
								<?php } ?>

								<?php if (!empty($_SESSION['delmsg'])) { 
									$delMessageType = is_array($_SESSION['delmsg']) ? $_SESSION['delmsg'][0] : "danger";
									$delMessageText = is_array($_SESSION['delmsg']) ? $_SESSION['delmsg'][1] : $_SESSION['delmsg'];
								?>
									<div class="alert alert-<?php echo htmlentities($delMessageType); ?>">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong><?php echo ucfirst($delMessageType); ?>:</strong> <?php echo htmlentities($delMessageText); ?>
									</div>
									<?php unset($_SESSION['delmsg']); ?>
								<?php } ?>

                                <br />
                                <form class="form-horizontal row-fluid" method="post">
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">Category Name ( ক্যাটাগরি নাম )</label>
                                        <div class="controls">
                                            <select name="category" class="span8 tip" required>
                                                <option value="">Select Category</option>
                                                <?php 
                                                $query = mysqli_query($con, "SELECT * FROM category");
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    echo "<option value='" . htmlentities($row['id']) . "'>" . htmlentities($row['catName']) . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput">SubCategory Name ( সাব ক্যাটাগরি নাম )</label>
                                        <div class="controls">
                                            <input type="text" placeholder="Enter SubCategory Name" name="subcategory" class="span8 tip" required>
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
                                <h3>Subcategory Lists ( সাব ক্যাটাগরি তালিকাসমূহ )</h3>
                            </div>
                            <div class="module-body table">
                                <table class="datatable-1 table table-bordered table-striped display" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category ( ক্যাটাগরি )</th>
                                            <th>Subcategory ( সাব ক্যাটাগরি )</th>
                                            <th>Creation Date ( সংরক্ষণ তারিখ )</th>
                                            <th>Action ( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $query = mysqli_query($con, "SELECT subcategory.id, category.catName, subcategory.subcategory, subcategory.creationDate, subcategory.updationDate FROM subcategory JOIN category ON category.id = subcategory.categoryid");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_assoc($query)) { ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt); ?></td>
                                                <td><?php echo htmlentities($row['catName']); ?></td>
                                                <td><?php echo htmlentities($row['subcategory']); ?></td>
                                                <td><?php echo htmlentities($row['creationDate']); ?></td>
                                                <td style="text-align: center;">
                                                    <a href="edit-subcategory.php?id=<?php echo $row['id']; ?>">
                                                        <i class="icon-edit" style="font-size: 20px; color: blue;"></i>
                                                    </a>
                                                    <a href="subcategory.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
                                                        <i class="icon-trash" style="font-size: 20px; color: red;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php $cnt++; } ?>
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
