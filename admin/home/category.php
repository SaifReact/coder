<?php
session_start();
include('../../includes/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

$catId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$cat = ['catName' => '', 'catName_en' => '', 'catImage' => ''];

function getcat($con, $catId) {
    $stmt = $con->prepare("SELECT * FROM category WHERE id = ?");
    $stmt->bind_param("i", $catId);
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

if ($catId > 0) {
    $catData = getcat($con, $catId);
    if ($catData) {
        $cat = $catData;
    } else {
        $_SESSION['msg'] = "category not found.";
        header('Location: category.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catName = trim($_POST['catName'] ?? '');
    $catName_en = trim($_POST['catName_en'] ?? '');

    // Prevent processing if required fields are missing
    if (empty($catName) || empty($catName_en)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: category.php');
        exit();
    }

    list($valid, $newImageName) = handleImageUpload($_FILES['catImage']);
    if (!$valid) {
        $_SESSION['msg'] = $newImageName;
        header('Location: category.php');
        exit();
    }

    $newImageName = $newImageName ?: $cat['catImage'];

    if ($catId > 0) {
        // Update only if there are changes
        if ($catName !== $cat['catName'] || $catName_en !== $cat['catName_en'] || $newImageName !== $cat['catImage']) {
            $stmt = $con->prepare("UPDATE category SET catName = ?, catName_en = ?, catImage = ? WHERE id = ?");
            $stmt->bind_param("sssi", $catName, $catName_en, $newImageName, $catId);
            $stmt->execute();
            $stmt->close();

            // Move new image if uploaded
            if ($_FILES['catImage']['name']) {
                $dir = "../categoryimages/$catId";
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                move_uploaded_file($_FILES['catImage']['tmp_name'], "$dir/$newImageName");
            }
            $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি।)";
        }
    } else {
        $stmt = $con->prepare("INSERT INTO category (catName, catName_en, catImage) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $catName, $catName_en, $newImageName);
        if ($stmt->execute()) {
            $catId = $stmt->insert_id;
            if ($_FILES['catImage']['name']) {
                $dir = "../categoryimages/$catId";
                if (!is_dir($dir)) mkdir($dir, 0777, true);
                move_uploaded_file($_FILES['catImage']['tmp_name'], "$dir/$newImageName");
            }
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Operation failed.";
        }
        $stmt->close();
    }
    header('Location: category.php');
    exit();
}

if (isset($_GET['del']) && $catId > 0) {
    $cat = getcat($con, $catId);
    if ($cat) {
        $stmt = $con->prepare("DELETE FROM category WHERE id = ?");
        $stmt->bind_param("i", $catId);
        if ($stmt->execute()) {
            $catDir = "../categoryimages/$catId";
            if (is_dir($catDir)) {
                array_map('unlink', glob("$catDir/*"));
                rmdir($catDir);
            }
            $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete cat.";
        }
        $stmt->close();
    } else {
        $_SESSION['delmsg'] = "cat not found. Cannot delete.";
    }
    header('Location: category.php');
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
                                    <li class="list-inline-item">Category (ক্যাটাগরি) </li>
                                 </ul>
                              </div>
							  <button id="submitcat" class="au-btn au-btn-icon au-btn--green"><?php echo $catId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
								
                              <div class="card-header"><?php echo $catId ? 'Update' : 'Add'; ?> Category ( ক্যাটাগরি <?php echo $catId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="catForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
									
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="catName_en" class="control-label mb-1">Category Name ( ক্যাটাগরি নাম )</label>
                                             <input id="catName_en" name="catName_en" type="text" class="form-control catName_en valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="catName_en" aria-required="true" aria-invalid="false" aria-describedby="catName_en-error"
                                                placeholder="Enter category Name" value="<?php echo htmlentities($cat['catName_en']); ?>" required>
                                             <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="catName" class="control-label mb-1">Category Name Bangla ( ক্যাটাগরি নাম বাংলা)</label>
                                          <div class="input-group">
                                             <input id="catName" name="catName" type="text" class="form-control catName valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="catName" aria-required="true" aria-invalid="false" aria-describedby="catName-error"
                                                placeholder="Enter category Name Bangla" value="<?php echo htmlentities($cat['catName']); ?>" required>
                                          </div>
                                       </div>
                                    </div>
									 <?php if ($catId && $cat['catImage']) { ?>
										<div class="form-group">
										<label for="categoryImage" class="control-label mb-1">Current Category Image (বর্তমান ক্যাটাগরি ছবি)</label>
											<div class="controls">
												<img src="../categoryimages/<?php echo htmlentities($catId); ?>/<?php echo htmlentities($cat['catImage']); ?>" width="100" height="100">
											</div>
										</div>
									<?php } ?>
                                    <div class="row">
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="catImage" class="control-label mb-1">Category Image ( ক্যাটাগরি ছবি )</label>
                                             <input type="file" name="catImage" class="form-control-file" id="catImage" required onchange="previewImage(event)">
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
                                            <th>Category <br>( ক্যাটাগরি )</th>
                                            <th>Image <br>( ছবি )</th>
                                            <th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT * FROM category ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['catName_en']).' - '.htmlentities($row['catName']); ?></td>
                                       <td><img src="../categoryimages/<?php echo $row['id']; ?>/<?php echo htmlentities($row['catImage']); ?>" width="100" height="100"></td>
                                       <td><?php echo htmlentities($row['creationDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="category.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="category.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
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
		document.getElementById("submitcat").addEventListener("click", function () {
        document.getElementById("catForm").submit();
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
