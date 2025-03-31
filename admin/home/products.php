<?php
session_start();
include('../include/config.php');

// Check if user is logged in
if (empty($_SESSION['alogin'])) {
    header('Location: index.php'); // FIXED TYPO: 'Louserion' → 'Location'
    exit();
}

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = ['brSuId' => '', 'catId' => '', 'subCatId'  => '', 'productName'  => '', 'productName_bn'  => '', 'productionProcess'  => '', 
'whereFrom'  => '', 'size'  => '', 'color'  => '', 'description'  => '', 'frontImg'  => '', 'backImg'  => '', 'leftImg'  => '', 
'rightImg'  => '', 'status' => ''];

function getProduct($con, $productId) {
    $stmt = $con->prepare("SELECT products.*, districts.id AS did, districts.name AS ename, districts.bn_name AS bname, category.id AS cid, 
	category.catName AS catname, subcategory.id AS subcatid, subcategory.subCatName AS subcatname, subcategory.subCatName_en AS subcatnamen, 
	brands.id AS brandsId, brands.brandsName AS brandsname, brands.brandsName_en AS brandsnamen, color.id as coid, color.colorName as coname, 
	color.colorType as cotype, size.id as sizid, size.sizeName as sizname, size.sizeType as siztype FROM products 
	JOIN category ON category.id = products.catId 
	JOIN subcategory ON subcategory.id = products.subCatId 
	JOIN brands ON brands.id = products.brSuId 
	JOIN districts ON districts.id = products.whereFrom 
	JOIN color ON color.colorType = products.color 
	JOIN size ON size.sizeType = products.size 
	WHERE products.id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc() ?: null;
}

if ($productId > 0) {
    $productData = getProduct($con, $productId);
    if ($productData) {
        $product = $productData;
    } else {
        $_SESSION['msg'] = "Product Not Found.";
        header('Location: products.php');
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
        return [true, uniqid("pro_", true) . '.' . $imageExtension];
    }
    return [true, null];
}


function getPrefixNo($con) {
    $prefix = "PRO-"; 
    $brSuId = trim($_POST['brSuId'] ?? '');
    $catId = trim($_POST['catId'] ?? '');
    $subCatId = trim($_POST['subCatId'] ?? '');

    // Fetch the last supplier number from the database
    $stmt = $con->prepare("SELECT proCode FROM products ORDER BY id DESC LIMIT 1"); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $lastNumber = str_replace($prefix, '', $row['proCode']); // Remove prefix
        $numericPart = intval(preg_replace('/\D/', '', $lastNumber)); // Extract numeric part
    } else {
        $numericPart = 11110; // Default starting number
    }

    $stmt->close(); // Close statement after fetching data

    $newNumber = $numericPart + 1; // Increment the number
    return $prefix . $brSuId . $catId . $subCatId . $newNumber;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$brSuId = trim($_POST['brSuId'] ?? '');
    $catId = trim($_POST['catId'] ?? '');
    $subCatId = trim($_POST['subCatId'] ?? '');
    $productName = trim($_POST['productName'] ?? '');
    $productName_bn = trim($_POST['productName_bn'] ?? '');
    $productionProcess = trim($_POST['productionProcess'] ?? '');
    $whereFrom = trim($_POST['whereFrom'] ?? '');
    $size = trim($_POST['size'] ?? '');
    $color = trim($_POST['color'] ?? '');
    $description = trim($_POST['description'] ?? '');
	$status = trim($_POST['status'] ?? 'A');
	
	// Prevent processing if required fields are missing
    if (empty($productName) || empty($productName_bn)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: products.php');
        exit();
    }
	
	// Handle image uploads
    list($frontValid, $newFrontImageName) = handleImageUpload($_FILES['frontImg']);
    list($backValid, $newBackImageName) = handleImageUpload($_FILES['backImg']);
	list($leftValid, $newLeftImageName) = handleImageUpload($_FILES['leftImg']);
    list($rightValid, $newRightImageName) = handleImageUpload($_FILES['rightImg']);
	
	// If either image upload fails, set appropriate message and exit
    // If any image upload fails, set the appropriate message and exit
	if (!$frontValid || !$backValid || !$leftValid || !$rightValid) {
		$_SESSION['msg'] = !$frontValid ? $newFrontImageName : 
						  (!$backValid ? $newBackImageName : 
						  (!$leftValid ? $newLeftImageName : $newRightImageName));
		header('Location: products.php');
		exit();
	}
	
	// Use existing image names if no new images are uploaded
    $newFrontImageName = $newFrontImageName ?: $product['frontImg'];
    $newBackImageName = $newBackImageName ?: $product['backImg'];
	$newLeftImageName = $newLeftImageName ?: $product['leftImg'];
	$newRightImageName = $newRightImageName ?: $product['rightImg'];
	
	if ($productId > 0) {
		
		$prefixNo = getPrefixNo($con);
        // Prepare SQL update statement
        $sql = "UPDATE products SET 
            proCode =?, brSuId =?, catId =?, subCatId  =?, productName  =?, productName_bn  =?, productionProcess  =?, whereFrom  =?, 
			size  =?, color  =?, description  =?, frontImg  =?, backImg  =?, leftImg  =?, rightImg  =?, status =?
			WHERE id = ?";

		// Prepare statement
		$stmt = $con->prepare($sql);
		if (!$stmt) {
			die("Prepare failed: " . $con->error);
		}

		// Bind parameters
		$stmt->bind_param("sssssssssssi", $prefixNo, $brSuId, $catId, $subCatId, $productName, $productName_bn, $productionProcess, $whereFrom, 
		$size, $color, $description, $newFrontImageName, $newBackImageName, $newLeftImageName, $newRightImageName, $status, $productId);

		// Execute
		// $stmt->execute();
		
		 // Execute and close
        if ($stmt->execute()) {
            // Move the uploaded images if they exist
            $productDir = "../products/$productId";
            if (!is_dir($productDir)) mkdir($productDir, 0777, true);

            if (!empty($_FILES['frontImg']['name'])) {
                move_uploaded_file($_FILES['frontImg']['tmp_name'], "$productDir/$newFrontImageName");
            }

            if (!empty($_FILES['backImg']['name'])) {
                move_uploaded_file($_FILES['backImg']['tmp_name'], "$productDir/$newBackImageName");
            }
			
			if (!empty($_FILES['leftImg']['name'])) {
                move_uploaded_file($_FILES['leftImg']['tmp_name'], "$productDir/$newLeftImageName");
            }
			
			if (!empty($_FILES['rightImg']['name'])) {
                move_uploaded_file($_FILES['rightImg']['tmp_name'], "$productDir/$newRightImageName");
            }
			
        } else {
            $_SESSION['warnmsg'] = "Update failed: " . $stmt->error;
        }

		// Check for MySQL errors
		if ($stmt->error) {
			die("MySQL Error: " . $stmt->error);
		}

		// Check affected rows
		if ($stmt->affected_rows === 0) {
			$_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
		}
		
		$stmt->close();

		$_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";

    } else {
        // Get prefix number for insertion
        $prefixNo = getPrefixNo($con);

        // Prepare SQL insert statement
        $sql = "INSERT INTO products (proCode, brSuId, catId, subCatId, productName, productName_bn, productionProcess, whereFrom, 
			size, color, description, frontImg, backImg, leftImg, rightImg, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare and execute statement
        $stmt = $con->prepare($sql);
		$stmt->bind_param("ssssssssssssssss", $prefixNo, $brSuId, $catId, $subCatId, $productName, $productName_bn, $productionProcess, $whereFrom, 
		$size, $color, $description, $newFrontImageName, $newBackImageName, $newLeftImageName, $newRightImageName, $status,);

        if ($stmt->execute()) {
            $productId = $stmt->insert_id;
			$dir = "../product/$productId";
            if (!is_dir($dir)) mkdir($dir, 0777, true);
			
            if (!empty($_FILES['frontImg']['name'])) {
                move_uploaded_file($_FILES['frontImg']['tmp_name'], "$dir/$newFrontImageName");
            }
			if (!empty($_FILES['backImg']['name'])) {
                move_uploaded_file($_FILES['backImg']['tmp_name'], "$dir/$newBackImageName");
            }
			if (!empty($_FILES['leftImg']['name'])) {
                move_uploaded_file($_FILES['leftImg']['tmp_name'], "$dir/$newLeftImageName");
            }
			if (!empty($_FILES['rightImg']['name'])) {
                move_uploaded_file($_FILES['rightImg']['tmp_name'], "$dir/$newRightImageName");
            }
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Operation failed.";
        }
        $stmt->close();
    }

	header('Location: products.php');
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

		console.log("Sending catId:", catId); // Debugging

		$.ajax({
			type: "POST",
			url: "extra/get_subcat.php",
			data: { catId: catId }, // Ensure it's being sent
			dataType: "html", // Expected response format
			success: function(response) {
				console.log("Response received:", response); // Debugging
				$("#subcategory").html(response);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
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
							  <button id="submitProduct" class="au-btn au-btn-icon au-btn--green"><?php echo $productId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
															 . htmlentities($row['name_bn']) . " - " 
															 . htmlentities($row['name']) . "</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="catId" class="form-control-label">Category ( ক্যাটাগরি )</label>
												<select name="catId" id="catId" class="form-control" onChange="getSubcat(this.value);">
													<option value="0">Please Select - নির্বাচন করুন</option>
													<?php 
													$query = mysqli_query($con, "SELECT * FROM CATEGORY");
													while ($row = mysqli_fetch_array($query)) {
														echo "<option value='" . htmlentities($row['id']) . "'>" 
															 . htmlentities($row['catName']) . " - " 
															 . htmlentities($row['catName_en']) . "</option>";
													}
													?>
												</select>
											</div>
										</div>

										<div class="col-6">
											<div class="form-group">
												<label class="form-control-label" for="subCatId">Sub Category ( সাব ক্যাটাগরি )</label>
												<select name="subCatId" id="subcategory" class="form-control" required>
													<option value="">Select Subcategory</option>
												</select>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<label class="form-control-label" for="productName">Product Name ( পণ্যের নাম )</label>
												<input type="text" name="productName"  placeholder="Enter Product Name" class="form-control productName valid" required>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<label class="form-control-label" for="productName_bn">Product Name Bangla ( পণ্যের নাম বাংলায় )</label>
												<input type="text" name="productName_bn"  placeholder="Enter Product Name Bangla" class="form-control productName_bn valid" required>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<label class="form-control-label" for="productionProcess">Production Process ( উৎপাদন প্রক্রিয়া )</label>
												<input type="text" name="productionProcess"  placeholder="Enter Production Process" class="form-control productionProcess valid" required>
											</div>
										</div>

										<div class="col-6">
											<div class="form-group">
												<label for="whereFrom" class="form-control-label">Where From ( কোথা থেকে )</label>
												<select name="whereFrom" id="whereFrom" class="form-control">
													<option value="0">Please Select - নির্বাচন করুন</option>
													<?php 
													$query = mysqli_query($con, "SELECT * FROM DISTRICTS");
													while ($row = mysqli_fetch_array($query)) {
														echo "<option value='" . htmlentities($row['id']) . "'>" 
															 . htmlentities($row['bn_name']) . " - " 
															 . htmlentities($row['name']) . "</option>";
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<label for="size" class="form-control-label">Size ( পণ্যের আকার )</label>
												<select name="size" id="size" class="form-control">
													<option value="0">Please Select - নির্বাচন করুন</option>
													<?php 
													$query = mysqli_query($con, "SELECT * FROM SIZE");
													while ($row = mysqli_fetch_array($query)) {
														echo "<option value='" . htmlentities($row['sizeType']) . "'>" 
															 . htmlentities($row['sizeName']) . "</option>";
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<label for="color" class="form-control-label">Color ( পণ্যের রঙ )</label>
												<select name="color" id="color" class="form-control">
													<option value="0">Please Select - নির্বাচন করুন</option>
													<?php 
													$query = mysqli_query($con, "SELECT * FROM COLOR");
													while ($row = mysqli_fetch_array($query)) {
														echo "<option value='" . htmlentities($row['colorType']) . "'>" 
															 . htmlentities($row['colorName']) . "</option>";
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-12">
                                          <div class="form-group">
                                             <label for="discription" class="form-control-label">Description ( বর্ণনা )</label>
											 <textarea name="discription" id="discription" rows="5" placeholder="Content..." class="form-control"></textarea>
                                          </div>
                                       </div>
									   
									   <div class="col-6">
                                          <div class="form-group">
                                             <label for="frontImg" class="form-control-label">Front Image ( সামনের ছবি )</label>
											 <br/>
                                             <input type="file" name="frontImg" multiple onchange="previewImages(event, 'frontPreviewContainer')" />
											 <div id="frontPreviewContainer" style="display: flex; flex-wrap: wrap;"></div>	
                                          </div>
                                       </div>
									   
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="backImg" class="form-control-label">Back Image ( পিছনের ছবি )</label>
											 <br/>
                                             <input type="file" name="backImg" multiple onchange="previewImages(event, 'backPreviewContainer')" />
											 <div id="backPreviewContainer" style="display: flex; flex-wrap: wrap;"></div>	
                                          </div>
                                       </div>
									   
									   <div class="col-6">
                                          <div class="form-group">
                                             <label for="leftImg" class="form-control-label">Left Image ( বাম ছবি )</label>
											 <br/>
                                             <input type="file" name="leftImg" multiple onchange="previewImages(event, 'leftPreviewContainer')" />
											 <div id="leftPreviewContainer" style="display: flex; flex-wrap: wrap;"></div>	
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="rightImg" class="form-control-label">Right Image ( ডান ছবি )</label>
											 <br/>
                                             <input type="file" name="rightImg" multiple onchange="previewImages(event, 'rightPreviewContainer')" />
											 <div id="rightPreviewContainer" style="display: flex; flex-wrap: wrap;"></div>	
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
			document.getElementById("submitProduct").addEventListener("click", function () {
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
