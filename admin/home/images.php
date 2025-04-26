<?php
session_start();
require('../../config/config.php');

if (empty($_SESSION['alogin'])) {
    header('Location: index.php');
    exit();
}

$imageId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$image = ['imgType' => '', 'image' => '', 'imgName' => '', 'imgDesc' => '', 'status' => ''];

function getPDO(): PDO {
    global $pdo;
    return $pdo;
}

function getImage($imageId) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT im.*, ba.bannerName, ba.bannerType 
                           FROM images im 
                           JOIN banner ba ON ba.bannerType = im.imgType 
                           WHERE im.id = ?");
    $stmt->execute([$imageId]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
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
        return [true, uniqid("img_", true) . '.' . $imageExtension];
    }
    return [true, null];
}

try {
    $pdo = getPDO();

    if ($imageId > 0) {
        $imageData = getImage($imageId);
        if ($imageData) {
            $image = $imageData;
        } else {
            $_SESSION['msg'] = "Image Not Found.";
            header('Location: images.php');
            exit();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $imgType = trim($_POST['imgType'] ?? '');
        $imgName = trim($_POST['imgName'] ?? '');
        $imgDesc = trim($_POST['imgDesc'] ?? '');
        $status = trim($_POST['status'] ?? '');

        if (empty($imgName) || empty($imgType)) {
            $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
            header('Location: images.php');
            exit();
        }

        list($valid, $newImageName) = handleImageUpload($_FILES['image']);
        if (!$valid) {
            $_SESSION['msg'] = $newImageName;
            header('Location: images.php');
            exit();
        }

        $newImageName = $newImageName ?: $image['image'];

        if ($imageId > 0) {
            if (
                $imgType !== $image['imgType'] ||
                $newImageName !== $image['image'] ||
                $imgName !== $image['imgName'] ||
                $imgDesc !== $image['imgDesc'] ||
                $status !== $image['status']
            ) {
                $stmt = $pdo->prepare("UPDATE images SET imgType = ?, image = ?, imgName = ?, imgDesc = ?, status = ? WHERE id = ?");
                $stmt->execute([$imgType, $newImageName, $imgName, $imgDesc, $status, $imageId]);

                if ($_FILES['image']['name']) {
                    $dir = "../images/$imageId";
                    if (!is_dir($dir)) mkdir($dir, 0777, true);
                    move_uploaded_file($_FILES['image']['tmp_name'], "$dir/$newImageName");
                }

                $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
            } else {
                $_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি।)";
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO images (imgType, image, imgName, imgDesc, status) VALUES (?, ?, ?, ?, 'A')");
            if ($stmt->execute([$imgType, $newImageName, $imgName, $imgDesc])) {
                $imageId = $pdo->lastInsertId();
                if ($_FILES['image']['name']) {
                    $dir = "../images/$imageId";
                    if (!is_dir($dir)) mkdir($dir, 0777, true);
                    move_uploaded_file($_FILES['image']['tmp_name'], "$dir/$newImageName");
                }
                $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
            } else {
                $_SESSION['warnmsg'] = "Database error: Operation failed.";
            }
        }

        header('Location: images.php');
        exit();
    }

    if (isset($_GET['del']) && $imageId > 0) {
        $image = getImage($imageId);
        if ($image) {
            $stmt = $pdo->prepare("DELETE FROM images WHERE id = ?");
            if ($stmt->execute([$imageId])) {
                $imgDir = "../images/$imageId";
                if (is_dir($imgDir)) {
                    array_map('unlink', glob("$imgDir/*"));
                    rmdir($imgDir);
                }
                $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
            } else {
                $_SESSION['delmsg'] = "Database error: Failed to delete image.";
            }
        } else {
            $_SESSION['delmsg'] = "Image not found. Cannot delete.";
        }
        header('Location: images.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['errormsg'] = "Database error: " . $e->getMessage();
    header('Location: images.php');
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
                                    <li class="list-inline-item">Images (ছবিসমূহ) </li>
                                 </ul>
                              </div>
							  <button id="submitImages" class="au-btn au-btn-icon au-btn--green"><?php echo $imageId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
								
                              <div class="card-header"><?php echo $imageId ? 'Update' : 'Add'; ?> Images (ছবিসমূহ <?php echo $imageId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="imagesForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
									   <div class="col-6">
											<div class="form-group">
												<label for="compId" class="form-control-label">Company Name ( কোম্পানির নাম )</label>
												<?php
												$selectedCompId = $basic['compId'] ?? 0;

												echo '<select name="compId" id="compId" class="form-control">';
												echo '<option value="0"' . ($selectedCompId == 0 ? ' selected' : '') . '>Please Select - নির্বাচন করুন</option>';

												try {
													$pdo = getPDO(); // Assuming getPDO() returns the PDO connection
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
												<label for="select" class="form-control-label">Image Place ( ছবির স্থান )</label>
												<select name="imgType" id="imgType" class="form-control">
													<?php if (!empty($image['id'])) { ?>
														<option value="<?php echo htmlentities($image['bannerType']); ?>">
															<?php echo htmlentities($image['bannerName']); ?>
														</option>
													<?php } else { ?>
														<option value="0">Please Select - নির্বাচন করুন</option>
													<?php } ?>

													<?php
													try {
														$pdo = getPDO(); // Assuming getPDO() returns the PDO connection
														$stmt = $pdo->query("SELECT * FROM banner");
														while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
															echo "<option value='" . htmlentities($row['bannerType']) . "'>" . htmlentities($row['bannerName']) . "</option>";
														}
													} catch (PDOException $e) {
														echo "<option disabled>Error fetching data</option>";
													}
													?>
												</select>
											</div>
										</div>

                                       <div class="col-6">
                                          <label for="imgName" class="control-label mb-1">Image Name ( ছবির নাম )</label>
                                             <input id="imgName" name="imgName" type="text" class="form-control imgName valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="imgName"
                                                placeholder="Enter Image Name" value="<?php echo htmlentities($image['imgName']); ?>">
                                       </div>
									   <div class="col-6">
                                          <label for="imgDesc" class="control-label mb-1">Description ( বর্ণনা)</label>
                                             <textarea name="imgDesc" id="imgDesc" rows="2" placeholder="Content..." class="form-control"><?php echo htmlentities($image['imgDesc'] ?? ''); ?></textarea>
                                       </div>
									   <?php if ($imageId && $image['image']) { ?>
										<div class="col-6">
										<label for="image" class="control-label mb-1">Current Image (বর্তমান ছবি)</label>
											<div class="controls">
												<img src="../images/<?php echo htmlentities($imageId); ?>/<?php echo htmlentities($image['image']); ?>" width="100" height="100">
											</div>
										</div>
										<div class="col-6">
											<label for="status">Status ( অবস্থা )</label>
											<select name="status" id="status" class="form-control">
												<option value="A" <?php echo ($image['status'] == 'A') ? 'Active' : ''; ?>>Active (সক্রিয়)</option>
												<option value="I" <?php echo ($image['status'] == 'I') ? 'Inactive' : ''; ?>>Inactive (নিষ্ক্রিয়)</option>
											</select>
										</div>
									<?php } ?>
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="image" class="control-label mb-1">Image ( ছবি )</label>
                                             <input type="file" name="image" class="form-control-file" id="image" required onchange="previewImage(event)">
											 <br/>
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
                                            <th>Image Name <br> ( ছবির নাম )</th>
											<th>Image Place <br> ( ছবির স্থান )</th>
											<th>Image <br>( ছবি )</th>
											<th>Description <br>( বর্ণনা )</th>
											<th>Status <br>( অবস্থা )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php
									try {
										$pdo = getPDO(); // Assuming getPDO() returns the PDO connection
										$stmt = $pdo->query("SELECT im.*, ba.bannerName, ba.bannerType FROM images im 
															 JOIN banner ba ON ba.bannerType = im.imgType ORDER BY id DESC");

										$cnt = 1;
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									?>
											<tr>
												<td><?php echo $cnt++; ?></td>
												<td><?php echo htmlentities($row['imgName']); ?></td>
												<td><?php echo htmlentities($row['bannerName']); ?></td>
												<td><img src="../images/<?php echo $row['id']; ?>/<?php echo htmlentities($row['image']); ?>" width="100" height="100"></td>
												<td><?php echo htmlentities($row['imgDesc']); ?></td>
												<td><?php echo htmlentities($row['status'] == 'A') ? 'Active (সক্রিয়)' : 'Inactive (নিষ্ক্রিয়)'; ?></td>
												<td>
													<div class="table-data-feature">
														<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
															<a href="images.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
																<i class="zmdi zmdi-edit" style="color:#008000"></i>
															</a>
														</button>
														<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
															<a href="images.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
																<i class="zmdi zmdi-delete" style="color:#FF0000"></i>
															</a>
														</button>
													</div>
												</td>
											</tr>
									<?php
										}
									} catch (PDOException $e) {
										echo "Error: " . $e->getMessage();
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
		document.getElementById("submitImages").addEventListener("click", function () {
        document.getElementById("imagesForm").submit();
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
