<?php
session_start();
include('../include/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

$brandId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$brand = ['brandsName' => '', 'brandsName_en' => '', 'brandsImage' => ''];

function getBrand($con, $brandId) {
    $stmt = $con->prepare("SELECT * FROM brands WHERE id = ?");
    $stmt->bind_param("i", $brandId);
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
        return [true, uniqid("brand_", true) . '.' . $imageExtension];
    }
    return [true, null];
}

if ($brandId > 0) {
    $brandData = getBrand($con, $brandId);
    if ($brandData) {
        $brand = $brandData;
    } else {
        $_SESSION['msg'] = "Brand not found.";
        header('Location: brands.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brandsName = trim($_POST['brandsName'] ?? '');
    $brandsName_en = trim($_POST['brandsName_en'] ?? '');

    // Prevent processing if required fields are missing
    if (empty($brandsName) || empty($brandsName_en)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: brands.php');
        exit();
    }

    list($valid, $newImageName) = handleImageUpload($_FILES['brandsImage']);
    if (!$valid) {
        $_SESSION['msg'] = $newImageName;
        header('Location: brands.php');
        exit();
    }

    $newImageName = $newImageName ?: $brand['brandsImage'];

    if ($brandId > 0) {
        // Update only if there are changes
        if ($brandsName !== $brand['brandsName'] || $brandsName_en !== $brand['brandsName_en'] || $newImageName !== $brand['brandsImage']) {
            $stmt = $con->prepare("UPDATE brands SET brandsName = ?, brandsName_en = ?, brandsImage = ? WHERE id = ?");
            $stmt->bind_param("sssi", $brandsName, $brandsName_en, $newImageName, $brandId);
            $stmt->execute();
            $stmt->close();

            // Move new image if uploaded
            if ($_FILES['brandsImage']['name']) {
                $dir = "../brandsimages/$brandId";
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                move_uploaded_file($_FILES['brandsImage']['tmp_name'], "$dir/$newImageName");
            }
            $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি।)";
        }
    } else {
        $stmt = $con->prepare("INSERT INTO brands (brandsName, brandsName_en, brandsImage) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $brandsName, $brandsName_en, $newImageName);
        if ($stmt->execute()) {
            $brandId = $stmt->insert_id;
            if ($_FILES['brandsImage']['name']) {
                $dir = "../brandsimages/$brandId";
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                move_uploaded_file($_FILES['brandsImage']['tmp_name'], "$dir/$newImageName");
            }
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Operation failed.";
        }
        $stmt->close();
    }
    header('Location: brands.php');
    exit();
}

if (isset($_GET['del']) && $brandId > 0) {
    $brand = getBrand($con, $brandId);
    if ($brand) {
        $stmt = $con->prepare("DELETE FROM brands WHERE id = ?");
        $stmt->bind_param("i", $brandId);
        if ($stmt->execute()) {
            $brandDir = "../brandsimages/$brandId";
            if (is_dir($brandDir)) {
                array_map('unlink', glob("$brandDir/*"));
                rmdir($brandDir);
            }
            $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete brand.";
        }
        $stmt->close();
    } else {
        $_SESSION['delmsg'] = "Brand not found. Cannot delete.";
    }
    header('Location: brands.php');
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
                                    <li class="list-inline-item">Brands (ব্র্যান্ডস) </li>
                                 </ul>
                              </div>
							  <button id="submitBrand" class="au-btn au-btn-icon au-btn--green"><?php echo $brandId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
								
                              <div class="card-header"><?php echo $brandId ? 'Update' : 'Add'; ?> Brands ( ব্র্যান্ডস <?php echo $brandId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="brandForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
									
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="brandsName_en" class="control-label mb-1">Brands Name ( ব্র্যান্ডস নাম )</label>
                                             <input id="brandsName_en" name="brandsName_en" type="text" class="form-control brandsName_en valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="brandsName_en" aria-required="true" aria-invalid="false" aria-describedby="brandsName_en-error"
                                                placeholder="Enter Brands Name" value="<?php echo htmlentities($brand['brandsName_en']); ?>" required>
                                             <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="brandsName" class="control-label mb-1">Brands Name Bangla ( ব্র্যান্ডস নাম বাংলা)</label>
                                          <div class="input-group">
                                             <input id="brandsName" name="brandsName" type="text" class="form-control brandsName valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="brandsName" aria-required="true" aria-invalid="false" aria-describedby="brandsName-error"
                                                placeholder="Enter Brands Name Bangla" value="<?php echo htmlentities($brand['brandsName']); ?>" required>
                                          </div>
                                       </div>
                                    </div>
									 <?php if ($brandId && $brand['brandsImage']) { ?>
										<div class="form-group">
										<label for="brandsImage" class="control-label mb-1">Current Brand Image (বর্তমান ব্র্যান্ডস ছবি)</label>
											<div class="controls">
												<img src="../brandsimages/<?php echo htmlentities($brandId); ?>/<?php echo htmlentities($brand['brandsImage']); ?>" width="100" height="100">
											</div>
										</div>
									<?php } ?>
                                    <div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="brandsImage" class="control-label mb-1">Brands Image ( ব্র্যান্ডস ছবি )</label>
                                             <input type="file" name="brandsImage" class="form-control-file" id="brandsImage" required onchange="previewImage(event)">
                                             <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 100px; max-height: 100px; display: none;" />
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
                                            <th>Brands <br>( ব্র্যান্ডস )</th>
											<th>Brands Bang <br>( ব্র্যান্ডস বাং )</th>
                                            <th>Image <br>( ছবি )</th>
                                            <th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT * FROM brands ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['brandsName_en']); ?></td>
									   <td><?php echo htmlentities($row['brandsName']); ?></td>
                                       <td><img src="../brandsimages/<?php echo $row['id']; ?>/<?php echo htmlentities($row['brandsImage']); ?>" width="100" height="100"></td>
                                       <td><?php echo htmlentities($row['postingDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="brands.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="brands.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
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
		document.getElementById("submitBrand").addEventListener("click", function () {
        document.getElementById("brandForm").submit();
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
