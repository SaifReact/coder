<?php
session_start();
include('../include/config.php');

// Check if user is logged in
if (empty($_SESSION['alogin'])) {
    header('Location: index.php'); // FIXED TYPO: 'Louserion' → 'Location'
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
   <?php include('share/head.php');?>
    <script>
	function getSubcat(catId) {
		if (catId == 0) {
			$("#subcategory").html('<option value="">Select Subcategory</option>');
			return;
		}

		$.ajax({
			type: "POST",
			url: "/extra/get_subcat.php",
			data: { catId: catId }, // Use object notation
			success: function(response) {
				$("#subcategory").html(response);
			},
			error: function() {
				alert("Failed to load subcategories. Try again.");
			}
		});
	}
	</script>
	
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
                                    <li class="list-inline-item">Product ( পণ্য ) </li>
                                 </ul>
                              </div>
							  <button id="submitproduct" class="au-btn au-btn-icon au-btn--green"><?php echo $productId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
                              <div class="card-header"><?php echo $productId ? 'Update' : 'Add'; ?> Product ( পণ্য <?php echo $productId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                               <form id="productForm" method="post" enctype="multipart/form-data" novalidate>
									<div class="row">
										<!-- product Category -->
										<div class="col-12">
											<div class="form-group">
												<label for="brSuId" class="form-control-label">
													Brands / Supplier ( ব্র্যান্ড / সরবরাহকারী )
												</label>
												<select name="brSuId" id="brSuId" class="form-control">
													<!--<?php if (!empty($product['id'])) { ?>
														<option value="<?php echo htmlentities($product['id']); ?>"> 
															<?php echo htmlentities($product['name']).' - '.htmlentities($product['name_bn']); ?>
														</option>
													<?php } else { ?>
														<option value="0"> Please Select - নির্বাচন করুন</option>
													<?php } ?>-->
													<option value="0"> Please Select - নির্বাচন করুন</option>
													<?php 
													$query = mysqli_query($con, "SELECT id, brandsName_en AS name, brandsName AS name_bn FROM brands 
															UNION 
															SELECT forId AS id, userName AS name, CONCAT(userName_bn, ' (', compName, ')') AS name_bn 
															FROM cusupdeli 
															WHERE forwarding = 'sup' AND status = 'A'");
													while ($row = mysqli_fetch_assoc($query)) {
														echo "<option value='" . htmlentities($row['id']) . "'>" 
															 . htmlentities($row['name']) . " - " 
															 . htmlentities($row['name_bn']) . "</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="catId" class="form-control-label">
													Category ( ক্যাটাগরি )
												</label>
												<select name="catId" id="catId" class="form-control" onChange="getSubcat(this.value);">
													<option value="0">Please Select - নির্বাচন করুন</option>
													<?php 
													$query = mysqli_query($con, "SELECT * FROM category");
													while ($row = mysqli_fetch_array($query)) {
														echo '<option value="' . htmlentities($row['id']) . '">' . htmlentities($row['catName']) . '</option>';
													}
													?>
												</select>
											</div>
										</div>

										<div class="col-6">
											<div class="form-group">
												<label class="form-control-label" for="subcategory">Sub Category ( সাব ক্যাটাগরি )</label>
												<select name="subcategory" id="subcategory" class="form-control" required>
													<option value="">Select Subcategory</option>
												</select>
											</div>
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
            <!-- STATISTIC-->
            <?php include('share/footer.php');?>
            <!-- END PAGE CONTAINER-->
         </div>
      </div>
      <?php include('share/js.php');?>
		
	    <script>
			document.getElementById("submitproduct").addEventListener("click", function () {
			document.getElementById("productForm").submit();
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
