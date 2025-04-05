<?php
session_start();

include('../include/config.php');

// Check if user is logged in
if (empty($_SESSION['alogin'])) {
    header('Location: index.php'); // FIXED TYPO: 'Louserion' → 'Location'
    exit();
}

$stockId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stock = ['brSuId' => '', 'catId' => '', 'subCatId'  => '']; // Ensure this contains your DB connection

// Ensure no output before PHP tags
ob_clean();  // Clean (erase) the output buffer if using output buffering
session_write_close();
header('Content-Type: application/json'); // Always set the content type header for JSON

// Check if 'data' is set in POST request before accessing
if (isset($_POST['data'])) {
    $data = $_POST['data'];
} else {
    // Handle case where data is not set (return error message)
    $data = ['status' => 'error', 'message' => 'No data received'];
}

echo json_encode($data); // Your actual JSON output
?>


  

<!DOCTYPE html>
<html lang="en">
   <?php include('share/head.php');?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
	function getSubcat(catId, selectedSubCatId = null, onComplete = null) {
		if (!catId || catId === "0") {
			$("#subcategory").html('<option value="">Select Subcategory</option>');
			if (typeof onComplete === "function") onComplete();
			return;
		}

		$.ajax({
			type: "POST",
			url: "extra/get_subcat.php",
			data: { catId: catId, selectedSubCatId: selectedSubCatId },
			dataType: "html",
			success: function (response) {
				$("#subcategory").html('<option value="">Select - নির্বাচন করুন</option>' + response);

				if (typeof onComplete === "function") {
					onComplete();
				}
			},
			error: function () {
				alert("Failed to load subcategories.");
			}
		});
	}

	function getProducts(brSuId, catId, subCatId) {
		if (!brSuId || !catId || !subCatId || brSuId === "0" || catId === "0" || subCatId === "0") {
			$("#products").html('<option value="">Select Product</option>');
			return;
		}

		$.ajax({
			type: "POST",
			url: "extra/get_products.php",
			data: { brSuId: brSuId, catId: catId, subCatId: subCatId },
			dataType: "html",
			success: function (response) {
				$("#products").html('<option value="">Select - নির্বাচন করুন</option>' + response);
			},
			error: function () {
				alert("Failed to load products.");
			}
		});
	}

	$(document).ready(function () {
		// Pre-selected values for update
		var brSuId = "<?php echo $stock['brSuId'] ?? ''; ?>";
		var catId = "<?php echo $stock['catId'] ?? ''; ?>";
		var subCatId = "<?php echo $stock['subCatId'] ?? ''; ?>";

		// Load subcategories on load if category is set
		if (catId) {
			getSubcat(catId, subCatId, function () {
				if (brSuId && catId && subCatId) {
					getProducts(brSuId, catId, subCatId);
				}
			});
		}

		// Trigger subcategory load when category is changed
		$("#catId").on("change", function () {
			const newCatId = $(this).val();
			getSubcat(newCatId, null, function () {
				const brSuId = $("#brSuId").val();
				const subCatId = $("#subcategory").val();
				if (brSuId && newCatId && subCatId) {
					getProducts(brSuId, newCatId, subCatId);
				}
			});
		});

		// Trigger product load when subcategory changes
		$("#subcategory").on("change", function () {
			const brSuId = $("#brSuId").val();
			const catId = $("#catId").val();
			const subCatId = $(this).val();
			getProducts(brSuId, catId, subCatId);
		});

		// Trigger product load when brand/supplier changes
		$("#brSuId").on("change", function () {
			const brSuId = $(this).val();
			const catId = $("#catId").val();
			const subCatId = $("#subcategory").val();
			getProducts(brSuId, catId, subCatId);
		});
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
                                    <li class="list-inline-item">Stock ( মজুত ) </li>
                                 </ul>
                              </div>
                              <button id="submitStock" class="au-btn au-btn-icon au-btn--green"><?php echo $stockId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
                              <div class="card-header"><?php echo $stockId ? 'Update' : 'Add'; ?> Stock ( মজুত <?php echo $stockId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="stockForm" method="post" enctype="multipart/form-data" novalidate>
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
                                                   $selectedId = $stock['brSuId'] ?? '';
                                                   
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
                                                   $selectedCatId = $stock['catId'] ?? 0;
                                                   
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
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row m-t-30">
                        <div class="col-md-12">
                           <div class="table-responsive m-b-40">
                              <table id="myTable" class="table table-borderless table-data34 order-list">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>Product Name<br>( পণ্যের নাম )</th>
									   <th>Pack Size<br>( প্যাকের আকার )</th>
                                       <th>Qunatity<br>( পরিমাণ )</th>
                                       <th>Pack Quan<br>( প্যাকের পরিমাণ )</th>
                                       <th>Buy Rate <br>( ক্রয় মূল্য  )</th>
                                       <th>Sell Rate <br>( বিক্রয় মূল্য )</th>
                                       <th>Coupon Rate <br>( কুপন মূল্য )</th>
                                       <th>Start Date <br>( শুরুর তারিখ )</th>
                                       <th>End Date <br>( শেষের তারিখ )</th>
                                       <th>After Discount <br>( ছাড়ের পরে )</th>
                                       <th><input type="button" class="btn btn-sm btn-primary " id="addrow" value="+" /></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td> 1 </td>
                                       <td>
                                        <select id="products" name="proId[]" class="form-control products-dropdown" required>
                                            <option value="">Select Products</option>
                                                <!-- Options will be dynamically loaded by JavaScript -->
                                        </select>
                                       </td>
									   <td>
                                          <input type="text" name="packQuan[]"  class="form-control"/>
                                       </td>
									   
                                       <td>
                                          <input type="Number" name="quantity[]"  class="form-control"/>
                                       </td>
                                       
                                       <td>
                                          <select name="packSize[]" class="form-control" aria-label="Default select example">
											<option value="0">Select - নির্বাচন করুন</option>
											<option value="1">প্যাকেট - Packet</option>
											<option value="2">কাটুন - Cuttun</option>
											<option value="3">বস্তা - Sack</option>
										  </select>
                                       </td>
                                       <td><input type="text" name="buyRate[]"  class="form-control"/></td>
                                       <td><input type="text" name="sellRate[]"  class="form-control"/></td>
									   <td><input type="text" name="couponRate[]"  class="form-control"/></td>
									   <td><input type="text" name="startDate[]" class="form-control" /></td>
									   <td><input type="text" name="endDate[]"  class="form-control"/></td>
									   <td><input type="text" name="afterDis[]"  class="form-control"/></td>
                                       <td>&nbsp;</td>
                                    </tr>
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
		$(document).ready(function () {
			let rowIdx = 1;

			// Add new row
			$('#addrow').on('click', function () {
				var newRow = $('#myTable tbody tr:first').clone();

				// Clear inputs
				newRow.find('input, select').each(function () {
					$(this).val('');
				});

				rowIdx++;

				// Update row number
				newRow.find('td:first').text(rowIdx);

				// Add delete button
				newRow.find('td:last').html('<a class="deleteRow btn btn-sm btn-danger text-white" style="cursor:pointer;">×</a>');

				$('#myTable tbody').append(newRow);
			});

			// Delete row
			$('#myTable').on('click', '.deleteRow', function () {
				$(this).closest('tr').remove();

				// Re-index row numbers
				$('#myTable tbody tr').each(function (index) {
					$(this).find('td:first').text(index + 1);
				});

				rowIdx = $('#myTable tbody tr').length;
			});

			// Submit data
			$('#submitStock').addEventListener('click', function () {
    // Collecting the data from the table rows
    let allData = [];
    $('#myTable tbody tr').each(function () {
        let rowData = {
            proId: $(this).find('select[name="proId[]"]').val(),
            packQuan: $(this).find('input[name="packQuan[]"]').val(),
            quantity: $(this).find('input[name="quantity[]"]').val(),
            packSize: $(this).find('select[name="packSize[]"]').val(),
            buyRate: $(this).find('input[name="buyRate[]"]').val(),
            sellRate: $(this).find('input[name="sellRate[]"]').val(),
            couponRate: $(this).find('input[name="couponRate[]"]').val(),
            startDate: $(this).find('input[name="startDate[]"]').val(),
            endDate: $(this).find('input[name="endDate[]"]').val(),
            afterDis: $(this).find('input[name="afterDis[]"]').val()
        };
        allData.push(rowData);
    });

    // Prepare the data to be sent to the server
    let data = {
        brSuId: $("#brSuId").val(),
        catId: $("#catId").val(),
        subCatId: $("#subcategory").val(),
        allData: allData
    };
	
	console.log('data', data);

    // Make the AJAX request
		   $.ajax({
    type: "POST",
    url: "stock.php",
    data: data,
    success: function(response) {
        // Check the response directly in the console for debugging
        console.log("Raw response:", response);
        
        try {
            let jsonResponse = JSON.parse(response); // Parsing JSON response
            if (jsonResponse.status === 'success') {
                alert(jsonResponse.message);
            } else {
                alert(jsonResponse.message);
            }
        } catch (error) {
            console.error("JSON Parse Error: ", error);  // Log error details
            alert("Error parsing JSON response.");
        }
    },
    error: function(xhr, status, error) {
        alert("Error during the request: " + error);
        console.log(error);  // Log any errors that occur during the AJAX request
    }
});

});


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