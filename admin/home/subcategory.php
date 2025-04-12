<?php
session_start();
include('../../includes/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

// Get the subcategory ID from GET request
$subCatId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$subCat = ['catId' => '', 'catName' => '', 'catName_en' => '', 'subCatName' => '', 'subCatName_en' => ''];

// Function to fetch subcategory details
function getSubCat($con, $subCatId) {
    $stmt = $con->prepare("SELECT sc.*, ca.catName, ca.catName_en 
                           FROM subcategory sc 
                           JOIN category ca ON ca.id = sc.catId 
                           WHERE sc.id = ?");
    $stmt->bind_param("i", $subCatId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc() ?: null;
}

// Fetch subcategory details if an ID is provided
if ($subCatId > 0) {
    $subCatData = getSubCat($con, $subCatId);
    if ($subCatData) {
        $subCat = $subCatData;
    } else {
        $_SESSION['msg'] = "Category not found.";
        header('Location: subcategory.php');
        exit();
    }
}

// Handle form submission (Add/Update Subcategory)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = trim($_POST['category'] ?? '');
    $subCatName = trim($_POST['subCatName'] ?? '');
    $subCatName_en = trim($_POST['subCatName_en'] ?? '');

    // Validate input
    if (empty($category) || empty($subCatName) || empty($subCatName_en)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: subcategory.php');
        exit();
    }

    if ($subCatId > 0) {
        // Update subcategory if there are changes
        if ($category !== $subCat['catId'] || $subCatName !== $subCat['subCatName'] || $subCatName_en !== $subCat['subCatName_en']) {
            $stmt = $con->prepare("UPDATE subcategory SET catId = ?, subCatName = ?, subCatName_en = ? WHERE id = ?");
            $stmt->bind_param("issi", $category, $subCatName, $subCatName_en, $subCatId);
            if ($stmt->execute()) {
                $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
            } else {
                $_SESSION['warnmsg'] = "Database error: Update failed.";
            }
            $stmt->close();
        } else {
            $_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
        }
    } else {
        // Insert new subcategory
        $stmt = $con->prepare("INSERT INTO subcategory (catId, subCatName, subCatName_en) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $category, $subCatName, $subCatName_en);
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Insert failed.";
        }
        $stmt->close();
    }
    header('Location: subcategory.php');
    exit();
}

// Handle Delete Request
if (isset($_GET['del']) && $subCatId > 0) {
    $subCat = getSubCat($con, $subCatId);
    if ($subCat) {
        $stmt = $con->prepare("DELETE FROM subcategory WHERE id = ?");
        $stmt->bind_param("i", $subCatId);
        if ($stmt->execute()) {            
            $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete category.";
        }
        $stmt->close();
    } else {
        $_SESSION['delmsg'] = "Category not found. Cannot delete.";
    }
    header('Location: subcategory.php');
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
                                    <li class="list-inline-item">Sub Category (উপ ক্যাটাগরি) </li>
                                 </ul>
                              </div>
							  <button id="submitSubCat" class="au-btn au-btn-icon au-btn--green"><?php echo $subCatId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
								
                              <div class="card-header"><?php echo $subCatId ? 'Update' : 'Add'; ?> Sub Category ( উপ ক্যাটাগরি <?php echo $subCatId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="subCatForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
									
									<div class="col-12">
											<div class="form-group">
												<label for="category" class="form-control-label">Category ( ক্যাটাগরি )</label>
												<select name="category" id="category" class="form-control" onChange="getSubcat(this.value);">
													<option value="0">Please Select - নির্বাচন করুন</option>
													<?php 
													$selectedCatId = $subCat['catId'] ?? 0;

													$query = mysqli_query($con, "SELECT * FROM CATEGORY");

													while ($row = mysqli_fetch_array($query)) {
														$isSelected = ($row['id'] == $selectedCatId) ? 'selected' : '';
														echo "<option value='" . htmlentities($row['id']) . "' $isSelected>" 
															 . htmlentities($row['catName']) . " - " 
															 . htmlentities($row['catName_en']) . "</option>";
													}
													?>
												</select>
											</div>
										</div>

                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="subCatName_en" class="control-label mb-1">Category Name ( উপ ক্যাটাগরি নাম )</label>
                                             <input id="subCatName_en" name="subCatName_en" type="text" class="form-control subCatName_en valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="subCatName_en" aria-required="true" aria-invalid="false" aria-describedby="subCatName_en-error"
                                                placeholder="Enter Sub Category Name" value="<?php echo htmlentities($subCat['subCatName_en']); ?>" required>
                                             <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="subCatName" class="control-label mb-1">Category Name Bangla ( উপ ক্যাটাগরি নাম বাংলা)</label>
                                          <div class="input-group">
                                             <input id="subCatName" name="subCatName" type="text" class="form-control subCatName valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="subCatName" aria-required="true" aria-invalid="false" aria-describedby="subCatName-error"
                                                placeholder="Enter Sub Category Name Bangla" value="<?php echo htmlentities($subCat['subCatName']); ?>" required>
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
                                            <th>Category <br>( ক্যাটাগরি )</th>
											<th>Sub Category <br>( উপ ক্যাটাগরি )</th>
                                            <th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT sc.*, ca.catName, ca.catName_en FROM subcategory sc, category ca where ca.id = sc.catId ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['catName']).' - '.htmlentities($row['catName_en']); ?></td>
									   <td><?php echo htmlentities($row['subCatName_en']).' - '.htmlentities($row['subCatName']); ?></td>
                                       <td><?php echo htmlentities($row['creationDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="subcategory.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="subcategory.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
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
		document.getElementById("submitSubCat").addEventListener("click", function () {
        document.getElementById("subCatForm").submit();
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
