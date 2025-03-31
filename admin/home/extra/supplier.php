<?php
session_start();
include('../include/config.php');

// Check if user is logged in
if (empty($_SESSION['alogin'])) {
    header('Location: index.php'); // FIXED TYPO: 'Louserion' → 'Location'
    exit();
}

$suppId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$supp = [
    'name' => '', 
    'name_bn' => '', 
    'compName' => '', 
    'address' => '', 
    'contactNo' => '', 
    'email' => '',
	'suppImg' => '', 
    'status' => ''
];

// Function to fetch user data
function getSupp($con, $suppId) {
    $stmt = $con->prepare("SELECT * FROM supplier WHERE id = ?");
    $stmt->bind_param("i", $suppId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc() ?: null;
}

// Fetch user data if ID exists
if ($suppId > 0) {
    $suppData = getSupp($con, $suppId);
    if ($suppData) {
        $supp = $suppData;
    } else {
        $_SESSION['msg'] = "Supplier Not Found.";
        header('Location: supplier.php');
        exit();
    }
}

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
        return [true, uniqid("supp_", true) . '.' . $imageExtension];
    }
    return [true, null];
}

function getSupplierNo($con) {
    $prefix = "SU-";

    // Fetch the last supplier number from the database
    $stmt = $con->prepare("SELECT supId FROM supplier ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($row = $result->fetch_assoc()) {
        $lastNumber = $row['supId'];
        $numericPart = intval(str_replace($prefix, '', $lastNumber)); // Extract numeric part
    } else {
        $numericPart = 11110; // Default starting number
    }

    $newNumber = $numericPart + 1; // Increment the number
    return $prefix . $newNumber;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$name = trim($_POST['name'] ?? '');
    $name_bn = trim($_POST['name_bn'] ?? '');
    $compName = trim($_POST['compName'] ?? '');
	$address = trim($_POST['address'] ?? '');
    $contactNo = trim($_POST['contactNo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $status = trim($_POST['status'] ?? 'A');
	
	$contactNoPrepand = '+88' . $contactNo;

        // Prevent processing if required fields are missing
    if (empty($name) || empty($name_bn)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: supplier.php');
        exit();
    }
	
	// Handle image upload
    list($valid, $newImageName) = handleImageUpload($_FILES['suppImg']);
    if (!$valid) {
        $_SESSION['msg'] = $newImageName;
        header('Location: supplier.php'); // FIXED TYPO
        exit();
    }
    
    $newImageName = $newImageName ?: $supp['suppImg'];

    if ($suppId > 0) {

        // Update user details
        $stmt = $con->prepare("UPDATE supplier SET name = ?, name_bn = ?, compName = ?, address = ?, contactNo = ?, email = ?, suppImg = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $name, $name_bn, $compName, $address, $contactNo, $email, $newImageName, $status, $suppId);
        $stmt->execute();
        $stmt->close();
		
		// Move uploaded image
        if ($_FILES['suppImg']['name']) {
            $dir = "../supp/$suppId";
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            move_uploaded_file($_FILES['suppImg']['tmp_name'], "$dir/$newImageName");
        }

        $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
    } else {
        // Insert new user
        $suppNo = getSupplierNo($con);
        $stmt = $con->prepare("INSERT INTO supplier (supId, name, name_bn, compName, address, contactNo, email, suppImg, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $suppNo, $name, $name_bn, $compName, $address, $contactNo, $email, $newImageName, $status);
        
        if ($stmt->execute()) {
            $suppId = $stmt->insert_id;
            // Move uploaded image
            if ($_FILES['suppImg']['name']) {
                $dir = "../supp/$suppId";
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                move_uploaded_file($_FILES['suppImg']['tmp_name'], "$dir/$newImageName");
            }
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Operation failed.";
        }
        $stmt->close();
    }

    header('Location: supplier.php'); // FIXED TYPO
    exit();
}

// Handle user deletion
if (isset($_GET['del']) && $suppId > 0) {
    $supp = getSupp($con, $suppId);
    if ($supp) {
        $stmt = $con->prepare("DELETE FROM supplier WHERE id = ?");
        $stmt->bind_param("i", $suppId);
        
        if ($stmt->execute()) {
            $suppDir = "../supp/$suppId";
            if (is_dir($suppDir)) {
                array_map('unlink', glob("$suppDir/*"));
                rmdir($suppDir);
            }
            $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete Supplier.";
        }
        $stmt->close();
    } else {
        $_SESSION['delmsg'] = "Supplier not found. Cannot delete.";
    }
    header('Location: supplier.php'); // FIXED TYPO
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
                                    <li class="list-inline-item">Supplier (সরবরাহকারী) </li>
                                 </ul>
                              </div>
							  <button id="submitSupplier" class="au-btn au-btn-icon au-btn--green"><?php echo $suppId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
								
                              <div class="card-header"><?php echo $suppId ? 'Update' : 'Add'; ?> Supplier ( সরবরাহকারী <?php echo $suppId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="supplierForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                    <div class="col-6">
										<div class="form-group">
                                        <label for="name" class="control-label mb-1">Supplier Name ( সরবরাহকারী নাম )</label>
                                        <input id="name" name="name" type="text" class="form-control name valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="name"
                                            placeholder="Enter Supplier Name" value="<?php echo htmlentities($supp['name']); ?>" required>
										</div>
                                    </div>
                                    <div class="col-6">
										<div class="form-group">
                                        <label for="name_bn" class="control-label mb-1">Supplier Name Bangla ( সরবরাহকারী নাম বাংলা)</label>
                                        <input id="name_bn" name="name_bn" type="text" class="form-control name_bn valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="name_bn" 
                                            placeholder="Enter Supplier Name Bangla" value="<?php echo htmlentities($supp['name_bn']); ?>" required>
										</div>	
                                    </div>
									<div class="col-6">
										<div class="form-group">
                                        <label for="compName" class="control-label mb-1">Company Name ( কোম্পানি নাম )</label>
                                        <input id="compName" name="compName" type="text" class="form-control compName valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="compName"
                                            placeholder="Enter Supplier Company Name" value="<?php echo htmlentities($supp['compName']); ?>" required>
										</div>
                                    </div>
									<div class="col-6">
										<div class="form-group">
                                          <label for="address" class="control-label mb-1">Address ( ঠিকানা )</label>
                                             <textarea name="address" id="address" rows="2" placeholder="Content..." class="form-control"><?php echo htmlentities($supp['address']); ?></textarea>
										</div>	 
                                    </div>
                                    <div class="col-6">
										<div class="form-group">
                                        <label for="contactNo" class="control-label mb-1">Contact No ( কন্টাক্ট নং )</label>
                                        <input id="contactNo" name="contactNo" type="text" class="form-control contactNo valid"
											placeholder="Enter Supplier Contact No" 
											value="<?php echo htmlentities($supp['contactNo']); ?>" required
											maxlength="11"
											oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11)">
										</div>
                                    </div>
									<div class="col-6">
										<div class="form-group">
                                        <label for="email" class="control-label mb-1">Email ( ইমেইল )</label>
                                        <input id="email" name="email" type="text" class="form-control email valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="email" 
                                            placeholder="Enter Supplier Email" value="<?php echo htmlentities($supp['email']); ?>" required>
										</div>
                                    </div>

									 <?php if ($suppId && $supp['suppImg']) { ?>
									<div class="col-6">
										<div class="form-group">
										<label for="suppImg" class="control-label mb-1">Current User Image (বর্তমান সরবরাহকারী ছবি)</label>
										<div class="controls"><img src="../supp/<?php echo htmlentities($suppId); ?>/<?php echo htmlentities($supp['suppImg']); ?>" width="100" height="100"></div>
										</div>
									</div>
										
									<div class="col-6">
										<div class="form-group">
									    <label for="status">Status ( অবস্থা )</label>
										<select name="status" id="status" class="form-control">
											<option value="A" <?php echo ($supp['status'] == 'A') ? 'Active' : ''; ?>>Active (সক্রিয়)</option>
											<option value="I" <?php echo ($supp['status'] == 'I') ? 'Inactive' : ''; ?>>Inactive (নিষ্ক্রিয়)</option>
										</select>
										</div>
									</div>
									<?php } ?>
                                       <div class="col-6">
										<div class="form-group">
                                          <label for="suppImage" class="control-label mb-1">Supplier Image ( সরবরাহকারী ছবি )</label>
                                          <input type="file" name="suppImg" class="form-control-file" id="suppImg" required onchange="previewImage(event)">
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
											<th>Supplier Id<br>( সরবরাহকারী আইডি )</th>
                                            <th>Supplier Name<br>( সরবরাহকারী নাম )</th>
											<th>Company Name<br>( কোম্পানি নাম )</th>
											<th>Contact No <br>( কন্টাক্ট নং )</th>
											<th>Email <br>( ইমেইল )</th>
											<th>Picture <br>( ছবি )</th>
											<th>Status <br>( অবস্থা )</th>
                                            <th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT * FROM supplier ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['supId']); ?></td>
									   <td><?php echo htmlentities($row['name']).' - '.htmlentities($row['name_bn']); ?></td>
									   <td><?php echo htmlentities($row['compName']).' - '.htmlentities($row['address']); ?></td>
									   <td><?php echo '+88 '.htmlentities($row['contactNo']); ?></td>
									   <td><?php echo htmlentities($row['email']); ?></td>
									   <td><img src="../supp/<?php echo $row['id']; ?>/<?php echo htmlentities($row['suppImg']); ?>" width="100" height="100"></td>
									   <td><?php echo htmlentities($row['status'] == 'A') ? 'Active (সক্রিয়)' : 'Inactive (নিষ্ক্রিয়)'; ?></td>
									   <td><?php echo htmlentities($row['regDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="supplier.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="supplier.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
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
		document.getElementById("submitSupplier").addEventListener("click", function () {
        document.getElementById("supplierForm").submit();
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
