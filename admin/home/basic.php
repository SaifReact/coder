<?php
session_start();
include('../include/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

$basicId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$basic = ['compName' => '', 'compName_en' => '', 'compDescription'  => '', 'address'  => '', 'phone'  => '', 'office_phone'  => '', 'email'  => '', 
'logo'  => '', 'currency'  => '', 'facebook'  => '', 'twitter'  => '', 'linkedin'  => '', 'open_time'  => '', 'off_time'  => '', 'delivery_process'  => '', 
'seller_policy'  => '', 'return_policy'  => '', 'support_policy'  => ''];

function getBasic($con, $basicId) {
    $stmt = $con->prepare("SELECT * FROM basic WHERE id = ?");
    $stmt->bind_param("i", $basicId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc() ?: null;
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
        return [true, uniqid("cat_", true) . '.' . $imageExtension];
    }
    return [true, null];
}

if ($basicId > 0) {
    $basicData = getBasic($con, $basicId);
    if ($basicData) {
        $basic = $basicData;
    } else {
        $_SESSION['msg'] = "category not found.";
        header('Location: category.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize and assign input data, falling back to empty strings where needed
    $compName = trim($_POST['compName'] ?? '');
    $compName_en = trim($_POST['compName_en'] ?? '');
    $compDescription = trim($_POST['compDescription'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $office_phone = trim($_POST['office_phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $facebook = trim($_POST['facebook'] ?? '');
    $twitter = trim($_POST['twitter'] ?? '');
    $linkedin = trim($_POST['linkedin'] ?? '');
    $open_time = trim($_POST['open_time'] ?? '');
    $off_time = trim($_POST['off_time'] ?? '');
    $delivery_process = trim($_POST['delivery_process'] ?? '');
    $seller_policy = trim($_POST['seller_policy'] ?? '');
    $return_policy = trim($_POST['return_policy'] ?? '');
    $support_policy = trim($_POST['support_policy'] ?? '');

    // Prevent processing if required fields are missing
    if (empty($compName) || empty($compName_en)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: basic.php');
        exit();
    }

    // Handle image uploads
    list($logoValid, $newLogoImageName) = handleImageUpload($_FILES['logo']);
    list($currencyValid, $newCurrImageName) = handleImageUpload($_FILES['currency']);

    // If either image upload fails, set appropriate message and exit
    if (!$logoValid || !$currencyValid) {
        $_SESSION['msg'] = !$logoValid ? $newLogoImageName : $newCurrImageName;
        header('Location: basic.php');
        exit();
    }

    // Use existing image names if no new images are uploaded
    $newLogoImageName = $newLogoImageName ?: $basic['logo'];
    $newCurrImageName = $newCurrImageName ?: $basic['currency'];

    // Check if category is being updated
    if ($basicId > 0) {
        // Update category only if there are changes
        if ($compName !== $basic['compName'] || 
		$compName_en !== $basic['compName_en'] || 
		$compDescription !== $basic['compDescription'] ||
		$address = $basic['address'] ||
		$phone = $basic['phone'] ||
		$office_phone = $basic['office_phone'] ||
		$email = $basic['email'] ||
		$newLogoImageName !== $basic['logo'] || 
		$newCurrImageName !== $basic['currency'] ||
		$facebook = $basic['facebook'] ||
		$twitter = $basic['twitter'] ||
		$linkedin = $basic['linkedin'] ||
		$open_time = $basic['open_time'] ||
		$off_time = $basic['off_time'] ||
		$delivery_process = $basic['delivery_process'] ||
		$seller_policy = $basic['seller_policy'] ||
		$return_policy = $basic['return_policy'] ||
		$support_policy = $basic['support_policy']) {
            $stmt = $con->prepare("UPDATE company SET compName = ?, compName_en = ?, compDescription = ?, address = ?, office_phone = ?, 
			email = ?, logo = ?, currency = ?, facebook = ?,twitter = ?,linkedin = ?, open_time = ?, off_time = ?,delivery_process = ?, seller_policy = ?,
			return_policy = ?,support_policy = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $compName, $compName_en, $compDescription, $address, $phone, $office_phone, $email, 
			$newLogoImageName, $newCurrImageName, $facebook, $twitter, $linkedin, $open_time, $off_time, $delivery_process, 
			$seller_policy, $return_policy, $support_policy, $basicId);
            $stmt->execute();
            $stmt->close();

            // Move the uploaded images to the appropriate directories
            if ($_FILES['logo']['name']) {
                $logoDir = "../logo/$basicId";
                if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);
                move_uploaded_file($_FILES['logo']['tmp_name'], "$logoDir/$newLogoImageName");
            }

            if ($_FILES['currency']['name']) {
                $currencyDir = "../logo/$basicId";
                if (!is_dir($currencyDir)) mkdir($currencyDir, 0777, true);
                move_uploaded_file($_FILES['currency']['tmp_name'], "$currencyDir/$newCurrImageName");
            }

            $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
        }
    }

    // Redirect to the basic.php page with appropriate messages
    header('Location: basic.php');
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
                                    <li class="list-inline-item">Basic (বেসিক) </li>
                                 </ul>
                              </div>
							  <button id="submitBasic" class="au-btn au-btn-icon au-btn--green"><?php echo $basicId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
								
                              <div class="card-header"><?php echo $basicId ? 'Update' : 'Add'; ?> Basic ( বেসিক <?php echo $basicId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="basicForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="compName_en" class="control-label mb-1">Company Name ( কোম্পানি নাম )</label>
                                             <input id="compName_en" name="compName_en" type="text" class="form-control compName_en valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="compName_en" aria-required="true" aria-invalid="false" aria-describedby="compName_en-error"
                                                placeholder="Enter Company Name" value="<?php echo htmlentities($basic['compName_en']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="compName_en" class="control-label mb-1">Company Name Bangla ( কোম্পানি নাম বাংলা)</label>
                                          <input id="compName" name="compName" type="text" class="form-control compName valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="compName" aria-required="true" aria-invalid="false" aria-describedby="compName-error"
                                             placeholder="Enter Company Name Bangla" value="<?php echo htmlentities($basic['compName']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="address" class="control-label mb-1">Address ( ঠিকানা)</label>
											 <textarea name="address" id="address" rows="5" placeholder="Content..." class="form-control"><?php echo htmlentities($basic['address'] ?? ''); ?></textarea>
                                          </div>
                                       </div>
									   <div class="col-6">
                                          <div class="form-group">
                                             <label for="compDescription" class="control-label mb-1">Description ( বর্ণনা)</label>
											 <textarea name="compDescription" id="compDescription" rows="5" placeholder="Content..." class="form-control"><?php echo htmlentities($basic['compDescription'] ?? ''); ?></textarea>
                                          </div>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="phone" class="control-label mb-1">Phone ( ফোন নং  )</label>
                                             <input id="phone" name="phone" type="text" class="form-control phone valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="phone" aria-required="true" aria-invalid="false" aria-describedby="phone-error"
                                                placeholder="Enter Phone No" value="<?php echo htmlentities($basic['phone']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="office_phone" class="control-label mb-1">Office Phone ( অফিস ফোন নং )</label>
                                          <input id="office_phone" name="office_phone" type="text" class="form-control office_phone valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="office_phone" aria-required="true" aria-invalid="false" aria-describedby="office_phone-error"
                                             placeholder="Enter Office Phone No" value="<?php echo htmlentities($basic['office_phone']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="email" class="control-label mb-1">Email ( ইমেইল )</label>
                                             <input id="email" name="email" type="text" class="form-control email valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="email" aria-required="true" aria-invalid="false" aria-describedby="email-error"
                                                placeholder="Enter Company Email" value="<?php echo htmlentities($basic['email']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="facebook" class="control-label mb-1">Facebook ( ফেইসবুক )</label>
                                          <input id="facebook" name="facebook" type="text" class="form-control facebook valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="facebook" aria-required="true" aria-invalid="false" aria-describedby="facebook-error"
                                             placeholder="Enter Company Facebook" value="<?php echo htmlentities($basic['facebook']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="twitter" class="control-label mb-1">Twitter ( টুইটার )</label>
                                             <input id="twitter" name="twitter" type="text" class="form-control twitter valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="twitter" aria-required="true" aria-invalid="false" aria-describedby="twitter-error"
                                                placeholder="Enter Company Twitter" value="<?php echo htmlentities($basic['twitter']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="linkedin" class="control-label mb-1">Linkedin ( লিঙ্কেডিন )</label>
                                          <input id="linkedin" name="linkedin" type="text" class="form-control linkedin valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="facebook" aria-required="true" aria-invalid="false" aria-describedby="linkedin-error"
                                             placeholder="Enter Company Linkedin" value="<?php echo htmlentities($basic['linkedin']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="twitter" class="control-label mb-1">Open Time ( খোলার সময় )</label>
                                             <input id="twitter" name="twitter" type="text" class="form-control twitter valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="twitter" aria-required="true" aria-invalid="false" aria-describedby="twitter-error"
                                                placeholder="Enter Company Twitter" value="<?php echo htmlentities($basic['twitter']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="linkedin" class="control-label mb-1">Close Time ( বন্ধের সময় )</label>
                                          <input id="linkedin" name="linkedin" type="text" class="form-control linkedin valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="facebook" aria-required="true" aria-invalid="false" aria-describedby="linkedin-error"
                                             placeholder="Enter Company Linkedin" value="<?php echo htmlentities($basic['linkedin']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="delivery_process" class="control-label mb-1">Delivery Method ( ডেলিভারি মেথড )</label>
                                             <textarea name="delivery_process" id="delivery_process" rows="5" placeholder="Content..." class="form-control"><?php echo htmlentities($basic['delivery_process'] ?? ''); ?></textarea>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="seller_policy" class="control-label mb-1">Seller Policy ( বিক্রয় নীতি  )</label>
                                          <textarea name="seller_policy" id="seller_policy" rows="5" placeholder="Content..." class="form-control"><?php echo htmlentities($basic['seller_policy'] ?? ''); ?></textarea>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="return_policy" class="control-label mb-1">Return Policy ( রিটার্ন পলিসি )</label>
                                             <textarea name="return_policy" id="return_policy" rows="5" placeholder="Content..." class="form-control"><?php echo htmlentities($basic['return_policy'] ?? ''); ?></textarea>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="support_policy" class="control-label mb-1">Support Policy ( সমর্থন নীতি )</label>
                                          <textarea name="support_policy" id="support_policy" rows="5" placeholder="Content..." class="form-control"><?php echo htmlentities($basic['support_policy'] ?? ''); ?></textarea>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                        <?php if ($basicId && $basic['logo']) { ?>
											<div class="form-group">
											<label for="logo" class="control-label mb-1">Current Logo ( বর্তমান লোগো  )</label>
												<div class="controls">
													<img src="../logo/<?php echo htmlentities($basicId); ?>/<?php echo htmlentities($basic['logo']); ?>" width="100" height="100">
												</div>
											</div>
										<?php } ?>
                                       </div>
                                       <div class="col-6">
                                          <?php if ($basicId && $basic['currency']) { ?>
											<div class="form-group">
											<label for="currency" class="control-label mb-1">Current Currency ( বর্তমান মুদ্রা  )</label>
												<div class="controls">
													<img src="../logo/<?php echo htmlentities($basicId); ?>/<?php echo htmlentities($basic['currency']); ?>" width="20" height="20">
												</div>
											</div>
										<?php } ?>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="logo" class="control-label mb-1">New Logo ( নতুন লোগো  )</label>
                                             <input type="file" name="logo" multiple onchange="previewImages(event, 'logoPreviewContainer')" />
											 <div id="logoPreviewContainer" style="display: flex; flex-wrap: wrap;"></div>	
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="currency" class="control-label mb-1">New Currency ( নতুন লোগো  )</label>
                                             <input type="file" name="currency" multiple onchange="previewImages(event, 'currencyPreviewContainer')" />
											 <div id="currencyPreviewContainer" style="display: flex; flex-wrap: wrap;"></div>	
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
                                            <th>Name <br>( নাম )</th>
											<th>Logo <br>( লোগো )</th>
                                            <th>Address <br>( ঠিকানা  )</th>
											<th>Phone <br>( ফোন নং )</th>
											<th>Email <br>( ইমেইল  )</th>
											<th>Currency <br>( মুদ্রা )</th>
                                            <th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT * FROM basic");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['compName']).' - '.htmlentities($row['compName_en']); ?></td>
									   <td><img src="../logo/<?php echo $row['id']; ?>/<?php echo htmlentities($row['logo']); ?>" style="max-width: 100px; height: auto;"></td>
									   <td><?php echo htmlentities($row['address']); ?></td>
									   <td><?php echo htmlentities($row['phone']).' - '.htmlentities($row['office_phone']); ?></td>
									   <td><?php echo htmlentities($row['email']); ?></td>
                                       <td><img src="../logo/<?php echo $row['id']; ?>/<?php echo htmlentities($row['currency']); ?>" width="100" height="100"></td>
                                       <td><?php echo htmlentities($row['updationDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="basic.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
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
		document.getElementById("submitBasic").addEventListener("click", function () {
        document.getElementById("basicForm").submit();
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
