<?php
session_start();
include('../include/config.php');

// Check if user is logged in
if (empty($_SESSION['alogin'])) {
    header('Location: index.php'); // FIXED TYPO: 'Louserion' → 'Location'
    exit();
}

$usersId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$users = [
    'userName' => '', 
    'userName_bn' => '', 
    'userEmail' => '', 
    'contactNo' => '', 
    'password' => '', 
    'billingAddress' => '', 
    'userImg' => '', 
    'status' => ''
];

// Function to fetch user data
function getUsers($con, $usersId) {
    $stmt = $con->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $usersId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc() ?: null;
}

// Function to handle image upload
function handleImageUpload($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    
    if (!empty($file['name'])) {
        $imageType = mime_content_type($file['tmp_name']);
        if (!in_array($imageType, $allowedTypes)) {
            return [false, "Invalid image format. Only JPG, PNG, and WebP allowed."];
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            return [false, "File is too large. Max 2MB allowed."];
        }
        $imageExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        return [true, uniqid("user_", true) . '.' . $imageExtension];
    }
    return [true, null];
}

// Fetch user data if ID exists
if ($usersId > 0) {
    $usersData = getUsers($con, $usersId);
    if ($usersData) {
        $users = $usersData;
    } else {
        $_SESSION['msg'] = "Users Not Found.";
        header('Location: users.php');
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$userName = trim($_POST['userName'] ?? '');
    $userName_bn = trim($_POST['userName_bn'] ?? '');
    $userEmail = trim($_POST['userEmail'] ?? '');
    $contactNo = trim($_POST['contactNo'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $billingAddress = trim($_POST['billingAddress'] ?? '');
    $status = trim($_POST['status'] ?? 'A');

        // Prevent processing if required fields are missing
    if (empty($userName) || empty($userName_bn)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: users.php');
        exit();
    }

    // Handle image upload
    list($valid, $newImageName) = handleImageUpload($_FILES['userImg']);
    if (!$valid) {
        $_SESSION['msg'] = $newImageName;
        header('Location: users.php'); // FIXED TYPO
        exit();
    }
    
    $newImageName = $newImageName ?: $user['userImg'];

    if ($usersId > 0) {
        // Check if password needs to be updated
        $passwordQuery = ($password !== $user['password']) ? "password = ?, " : "";
        $passwordParam = ($password !== $user['password']) ? password_hash($password, PASSWORD_BCRYPT) : $user['password'];

        // Update user details
        $stmt = $con->prepare("UPDATE users SET userName = ?, userName_bn = ?, userEmail = ?, contactNo = ?, $passwordQuery billingAddress = ?, userImg = ?, status = ? WHERE id = ?");
        if ($passwordQuery) {
            $stmt->bind_param("sssssssi", $userName, $userName_bn, $userEmail, $contactNo, $passwordParam, $billingAddress, $newImageName, $status, $usersId);
        } else {
            $stmt->bind_param("sssssssi", $userName, $userName_bn, $userEmail, $contactNo, $billingAddress, $newImageName, $status, $userId);
        }
        
        $stmt->execute();
        $stmt->close();

        // Move uploaded image
        if ($_FILES['userImg']['name']) {
            $dir = "../users/$usersId";
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            move_uploaded_file($_FILES['userImg']['tmp_name'], "$dir/$newImageName");
        }

        $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
    } else {
        // Insert new user
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $con->prepare("INSERT INTO users (userName, userName_bn, userEmail, contactNo, password, billingAddress, userImg, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $userName, $userName_bn, $userEmail, $contactNo, $hashedPassword, $billingAddress, $newImageName, $status);
        
        if ($stmt->execute()) {
            $userId = $stmt->insert_id;

            // Move uploaded image
            if ($_FILES['userImg']['name']) {
                $dir = "../users/$usersId";
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                move_uploaded_file($_FILES['userImg']['tmp_name'], "$dir/$newImageName");
            }
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Operation failed.";
        }
        $stmt->close();
    }

    header('Location: users.php'); // FIXED TYPO
    exit();
}

// Handle user deletion
if (isset($_GET['del']) && $usersId > 0) {
    $users = getUsers($con, $usersId);
    if ($users) {
        $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $usersId);
        
        if ($stmt->execute()) {
            $userDir = "../users/$userId";
            if (is_dir($userDir)) {
                array_map('unlink', glob("$userDir/*"));
                rmdir($userDir);
            }
            $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete user.";
        }
        $stmt->close();
    } else {
        $_SESSION['delmsg'] = "User not found. Cannot delete.";
    }
    
    header('Location: users.php'); // FIXED TYPO
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
   <?php include('share/head.php');?>
   <body class="animsition">
      <div class="page-wrapper">
         <!-- MENU SIDEBAR-->
         <?php include('share/menu.php');?>
         <!-- END MENU SIDEBAR-->
         <!-- PAGE CONTAINER-->
         <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <?php include('share/header.php');?>
            <?php include('share/side-menu.php');?>
            <!-- END HEADER DESKTOP-->
            <!-- BREADCRUMB-->
            <section class="au-breadcrumb m-t-75">
               <div class="section__content section__content--p30">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="au-breadcrumb-content">
                              <div class="au-breadcrumb-left">
                                 <ul class="list-unstyled list-inline au-breadcrumb__list">
                                    <li class="list-inline-item active">
                                       <a href="#">Dashboard</a>
                                    </li>
                                    <li class="list-inline-item seprate">
                                       <span>/</span>
                                    </li>
                                    <li class="list-inline-item">Users (ব্যবহারকারী) </li>
                                 </ul>
                              </div>
							  <button id="submitUser" class="au-btn au-btn-icon au-btn--green"><?php echo $usersId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- END BREADCRUMB-->
            <div class="main-content">
               <div class="section__content section__content--p30">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card">
								
                              <div class="card-header"><?php echo $usersId ? 'Update' : 'Add'; ?> users ( ব্যবহারকারী <?php echo $usersId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="userForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                    <div class="col-6">
										<div class="form-group">
                                        <label for="userName" class="control-label mb-1">User Name ( ব্যবহারকারী নাম )</label>
                                        <input id="userName" name="userName" type="text" class="form-control userName valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="userName"
                                            placeholder="Enter User Name" value="<?php echo htmlentities($users['userName']); ?>" required>
										</div>
                                    </div>
                                    <div class="col-6">
										<div class="form-group">
                                        <label for="userName" class="control-label mb-1">User Name Bangla ( ব্যবহারকারী নাম বাংলা)</label>
                                        <input id="userName_bn" name="userName_bn" type="text" class="form-control userName_bn valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="userName_bn" 
                                            placeholder="Enter User Name Bangla" value="<?php echo htmlentities($users['userName_bn']); ?>" required>
										</div>	
                                    </div>
									<div class="col-6">
										<div class="form-group">
                                        <label for="userEmail" class="control-label mb-1">User Email ( ব্যবহারকারী ইমেইল )</label>
                                        <input id="userEmail" name="userEmail" type="text" class="form-control userEmail valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="userEmail"
                                            placeholder="Enter User Email" value="<?php echo htmlentities($users['userEmail']); ?>" required>
										</div>
                                       </div>
                                    <div class="col-6">
										<div class="form-group">
                                        <label for="contactNo" class="control-label mb-1">Contact No ( কন্টাক্ট নং )</label>
                                        <input id="contactNo" name="contactNo" type="text" class="form-control contactNo valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="contactNo" 
                                            placeholder="Enter User Contact No" value="<?php echo htmlentities($users['contactNo']); ?>" required>
										</div>
                                    </div>
                                    
									<div class="col-6">
										<div class="form-group">
                                        <label for="password" class="control-label mb-1">Password ( পাসওয়ার্ড )</label>
                                        <input id="password" name="password" type="password" class="form-control password valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="password"
                                            placeholder="Enter User Password" value="<?php echo htmlentities($users['password']); ?>" required>
										</div>
                                    </div>
                                    <div class="col-6">
										<div class="form-group">
                                          <label for="cPassword" class="control-label mb-1">Confirm Password ( কনফার্ম পাসওয়ার্ড )</label>
                                          <input id="cPassword" name="cPassword" type="password" class="form-control cPassword valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="cPassword" 
                                            placeholder="Enter User Confirm Password" value="<?php echo htmlentities($users['password']); ?>" required>
										</div>
                                    </div>
									<div class="col-6">
										<div class="form-group">
                                          <label for="billingAddress" class="control-label mb-1">Address ( ঠিকানা )</label>
                                             <textarea name="billingAddress" id="billingAddress" rows="3" placeholder="Content..." class="form-control"><?php echo htmlentities($users['billingAddress']); ?></textarea>
										</div>	 
                                    </div>

									 <?php if ($usersId && $users['userImg']) { ?>
									<div class="col-6">
										<div class="form-group">
										<label for="userImg" class="control-label mb-1">Current User Image (বর্তমান ব্যবহারকারী ছবি)</label>
										<div class="controls"><img src="../users/<?php echo htmlentities($userId); ?>/<?php echo htmlentities($users['userImg']); ?>" width="100" height="100"></div>
										</div>
									</div>
										
									<div class="col-6">
										<div class="form-group">
									    <label for="status">Status ( অবস্থা )</label>
										<select name="status" id="status" class="form-control">
											<option value="A" <?php echo ($users['status'] == 'A') ? 'Active' : ''; ?>>Active (সক্রিয়)</option>
											<option value="I" <?php echo ($users['status'] == 'I') ? 'Inactive' : ''; ?>>Inactive (নিষ্ক্রিয়)</option>
										</select>
										</div>
									</div>
									<?php } ?>
                                       <div class="col-6">
										<div class="form-group">
                                          <label for="userImage" class="control-label mb-1">User Image ( ব্যবহারকারী ছবি )</label>
                                          <input type="file" name="userImg" class="form-control-file" id="userImg" required onchange="previewImage(event)">
                                          <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 100px; max-height: 100px; display: none;" />
										  </div>
                                       </div>
									</div>
                                 </form>
                              </div>
							  
                           </div>
                        </div>
                     </div>
                     <div class="row m-t-30">
                        <div class="col-md-12">
                           <!-- DATA TABLE-->
                           <div class="table-responsive m-b-40">
                              <table class="table table-borderless table-data3">
                                 <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User Name<br>( ব্যবহারকারী নাম )</th>
											<th>Email <br>( ইমেইল )</th>
                                            <th>Contact No <br>( কন্টাক্ট নং )</th>
											<th>Picture <br>( ছবি )</th>
											<th>Status <br>( অবস্থা )</th>
                                            <th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT * FROM users ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['userName_bn']).' - '.htmlentities($row['userName']); ?></td>
									   <td><?php echo htmlentities($row['userEmail']); ?></td>
									   <td><?php echo htmlentities($row['contactNo']); ?></td>
                                       <td><img src="../users/<?php echo $row['id']; ?>/<?php echo htmlentities($row['userImg']); ?>" width="100" height="100"></td>
									   <td><?php echo htmlentities($row['status'] == 'A') ? 'Active (সক্রিয়)' : 'Inactive (নিষ্ক্রিয়)'; ?></td>
									   <td><?php echo htmlentities($row['regDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="users.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="users.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
													<i class="zmdi zmdi-delete" style="color:#FF0000"></i>
												</a>
											</button>
                                        </div>
                                       </td>
                                    </tr>
                                   <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                           <!-- END DATA TABLE-->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- STATISTIC-->
            <?php include('share/footer.php');?>
            <!-- END PAGE CONTAINER-->
         </div>
      </div>
      <?php include('share/js.php');?>
	  <script>
		document.getElementById("submitUser").addEventListener("click", function () {
        document.getElementById("userForm").submit();
		});
	</script>
	<script>
		$(document).ready(function () {
			<?php if (!empty($_SESSION['msg'])) { ?>
				toastr.success("<?php echo addslashes($_SESSION['msg']); ?>");
				<?php unset($_SESSION['msg']); ?>
			<?php } ?>
			<?php if (!empty($_SESSION['warnmsg'])) { ?>
				toastr.warning("<?php echo addslashes($_SESSION['warnmsg']); ?>");
				<?php unset($_SESSION['warnmsg']); ?>
			<?php } ?>
			<?php if (!empty($_SESSION['delmsg'])) { ?>
				toastr.error("<?php echo addslashes($_SESSION['delmsg']); ?>");
				<?php unset($_SESSION['delmsg']); ?>
			<?php } ?>
		});
	</script>

   </body>
