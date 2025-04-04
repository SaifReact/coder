<?php
session_start();
include('../include/config.php');

// Check if user is logged in
if (empty($_SESSION['alogin'])) {
    header('Location: index.php'); // FIXED TYPO: 'Louserion' → 'Location'
    exit();
}

$cusupdeId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$cusupdeli = [
    'userName' => '', 
    'userName_bn' => '', 
	'password' => '',
    'compName' => '', 
    'address' => '', 
    'contactNo' => '', 
    'email' => '',
	'image' => '', 
    'status' => ''
];

// Function to fetch subcategory details
function getCusupdeli($con, $cusupdeId) {
    $stmt = $con->prepare("SELECT ci.*, us.name, us.name_bn, us.return
                           FROM cusupdeli ci 
                           JOIN users us ON us.return = ci.forwarding 
                           WHERE ci.id = ?");
    $stmt->bind_param("i", $cusupdeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc() ?: null;
}

// Fetch user data if ID exists
if ($cusupdeId > 0) {
    $cusupdeliData = getCusupdeli($con, $cusupdeId);
    if ($cusupdeliData) {
        $cusupdeli = $cusupdeliData;
    } else {
        $_SESSION['msg'] = "Data not found.";
        header('Location: cusupdeli.php');
        exit();
    }
}

function handleImageUpload($file, $forwarding) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!empty($file['name'])) {
        if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
            return [false, "Invalid image format. Only JPG, PNG, and WebP allowed."];
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            return [false, "File is too large. Max 2MB allowed."];
        }

        $prefix = ($forwarding === 'usr') ? 'usr_' :
              (($forwarding === 'cus') ? 'cus_' :
              (($forwarding === 'sup') ? 'sup_' : 'dem_'));
			  
        return [true, uniqid($prefix, true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION)];
    }
    return [true, null];
}

function getPrefixNo($con, $forwarding) {
    $prefix = ($forwarding === 'usr') ? 'usr_' :
              (($forwarding === 'cus') ? 'cus_' :
              (($forwarding === 'sup') ? 'sup_' : 'dem_'));

    // Fetch the latest forId specific to the forwarding type
    $stmt = $con->prepare("SELECT forId FROM cusupdeli WHERE forwarding = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $forwarding);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // Extract last number while ensuring prefix is consistent
    if ($row = $result->fetch_assoc()) {
        $lastNumber = intval(str_replace($prefix, '', $row['forId']));
    } else {
        $lastNumber = 11110; // Default starting value
    }

    return $prefix . ($lastNumber + 1);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
    $userName = trim($_POST['userName'] ?? '');
    $userName_bn = trim($_POST['userName_bn'] ?? '');
    $forwarding = trim($_POST['forwarding'] ?? '');
    
    // Default empty password and passcode values
    $password = '';
    $passcode = '';

    // If forwarding is 'user', process password and passcode
    if ($forwarding === 'usr') {
        $password = md5(trim($_POST['password'] ?? ''));
        $passcode = trim($_POST['password'] ?? '');
    }

    $compName = trim($_POST['compName'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $contactNo = trim($_POST['contactNo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $status = trim($_POST['status'] ?? 'A');

    // Validate required fields
    if (empty($userName) || empty($userName_bn) || empty($forwarding)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: customer.php');
        exit();
    }

    // Handle image upload
    list($valid, $newImageName) = handleImageUpload($_FILES['image'], $forwarding);
	
    if (!$valid) {
        $_SESSION['msg'] = $newImageName;
        header('Location: cusupdeli.php');
        exit();
    }
	
	$newImageName = $newImageName ?: $cusupdeli['image'];
	
    if ($cusupdeId > 0) {
        // Prepare SQL update statement
        $sql = "UPDATE cusupdeli SET 
            userName = ?, 
            userName_bn = ?, 
            compName = ?, 
            address = ?, 
            contactNo = ?, 
            email = ?, 
            image = ?, 
            status = ?, 
            forwarding = ?";

		if ($forwarding === 'usr') {
			$sql .= ", password = ?, passCode = ?";
		}

		$sql .= " WHERE id = ?";

		// Prepare statement
		$stmt = $con->prepare($sql);
		if (!$stmt) {
			die("Prepare failed: " . $con->error);
		}

		// Bind parameters
		if ($forwarding === 'usr') {
			$stmt->bind_param("sssssssssssi", $userName, $userName_bn, $compName, $address, $contactNo, $email, $newImageName, $status, $forwarding, $password, $passcode, $cusupdeId);
		} else {
			$stmt->bind_param("sssssssssi", $userName, $userName_bn, $compName, $address, $contactNo, $email, $newImageName, $status, $forwarding, $cusupdeId);
		}

		// Execute
		$stmt->execute();

		// Check for MySQL errors
		if ($stmt->error) {
			die("MySQL Error: " . $stmt->error);
		}

		// Check affected rows
		if ($stmt->affected_rows === 0) {
			$_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
		}

		$stmt->close();

		// Handle image upload
		if (!empty($_FILES['image']['name'])) {
			$dir = "../cusupdeli/$cusupdeId";
			if (!is_dir($dir)) mkdir($dir, 0777, true);
			move_uploaded_file($_FILES['image']['tmp_name'], "$dir/$newImageName");
		}

		$_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";

    } else {
        // Get prefix number for insertion
        $prefixNo = getPrefixNo($con, $forwarding);

        // Prepare SQL insert statement
        $sql = "INSERT INTO cusupdeli (forId, userName, userName_bn, compName, address, contactNo, email, image, status, forwarding";
        
        if ($forwarding === 'usr') {
            $sql .= ", password, passCode";
        }

        $sql .= ") VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?";

        if ($forwarding === 'usr') {
            $sql .= ", ?, ?";
        }

        $sql .= ")";

        // Prepare and execute statement
        $stmt = $con->prepare($sql);
        if ($forwarding === 'usr') {
            $stmt->bind_param("ssssssssssss", $prefixNo, $userName, $userName_bn, $compName, $address, $contactNo, $email, $newImageName, $status, $forwarding, $password, $passcode);
        } else {
            $stmt->bind_param("ssssssssss", $prefixNo, $userName, $userName_bn, $compName, $address, $contactNo, $email, $newImageName, $status, $forwarding);
        }

        if ($stmt->execute()) {
            $cusupdeId = $stmt->insert_id;
            if (!empty($_FILES['image']['name'])) {
                $dir = "../cusupdeli/$cusupdeId";
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                move_uploaded_file($_FILES['image']['tmp_name'], "$dir/$newImageName");
            }
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Operation failed.";
        }
        $stmt->close();
    }

header('Location: cusupdeli.php');
exit();
}



// Handle user deletion
if (isset($_GET['del']) && $cusupdeId > 0) {
    $cusupdeli = getCusupdeli($con, $cusupdeId);
    if ($cusupdeli) {
        $stmt = $con->prepare("DELETE FROM cusupdeli WHERE id = ?");
        $stmt->bind_param("i", $cusupdeId);
        
        if ($stmt->execute()) {
            $cusupdeliDir = "../cusupdeli/$cusupdeId";
            if (is_dir($cusDir)) {
                array_map('unlink', glob("$cusupdeliDir/*"));
                rmdir($cusDir);
            }
            $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete Cusupdeli.";
        }
        $stmt->close();
    } else {
        $_SESSION['delmsg'] = "Cusupdeli not found. Cannot delete.";
    }
    header('Location: cusupdeli.php'); // FIXED TYPO
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
                                    <li class="list-inline-item">Cusupdeli ( কসপডেলি ) </li>
                                 </ul>
                              </div>
							  <button id="submitCusupdeli" class="au-btn au-btn-icon au-btn--green"><?php echo $cusupdeId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
                              <div class="card-header"><?php echo $cusupdeId ? 'Update' : 'Add'; ?> Cusupdeli ( কসপডেলি <?php echo $cusupdeId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                               <form id="cusupdeliForm" method="post" enctype="multipart/form-data" novalidate>
									<div class="row">
										<!-- Cusupdeli Category -->
										<div class="col-12">
											<div class="form-group">
												<label for="forwarding" class="form-control-label">
													Cusupdeli Category ( কসপডেলি ক্যাটাগরি )
												</label>
												<select name="forwarding" id="forwarding" class="form-control" onchange="toggleFields(this.value)">
													<?php if (!empty($cusupdeli['return'])) { ?>
														<option value="<?php echo htmlentities($cusupdeli['return']); ?>"> 
															<?php echo htmlentities($cusupdeli['name']).' - '.htmlentities($cusupdeli['name_bn']); ?>
														</option>
													<?php } else { ?>
														<option value="0"> Please Select - নির্বাচন করুন</option>
													<?php } ?>

													<?php 
													$query = mysqli_query($con, "SELECT * FROM users");
													while ($row = mysqli_fetch_assoc($query)) {
														echo "<option value='" . htmlentities($row['return']) . "'>" 
															 . htmlentities($row['name']) . " - " 
															 . htmlentities($row['name_bn']) . "</option>";
													}
													?>
												</select>
											</div>
										</div>

										<!-- Name Fields -->
										<div class="col-6">
											<div class="form-group">
												<label for="userName">Name ( নাম )</label>
												<input id="userName" name="userName" type="text" class="form-control" 
													placeholder="Enter Cusupdeli User Name" value="<?php echo htmlentities($cusupdeli['userName']); ?>" required>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="userName_bn">Name Bangla ( নাম বাংলা )</label>
												<input id="userName_bn" name="userName_bn" type="text" class="form-control"
													placeholder="Enter Cusupdeli User Name Bangla" value="<?php echo htmlentities($cusupdeli['userName_bn']); ?>" required>
											</div>
										</div>

										<!-- Extra Fields (Shown when 'User' is selected) -->
										<div class="col-12" id="extraFields" style="display: none;">
											<div class="row">
												<div class="col-6">
													<div class="form-group">
														<label for="password">Password</label>
														<div class="password-input-container">
															<input type="password" id="password" name="password" class="form-control"
																placeholder="Enter Password" value="<?php echo htmlentities($cusupdeli['passCode']); ?>" required>
															<i class="fa fa-eye toggle-password"></i>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group">
														<label for="cPassword">Confirm Password ( কনফার্ম পাসওয়ার্ড )</label>
														<div class="password-input-container">
														<input id="cPassword" name="cPassword" type="password" class="form-control"
															placeholder="Enter Confirm Password" value="<?php echo htmlentities($cusupdeli['passCode']); ?>" required>
															<i class="fa fa-eye toggle-password"></i>
													</div>
												</div>
											</div>
										</div>
										</div>

										<!-- Company Name -->
										<div class="col-6">
											<div class="form-group">
												<label for="compName">Company/Store/Others Name ( কোম্পানি/দোকান/অন্যান্য নাম )</label>
												<input id="compName" name="compName" type="text" class="form-control"
													placeholder="Enter Company Name" value="<?php echo htmlentities($cusupdeli['compName']); ?>" required>
											</div>
										</div>

										<!-- Address -->
										<div class="col-6">
											<div class="form-group">
												<label for="address">Address ( ঠিকানা )</label>
												<textarea id="address" name="address" rows="2" class="form-control"
													placeholder="Enter Address"><?php echo htmlentities($cusupdeli['address']); ?></textarea>
											</div>
										</div>

										<!-- Contact Number -->
										<div class="col-6">
											<div class="form-group">
												<label for="contactNo">Contact No ( কন্টাক্ট নং )</label>
												<input id="contactNo" name="contactNo" type="text" class="form-control"
													placeholder="Enter Contact No" value="<?php echo htmlentities($cusupdeli['contactNo']); ?>"
													maxlength="11" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11)" required>
											</div>
										</div>

										<!-- Email -->
										<div class="col-6">
											<div class="form-group">
												<label for="email">Email ( ইমেইল )</label>
												<input id="email" name="email" type="email" class="form-control"
													placeholder="Enter Email" value="<?php echo htmlentities($cusupdeli['email']); ?>" required>
											</div>
										</div>

										<!-- Existing Image Preview -->
										<?php if ($cusupdeId && $cusupdeli['image']) { ?>
											<div class="col-6">
												<div class="form-group">
													<label for="image">Current Image (বর্তমান ছবি)</label>
													<div class="controls">
														<img src="../cusupdeli/<?php echo htmlentities($cusupdeId); ?>/<?php echo htmlentities($cusupdeli['image']); ?>"
															width="100" height="100">
													</div>
												</div>
											</div>
										<?php } ?>
										
										<?php if ($cusupdeId) { ?>
										<div class="col-6">
											<div class="form-group">
												<label for="status">Status ( অবস্থা )</label>
												<select name="status" id="status" class="form-control">
													<option value="A" <?php echo ($cusupdeli['status'] == 'A') ? 'selected' : ''; ?>>Active (সক্রিয়)</option>
													<option value="I" <?php echo ($cusupdeli['status'] == 'I') ? 'selected' : ''; ?>>Inactive (নিষ্ক্রিয়)</option>
												</select>
											</div>
										</div>
										<?php } ?>

										<!-- Upload Image -->
										<div class="col-6">
											<div class="form-group">
												<label for="image">Image ( ছবি )</label>
												<input type="file" name="image" class="form-control-file" id="image" onchange="previewImage(event)">
												<img id="imagePreview" src="#" alt="Image Preview" style="max-width: 100px; max-height: 100px; display: none;">
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
											<th>ID<br>( আইডি )</th>
                                            <th>Name<br>( নাম )</th>
											<th>Company Name<br>( কোম্পানি নাম )</th>
											<th>Contact No <br>( কন্টাক্ট নং )</th>
											<th>Email <br>( ইমেইল )</th>
											<th>Picture <br>( ছবি )</th>
											<th>Status <br>( অবস্থা )</th>
											<th>Who <br>( কে? )</th>
                                            <th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT ci.*, us.name, us.name_bn, us.return
															   FROM cusupdeli ci 
															   JOIN users us ON us.return = ci.forwarding ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['forId']); ?></td>
									   <td><?php echo htmlentities($row['userName']).' - '.htmlentities($row['userName_bn']); ?></td>
									   <td><?php echo htmlentities($row['compName']).' - '.htmlentities($row['address']); ?></td>
									   <td><?php echo '+88 '.htmlentities($row['contactNo']); ?></td>
									   <td><?php echo htmlentities($row['email']); ?></td>
									   <td><img src="../cusupdeli/<?php echo $row['id']; ?>/<?php echo htmlentities($row['image']); ?>" width="100" height="100"></td>
									   <td><?php echo htmlentities($row['status'] == 'A') ? 'Active (সক্রিয়)' : 'Inactive (নিষ্ক্রিয়)'; ?></td>
									   <td><?php echo htmlentities($row['name']).' - '.htmlentities($row['name_bn']); ?></td>
									   <td><?php echo htmlentities($row['regDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="cusupdeli.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="cusupdeli.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
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
			function toggleFields(value) {
				console.log('Selected Value:', value);
				const extraFields = document.getElementById('extraFields');
				if (value === 'usr') {
					extraFields.style.display = 'block';
				} else {
					extraFields.style.display = 'none';
					// Clear the input fields when hiding
					document.getElementById('password').value = '';
					document.getElementById('cPassword').value = '';
					document.getElementById('userName_bn').value = '';
				}
			}

			// Run toggleFields on page load (for edit mode)
			document.addEventListener("DOMContentLoaded", function () {
				const selectedValue = document.getElementById('forwarding').value;
				toggleFields(selectedValue);  // Call function to check existing value
			});

			// Toggle password visibility
			document.addEventListener("DOMContentLoaded", function() {
				document.querySelectorAll(".toggle-password").forEach(icon => {
					icon.addEventListener("click", function() {
						let input = this.previousElementSibling;
						input.type = input.type === "password" ? "text" : "password";
						this.classList.toggle("fa-eye");
						this.classList.toggle("fa-eye-slash");
					});
				});
			});
		</script>
		
	    <script>
			document.getElementById("submitCusupdeli").addEventListener("click", function () {
			document.getElementById("cusupdeliForm").submit();
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
