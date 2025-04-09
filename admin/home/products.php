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
	category.catName AS catname, category.catName_en AS catnamen, subcategory.id AS subcatid, subcategory.subCatName AS subcatname, subcategory.subCatName_en AS subcatnamen, 
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

    // Fetch the last product code
    $stmt = $con->prepare("SELECT proCode FROM products WHERE proCode LIKE ? ORDER BY id DESC LIMIT 1"); 
    $searchPattern = $prefix . $brSuId . $catId . $subCatId . "%";
    $stmt->bind_param("s", $searchPattern);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Extract last numeric part
        preg_match('/(\d+)$/', $row['proCode'], $matches);
        $numericPart = isset($matches[1]) ? intval($matches[1]) : 11110;
    } else {
        $numericPart = 11110; // Default starting number
    }

    $stmt->close(); // Close statement

    // Generate new code
    $newNumber = $numericPart + 1;
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
		$stmt->bind_param("ssssssssssssssssi", 
			  $prefixNo, $brSuId, $catId, $subCatId, $productName, $productName_bn,
			  $productionProcess, $whereFrom, $size, $color, $description,
			  $newFrontImageName, $newBackImageName, $newLeftImageName, $newRightImageName,
			  $status, $productId);
		
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

if (isset($_GET['del']) && $productId > 0) {
    $product = getProduct($con, $productId);
    if ($product) {
        $stmt = $con->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        if ($stmt->execute()) {
            $productDir = "../product/$productId";
            if (is_dir($productDir)) {
                array_map('unlink', glob("$productDir/*"));
                rmdir($productDir);
            }
            $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete Product.";
        }
        $stmt->close();
    } else {
        $_SESSION['delmsg'] = "Product not found. Cannot delete.";
    }
    header('Location: products.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
   <?php include('share/head.php');?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		function getSubcat(catId, selectedSubCatId = null) {
			if (!catId || catId == 0) {
				$("#subcategory").html('<option value="">Select Subcategory</option>');
				return;
			}

			$.ajax({
				type: "POST",
				url: "extra/get_subcat.php",
				data: {
					catId: catId,
					selectedSubCatId: selectedSubCatId
				},
				dataType: "html",
				success: function(response) {
					$("#subcategory").html('<option value="">Select Subcategory</option>' + response);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
					alert("Failed to load subcategories. Try again.");
				}
			});
		}

		$(document).ready(function () {
			// Injected from PHP
			var catId = "<?php echo isset($product['catId']) ? $product['catId'] : ''; ?>";
			var subCatId = "<?php echo isset($product['subCatId']) ? $product['subCatId'] : ''; ?>";

			if (catId) {
				getSubcat(catId, subCatId);
			}
		});
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
							  <button class="au-btn au-btn-icon au-btn--blue"><a href="csv_upload.php" style="color:#FFF">CSV File Upload (সিএসভি ফাইল আপলোড)</a></button>
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
													<option value="0">Please Select - নির্বাচন করুন</option>
													<?php 
													$selectedId = $product['brSuId'] ?? 0;

													$query = mysqli_query($con, "
														SELECT id, brandsName_en AS name, brandsName AS name_bn FROM brands
														UNION
														SELECT forId AS id, userName AS name, CONCAT(userName_bn, ' (', compName, ')') AS name_bn 
														FROM cusupdeli 
														WHERE forwarding = 'sup' AND status = 'A'
													");

													while ($row = mysqli_fetch_assoc($query)) {
														$isSelected = ($row['id'] == $selectedId) ? 'selected' : '';
														echo "<option value='" . htmlentities($row['id']) . "' $isSelected>" 
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
													$selectedCatId = $product['catId'] ?? 0;

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
												<label class="form-control-label" for="subCatId">
													Sub Category ( সাব ক্যাটাগরি )
												</label>
												<select name="subCatId" id="subcategory" class="form-control" required>
													<option value="">Select Subcategory</option>
													<!-- Options will be dynamically loaded by JavaScript -->
												</select>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<label class="form-control-label" for="productName">Product Name ( পণ্যের নাম )</label>
												<input type="text" name="productName"  placeholder="Enter Product Name" class="form-control productName valid" value="<?php echo htmlentities($product['productName']); ?>" required>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<label class="form-control-label" for="productName_bn">Product Name Bangla ( পণ্যের নাম বাংলায় )</label>
												<input type="text" name="productName_bn"  placeholder="Enter Product Name Bangla" class="form-control productName_bn valid" value="<?php echo htmlentities($product['productName_bn']); ?>" required>
											</div>
										</div>
										
										<div class="col-6">
											<div class="form-group">
												<label class="form-control-label" for="productionProcess">Production Process ( উৎপাদন প্রক্রিয়া )</label>
												<input type="text" name="productionProcess"  placeholder="Enter Production Process" class="form-control productionProcess valid" value="<?php echo htmlentities($product['productionProcess']); ?>"required>
											</div>
										</div>
										
										<!--<?php
										echo "<pre>";
										var_dump($product);
										echo "</pre>"; ?>-->

										<div class="col-6">
											<div class="form-group">
												<label for="whereFrom" class="form-control-label">Where From ( কোথা থেকে )</label>
												<select name="whereFrom" id="whereFrom" class="form-control">
													<option value="0">Please Select - নির্বাচন করুন</option>
													<?php 
													$selectedDistrictId = $product['whereFrom'] ?? 0;

													$query = mysqli_query($con, "SELECT * FROM DISTRICTS");

													while ($row = mysqli_fetch_array($query)) {
														$isSelected = ($row['id'] == $selectedDistrictId) ? 'selected' : '';
														echo "<option value='" . htmlentities($row['id']) . "' $isSelected>" 
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
													$selectedSize = $product['siztype'] ?? '';

													$query = mysqli_query($con, "SELECT * FROM size");

													while ($row = mysqli_fetch_array($query)) {
														$isSelected = ($row['sizeType'] == $selectedSize) ? 'selected' : '';
														echo "<option value='" . htmlentities($row['sizeType']) . "' $isSelected>" 
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
													$selectedColor = $product['cotype'] ?? '';

													$query = mysqli_query($con, "SELECT * FROM COLOR");

													while ($row = mysqli_fetch_array($query)) {
														$isSelected = ($row['colorType'] == $selectedColor) ? 'selected' : '';
														echo "<option value='" . htmlentities($row['colorType']) . "' $isSelected>" 
															 . htmlentities($row['colorName']) . "</option>";
													}
													?>
												</select>
											</div>
										</div>

										<div class="col-12">
                                          <div class="form-group">
                                             <label for="discription" class="form-control-label">Description ( বর্ণনা )</label>
											 <textarea name="discription" id="discription" rows="5" placeholder="Content..." class="form-control"><?php echo htmlentities($product['discription'] ?? ''); ?></textarea>
                                          </div>
                                       </div>
									   
									   
                                        <?php if ($productId && $product['frontImg'] && $product['backImg']) { ?>
										<div class="col-6">
											<div class="form-group">
											<label for="logo" class="control-label mb-1">Current Front Image ( বর্তমান সামনের ছবি )</label>
												<div class="controls">
													<img src="../product/<?php echo htmlentities($productId); ?>/<?php echo htmlentities($product['frontImg']); ?>" width="100" height="100">
												</div>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
											<label for="logo" class="control-label mb-1">Current Back Image ( বর্তমান পিছনের ছবি )</label>
												<div class="controls">
													<img src="../product/<?php echo htmlentities($productId); ?>/<?php echo htmlentities($product['backImg']); ?>" width="100" height="100">
												</div>
											</div>
										</div>
										<?php } ?>
									   
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
									   
									   <?php if ($productId && $product['leftImg'] && $product['rightImg']) { ?>
										<div class="col-6">
											<div class="form-group">
											<label for="logo" class="control-label mb-1">Current Front Image ( বর্তমান বামের ছবি )</label>
												<div class="controls">
													<img src="../product/<?php echo htmlentities($productId); ?>/<?php echo htmlentities($product['leftImg']); ?>" width="100" height="100">
												</div>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
											<label for="logo" class="control-label mb-1">Current Back Image ( বর্তমান ডানের ছবি )</label>
												<div class="controls">
													<img src="../product/<?php echo htmlentities($productId); ?>/<?php echo htmlentities($product['rightImg']); ?>" width="100" height="100">
												</div>
											</div>
										</div>
										<?php } ?>
									   
									   <div class="col-6">
                                          <div class="form-group">
                                             <label for="leftImg" class="form-control-label">Left Image ( বামের ছবি )</label>
											 <br/>
                                             <input type="file" name="leftImg" multiple onchange="previewImages(event, 'leftPreviewContainer')" />
											 <div id="leftPreviewContainer" style="display: flex; flex-wrap: wrap;"></div>	
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="rightImg" class="form-control-label">Right Image ( ডানের ছবি )</label>
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
											<th>Brands Name<br>( ব্র্যান্ডস নাম )</th>
											<th>Category Name<br>( ক্যাটাগরি নাম )</th>
											<th>Sub Category Name <br>( সাব ক্যাটাগরি নাম )</th>
											<th>Front Image <br>( সামনের ছবি )</th>
											<th>Back Image <br>( পিছনের ছবি )</th>
											<th>Left Image <br>( বামের ছবি )</th>
											<th>Right Image <br>( ডানের ছবি )</th>
											<th>Status <br>( অবস্থা )</th>
                                            <th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT products.*, districts.id AS did, districts.name AS ename, districts.bn_name AS bname, category.id AS cid, 
															category.catName AS catname, subcategory.id AS subcatid, subcategory.subCatName AS subcatname, subcategory.subCatName_en AS subcatnamen, 
															brands.id AS brandsId, brands.brandsName AS brandsname, brands.brandsName_en AS brandsnamen, color.id as coid, color.colorName as coname, 
															color.colorType as cotype, size.id as sizid, size.sizeName as sizname, size.sizeType as siztype FROM products 
															JOIN category ON category.id = products.catId 
															JOIN subcategory ON subcategory.id = products.subCatId 
															JOIN brands ON brands.id = products.brSuId 
															JOIN districts ON districts.id = products.whereFrom 
															JOIN color ON color.colorType = products.color 
															JOIN size ON size.sizeType = products.size ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['proCode']); ?></td>
									   <td><?php echo htmlentities($row['productName']).' - '.htmlentities($row['productName_bn']); ?></td>
									   <td><?php echo htmlentities($row['brandsname']); ?></td>
									   <td><?php echo htmlentities($row['catname']); ?></td>
									   <td><?php echo htmlentities($row['subcatname']); ?></td>
									   <td><img src="../product/<?php echo $row['id']; ?>/<?php echo htmlentities($row['frontImg']); ?>" width="100" height="100"></td>
									   <td><img src="../product/<?php echo $row['id']; ?>/<?php echo htmlentities($row['backImg']); ?>" width="100" height="100"></td>
									   <td><img src="../product/<?php echo $row['id']; ?>/<?php echo htmlentities($row['leftImg']); ?>" width="100" height="100"></td>
									   <td><img src="../product/<?php echo $row['id']; ?>/<?php echo htmlentities($row['rightImg']); ?>" width="100" height="100"></td>
									   <td><?php echo htmlentities($row['status'] == 'A') ? 'Active (সক্রিয়)' : 'Inactive (নিষ্ক্রিয়)'; ?></td>									   
									   <td><?php echo htmlentities($row['postingDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="products.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="products.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
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
