<?php
session_start();
include('include/config.php');

// Redirect if user is not logged in
if (empty($_SESSION['alogin'])) {    
    header('location:index.php');
    exit();
}

$sid = intval($_GET['id']); // Ensure $sid is an integer

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize input to prevent SQL injection
    $compName = mysqli_real_escape_string($con, $_POST['compName'] ?? '');
    $compDescription = mysqli_real_escape_string($con, $_POST['compDescription'] ?? '');
    $address = mysqli_real_escape_string($con, $_POST['address'] ?? '');
    $phone1 = mysqli_real_escape_string($con, $_POST['phone1'] ?? '');
    $phone2 = mysqli_real_escape_string($con, $_POST['phone2'] ?? '');
    $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
    $currency = mysqli_real_escape_string($con, $_POST['currency'] ?? '');
    $facebook = mysqli_real_escape_string($con, $_POST['facebook'] ?? '');
    $twitter = mysqli_real_escape_string($con, $_POST['twitter'] ?? '');
    $linkedin = mysqli_real_escape_string($con, $_POST['linkedin'] ?? '');

    // Update Query
    $sql = "UPDATE basic SET 
                compName='$compName', 
                compDescription='$compDescription', 
                address='$address', 
                phone1='$phone1', 
                phone2='$phone2', 
                email='$email', 
                currency='$currency', 
                facebook='$facebook', 
                twitter='$twitter', 
                linkedin='$linkedin' 
            WHERE id='$sid'";

    if (mysqli_query($con, $sql)) {
        $_SESSION['msg'] = "Basic Updated Successfully!";
    } else {
        $_SESSION['msg'] = "Error updating record: " . mysqli_error($con);
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
                                <h3>Edit Basic</h3>
                            </div>
                            <div class="module-body">

                                <!-- Success Message -->
                                <?php if (!empty($_SESSION['msg'])) { ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Well done!</strong> <?php echo htmlentities($_SESSION['msg']); ?>
                                    </div>
                                    <?php unset($_SESSION['msg']); // Clear message ?>
                                <?php } ?>

                                <!-- Fetch data from DB -->
                                <?php 
                                    $query = mysqli_query($con, 
                                        "SELECT basic.*, currency.curName as curname, currency.shortCurrency as curshort 
                                         FROM basic 
                                         JOIN currency ON currency.shortCurrency = basic.currency 
                                         WHERE basic.id='$sid'");
                                    $row = mysqli_fetch_assoc($query);
                                ?>

                                <form class="form-horizontal row-fluid" name="insertproduct" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Company Name</label>
                                        <div class="controls">
                                            <input type="text" name="compName" placeholder="Enter Company Name" 
                                                   value="<?php echo htmlentities($row['compName'] ?? ''); ?>" class="span8 tip">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Description</label>
                                        <div class="controls">
                                            <textarea name="compDescription" placeholder="Enter Description" rows="6" class="span8 tip"><?php echo htmlentities($row['compDescription'] ?? ''); ?></textarea>  
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Address</label>
                                        <div class="controls">
                                            <textarea name="address" placeholder="Enter Address" rows="6" class="span8 tip"><?php echo htmlentities($row['address'] ?? ''); ?></textarea>  
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Phone1</label>
                                        <div class="controls">
                                            <input type="text" name="phone1" placeholder="Enter Phone No." 
                                                   value="<?php echo htmlentities($row['phone1'] ?? ''); ?>" class="span8 tip">  
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Phone2</label>
                                        <div class="controls">
                                            <input type="text" name="phone2" placeholder="Enter Phone No." 
                                                   value="<?php echo htmlentities($row['phone2'] ?? ''); ?>" class="span8 tip">  
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Email</label>
                                        <div class="controls">
                                            <input type="email" name="email" placeholder="Enter Email" 
                                                   value="<?php echo htmlentities($row['email'] ?? ''); ?>" class="span8 tip">  
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Currency</label>
                                        <div class="controls">
                                            <select name="currency" id="currency" class="span8 tip">
                                                <option value="<?php echo htmlentities($row['curshort'] ?? ''); ?>">
                                                    <?php echo htmlentities($row['curname'] ?? ''); ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Logo</label>
                                        <div class="controls">
                                            <img src="logo/<?php echo htmlentities($sid); ?>/<?php echo htmlentities($row['logo'] ?? ''); ?>" width="200" height="100"> 
                                            <a href="update-basicimage.php?id=<?php echo $row['id'] ?? ''; ?>">Change Image</a>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Facebook Link</label>
                                        <div class="controls">
                                            <input type="text" name="facebook" placeholder="Enter Facebook Link" 
                                                   value="<?php echo htmlentities($row['facebook'] ?? ''); ?>" class="span8 tip">  
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Twitter Link</label>
                                        <div class="controls">
                                            <input type="text" name="twitter" placeholder="Enter Twitter Link" 
                                                   value="<?php echo htmlentities($row['twitter'] ?? ''); ?>" class="span8 tip">  
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Linkedin Link</label>
                                        <div class="controls">
                                            <input type="text" name="linkedin" placeholder="Enter Linkedin Link" 
                                                   value="<?php echo htmlentities($row['linkedin'] ?? ''); ?>" class="span8 tip">  
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" name="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>

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
