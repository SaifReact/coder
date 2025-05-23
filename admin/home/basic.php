<?php
session_start();
require('../../config/config.php');

if (empty($_SESSION['alogin'])) {
    header('Location: index.php');
    exit();
}

$basicId = isset($_GET['compId']) ? intval($_GET['compId']) : 0;
$imgId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$basic = [
    'compId' => '', 'description' => '', 'address' => '', 'phone' => '', 'office_phone' => '', 'email' => '',
    'logo' => '', 'currency' => '', 'facebook' => '', 'twitter' => '', 'linkedin' => '', 'open_time' => '', 'close_time' => '',
    'delivery_method' => '', 'messanger_group' => '', 'whatapps_group' => ''
];

function getBasic(PDO $pdo, int $basicId): ?array {
    $sql = "SELECT * FROM company a 
            INNER JOIN basic b ON a.id = b.compId 
            WHERE a.id = :id AND a.status = 'A'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $basicId]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function handleImageUpload(array $file): array {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!empty($file['name'])) {
        $imageType = mime_content_type($file['tmp_name']);
        if (!in_array($imageType, $allowedTypes)) {
            return [false, "Invalid image format. Only JPG, PNG, and WebP allowed."];
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            return [false, "File too large. Max 2MB allowed."];
        }
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        return [true, uniqid("img_", true) . '.' . $ext];
    }
    return [true, null];
}

// Load existing data if available
$basicData = getBasic($pdo, $basicId);
if ($basicData) {
    $basic = $basicData;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $compId = trim($_POST['compId'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $office_phone = trim($_POST['office_phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $facebook = trim($_POST['facebook'] ?? '');
        $twitter = trim($_POST['twitter'] ?? '');
        $linkedin = trim($_POST['linkedin'] ?? '');
        $open_time = trim($_POST['open_time'] ?? '');
        $close_time = trim($_POST['close_time'] ?? '');
        $delivery_method = trim($_POST['delivery_method'] ?? '');
        $messanger_group = trim($_POST['messanger_group'] ?? '');
        $whatapps_group = trim($_POST['whatapps_group'] ?? '');

        if (empty($address)) {
            $_SESSION['warnmsg'] = "Address is required.";
            header('Location: basic.php');
            exit();
        }

        [$logoValid, $newLogoImageName] = handleImageUpload($_FILES['logo']);
        [$currencyValid, $newCurrImageName] = handleImageUpload($_FILES['currency']);

        if (!$logoValid || !$currencyValid) {
            $_SESSION['msg'] = !$logoValid ? $newLogoImageName : $newCurrImageName;
            header('Location: basic.php');
            exit();
        }

        $newLogoImageName = $newLogoImageName ?: $basic['logo'];
        $newCurrImageName = $newCurrImageName ?: $basic['currency'];

        if ($basicData) {
            // UPDATE
            $sql = "UPDATE basic SET compId = :compId, description = :description, address = :address,
                    phone = :phone, office_phone = :office_phone, email = :email, logo = :logo,
                    currency = :currency, facebook = :facebook, twitter = :twitter, linkedin = :linkedin,
                    open_time = :open_time, close_time = :close_time, delivery_method = :delivery_method,
                    messanger_group = :messanger_group, whatapps_group = :whatapps_group
                    WHERE compId = :basicId";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'compId' => $compId, 'description' => $description, 'address' => $address,
                'phone' => $phone, 'office_phone' => $office_phone, 'email' => $email,
                'logo' => $newLogoImageName, 'currency' => $newCurrImageName, 'facebook' => $facebook,
                'twitter' => $twitter, 'linkedin' => $linkedin, 'open_time' => $open_time,
                'close_time' => $close_time, 'delivery_method' => $delivery_method,
                'messanger_group' => $messanger_group, 'whatapps_group' => $whatapps_group,
                'basicId' => $basicId
            ]);

            $logoDir = "../logo/$imgId";
            if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);
            if (!empty($_FILES['logo']['name'])) move_uploaded_file($_FILES['logo']['tmp_name'], "$logoDir/$newLogoImageName");
            if (!empty($_FILES['currency']['name'])) move_uploaded_file($_FILES['currency']['tmp_name'], "$logoDir/$newCurrImageName");

            $_SESSION['msg'] = $stmt->rowCount() ? "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!" : "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
        } else {
            // INSERT
            $sql = "INSERT INTO basic (compId, description, address, phone, office_phone, email, logo, currency,
                    facebook, twitter, linkedin, open_time, close_time, delivery_method, messanger_group, whatapps_group)
                    VALUES (:compId, :description, :address, :phone, :office_phone, :email, :logo, :currency,
                    :facebook, :twitter, :linkedin, :open_time, :close_time, :delivery_method, :messanger_group, :whatapps_group)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'compId' => $compId, 'description' => $description, 'address' => $address,
                'phone' => $phone, 'office_phone' => $office_phone, 'email' => $email,
                'logo' => $newLogoImageName, 'currency' => $newCurrImageName, 'facebook' => $facebook,
                'twitter' => $twitter, 'linkedin' => $linkedin, 'open_time' => $open_time,
                'close_time' => $close_time, 'delivery_method' => $delivery_method,
                'messanger_group' => $messanger_group, 'whatapps_group' => $whatapps_group
            ]);

            $insertId = $pdo->lastInsertId();
            $logoDir = "../logo/$insertId";
            if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);
            if (!empty($_FILES['logo']['name'])) move_uploaded_file($_FILES['logo']['tmp_name'], "$logoDir/$newLogoImageName");
            if (!empty($_FILES['currency']['name'])) move_uploaded_file($_FILES['currency']['tmp_name'], "$logoDir/$newCurrImageName");

            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        }

    } catch (PDOException $e) {
        $_SESSION['warnmsg'] = "Database Error: " . $e->getMessage();
    }

    header('Location: basic.php');
    exit();
}

// DELETE
if (isset($_GET['del'])) {
    try {
        $company = getBasic($pdo, $basicId);
        if ($company) {
            $stmt = $pdo->prepare("DELETE FROM basic WHERE compId = :compId AND id = :id");
            $stmt->execute(['compId' => $basicId, 'id' => $imgId]);
            if ($stmt->rowCount()) {
                $dir = "../logo/$imgId";
                if (is_dir($dir)) {
                    array_map('unlink', glob("$dir/*"));
                    rmdir($dir);
                }
                $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
            } else {
                $_SESSION['delmsg'] = "No data found to delete.";
            }
        } else {
            $_SESSION['delmsg'] = "Company not found.";
        }
    } catch (PDOException $e) {
        $_SESSION['delmsg'] = "Delete Failed: " . $e->getMessage();
    }

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
            <header class="header-desktop2"> <?php include('share/header.php');?> </header>
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
												<label for="compId" class="form-control-label">Company Name ( কোম্পানির নাম )</label>
												<?php
												$selectedCompId = $basic['compId'] ?? 0;

												echo '<select name="compId" id="compId" class="form-control">';
												echo '<option value="0"' . ($selectedCompId == 0 ? ' selected' : '') . '>Please Select - নির্বাচন করুন</option>';

												try {
													$stmt = $pdo->query("SELECT id, companyName, companyName_bn FROM company WHERE status = 'A'");
													while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
														$id = (int)$row['id'];
														$selected = ($id === (int)$selectedCompId) ? ' selected' : '';
														$name = htmlentities($row['companyName']);
														$name_bn = htmlentities($row['companyName_bn']);
														echo "<option value='{$id}'{$selected}>{$name} - {$name_bn}</option>";
													}
												} catch (PDOException $e) {
													echo '<option value="">Error loading companies</option>';
												}

												echo '</select>';
												?>
											</div>
										</div>

										<div class="col-6">
                                          <div class="form-group">
                                             <label for="address" class="control-label mb-1">Address ( ঠিকানা)</label>
											 <textarea name="address" id="address" rows="2" placeholder="Address ( ঠিকানা)..." class="form-control"><?php echo htmlentities($basic['address'] ?? ''); ?></textarea>
                                          </div>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
										<div class="form-group">
                                          <label for="description" class="control-label mb-1">Company Description ( কোম্পানির বিবরণ )</label>
                                          <textarea name="description" id="delivery_method" rows="5" placeholder="Company Description ( কোম্পানির বিবরণ )..." class="form-control"><?php echo htmlentities($basic['description'] ?? ''); ?></textarea>
										</div>
									   </div>
									   <div class="col-6">
                                          <div class="form-group">
                                             <label for="delivery_method" class="control-label mb-1">Delivery Method ( ডেলিভারি মেথড )</label>
                                             <textarea name="delivery_method" id="delivery_method" rows="5" placeholder="Delivery Method ( ডেলিভারি মেথড )..." class="form-control"><?php echo htmlentities($basic['delivery_method'] ?? ''); ?></textarea>
                                          </div>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="phone" class="control-label mb-1">Phone ( ফোন নং  )</label>
                                             <input id="phone" name="phone" type="text" class="form-control phone valid"  autocomplete="phone" aria-required="true" aria-invalid="false" aria-describedby="phone-error"
                                                placeholder="Enter Phone No" value="<?php echo htmlentities($basic['phone']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="office_phone" class="control-label mb-1">Office Phone ( অফিস ফোন নং )</label>
                                          <input id="office_phone" name="office_phone" type="text" class="form-control office_phone valid"  autocomplete="office_phone" aria-required="true" aria-invalid="false" aria-describedby="office_phone-error"
                                             placeholder="Enter Office Phone No" value="<?php echo htmlentities($basic['office_phone']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="email" class="control-label mb-1">Email ( ইমেইল )</label>
                                             <input id="email" name="email" type="text" class="form-control email valid"  autocomplete="email" aria-required="true" aria-invalid="false" aria-describedby="email-error"
                                                placeholder="Enter Company Email" value="<?php echo htmlentities($basic['email']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="facebook" class="control-label mb-1">Facebook ( ফেইসবুক )</label>
                                          <input id="facebook" name="facebook" type="text" class="form-control facebook valid"  autocomplete="facebook" aria-required="true" aria-invalid="false" aria-describedby="facebook-error"
                                             placeholder="Enter Company Facebook" value="<?php echo htmlentities($basic['facebook']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="twitter" class="control-label mb-1">Twitter ( টুইটার )</label>
                                             <input id="twitter" name="twitter" type="text" class="form-control twitter valid"  autocomplete="twitter" aria-required="true" aria-invalid="false" aria-describedby="twitter-error"
                                                placeholder="Enter Company Twitter" value="<?php echo htmlentities($basic['twitter']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="linkedin" class="control-label mb-1">Linkedin ( লিঙ্কেডিন )</label>
                                          <input id="linkedin" name="linkedin" type="text" class="form-control linkedin valid"  autocomplete="facebook" aria-required="true" aria-invalid="false" aria-describedby="linkedin-error"
                                             placeholder="Enter Company Linkedin" value="<?php echo htmlentities($basic['linkedin']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="messanger_group" class="control-label mb-1">Messanger Group ( মেসেঞ্জার গ্রুপ )</label>
                                             <input id="messanger_group" name="messanger_group" type="text" class="form-control messanger_group valid"  autocomplete="messanger_group" aria-required="true" aria-invalid="false" aria-describedby="messanger_group-error"
                                                placeholder="Enter Company Messanger Group" value="<?php echo htmlentities($basic['messanger_group']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="whatapps_group" class="control-label mb-1">Whatsapp Group ( হোয়াটঅ্যাপ গ্রুপ )</label>
                                          <input id="whatapps_group" name="whatapps_group" type="text" class="form-control whatapps_group valid"  autocomplete="whatapps_group" aria-required="true" aria-invalid="false" aria-describedby="whatapps_group-error"
                                             placeholder="Enter Company Whatapps Group" value="<?php echo htmlentities($basic['whatapps_group']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="open_time" class="control-label mb-1">Open Time ( খোলার সময় )</label>
                                             <input id="open_time" name="open_time" type="text" class="form-control open_time valid"  autocomplete="open_time" aria-required="true" aria-invalid="false" aria-describedby="open_time-error"
                                                placeholder="Enter Company Open Time" value="<?php echo htmlentities($basic['open_time']); ?>" required>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="close_time" class="control-label mb-1">Close Time ( বন্ধের সময় )</label>
                                          <input id="close_time" name="close_time" type="text" class="form-control close_time valid"  autocomplete="close_time" aria-required="true" aria-invalid="false" aria-describedby="close_time-error"
                                             placeholder="Enter Company Close Time" value="<?php echo htmlentities($basic['close_time']); ?>" required>
                                       </div>
                                    </div>
									<div class="row">
                                       <div class="col-6">
                                        <?php if ($imgId && $basic['logo']) { ?>
											<div class="form-group">
											<label for="logo" class="control-label mb-1">Current Logo ( বর্তমান লোগো  )</label>
												<div class="controls">
													<img src="../logo/<?php echo htmlentities($imgId); ?>/<?php echo htmlentities($basic['logo']); ?>" width="100" height="100">
												</div>
											</div>
										<?php } ?>
                                       </div>
                                       <div class="col-6">
                                          <?php if ($imgId && $basic['currency']) { ?>
											<div class="form-group">
											<label for="currency" class="control-label mb-1">Current Currency ( বর্তমান মুদ্রা  )</label>
												<div class="controls">
													<img src="../logo/<?php echo htmlentities($imgId); ?>/<?php echo htmlentities($basic['currency']); ?>" width="20" height="20">
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
                                            <th>Updation Date <br>( হালনাগাদ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php
									try {
										$stmt = $pdo->query("SELECT * FROM COMPANY a INNER JOIN BASIC b ON a.id = b.compId");
										$cnt = 1;
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
											$companyName = htmlentities($row['companyName'] ?? '');
											$companyNameBn = htmlentities($row['companyName_bn'] ?? '');
											$address = htmlentities($row['address'] ?? '');
											$phone = htmlentities($row['phone'] ?? '');
											$officePhone = htmlentities($row['office_phone'] ?? '');
											$email = htmlentities($row['email'] ?? '');
											$updationDate = htmlentities($row['updationDate'] ?? '');
											$compId = (int)$row['compId'];
											$id = (int)$row['id'];

											$logoPath = "../logo/{$id}/" . $row['logo'];
											$currencyPath = "../logo/{$id}/" . $row['currency'];
											$defaultImage = "../logo/no_image.png";

											$logoSrc = (!empty($row['logo']) && file_exists($logoPath)) ? $logoPath : $defaultImage;
											$currencySrc = (!empty($row['currency']) && file_exists($currencyPath)) ? $currencyPath : $defaultImage;
									?>
										<tr>
											<td><?= $cnt++; ?></td>
											<td><?= $companyName ?> - <?= $companyNameBn ?></td>
											<td><img src="<?= $logoSrc ?>" style="max-width: 120px; height: auto;"></td>
											<td><?= $address ?></td>
											<td><?= $phone ?> - <?= $officePhone ?></td>
											<td><?= $email ?></td>
											<td><img src="<?= $currencySrc ?>" width="75" height="75"></td>
											<td><?= $updationDate ?></td>
											<td>
												<div class="table-data-feature">
													<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
														<a href="basic.php?compId=<?= $compId ?>&id=<?= $id ?>" style="text-decoration: none; display: flex; align-items: center;">
															<i class="zmdi zmdi-edit" style="color:#008000"></i>
														</a>
													</button>
													<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
														<a href="basic.php?compId=<?= $compId ?>&id=<?= $id ?>&del=delete" onclick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
															<i class="zmdi zmdi-delete" style="color:#FF0000"></i>
														</a>
													</button>
												</div>
											</td>
										</tr>
									<?php
										}
									} catch (PDOException $e) {
										echo "<tr><td colspan='9'>Error loading data: " . htmlentities($e->getMessage()) . "</td></tr>";
									}
									?>

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
   </html>
