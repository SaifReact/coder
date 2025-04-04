<?php
   session_start();
   include('../include/config.php');
   
   // Check if user is logged in
   if (empty($_SESSION['alogin'])) {
       header('Location: index.php'); // FIXED TYPO: 'Louserion' → 'Location'
       exit();
   }
   
   $stockId = isset($_GET['id']) ? intval($_GET['id']) : 0;
   $stock = ['brSuId' => '', 'catId' => '', 'subCatId'  => ''];
?>
  

<!DOCTYPE html>
<html lang="en">
   <?php include('share/head.php');?>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
	
        $(document).ready(function () {
		// Injected from PHP
		var brSuId = "<?php echo isset($stock['brSuId']) ? $stock['brSuId'] : ''; ?>";
		var catId = "<?php echo isset($stock['catId']) ? $stock['catId'] : ''; ?>";
		var subCatId = "<?php echo isset($stock['subCatId']) ? $stock['subCatId'] : ''; ?>";
		
		console.log('Pickle data', brSuId, catId, subCatId);
		

		// Load subcategories if catId exists
		if (catId) {
		  getSubcat(catId, subCatId);
		}

		// Load products if all IDs are present
		if (brSuId && catId && subCatId) {
		  getProducts(brSuId, catId, subCatId);
		}
	  });
		
		
		
		
	  function getSubcat(catId, selectedSubCatId = null) {
		  console.log('Pick data', catId);
		if (!catId || catId === "0") {
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
			$("#subcategory").html('<option value="">Select - নির্বাচন করুন</option>' + response);
		  },
		  error: function(jqXHR, textStatus, errorThrown) {
			console.error("AJAX Error (Subcategory):", textStatus, errorThrown, jqXHR.responseText);
			alert("Failed to load subcategories. Try again.");
		  }
		});
	  }

	  function getProducts(brSuId, catId, subCatId) {
		  console.log('Pick data', brSuId, catId, subCatId);
		if (!brSuId || !catId || !subCatId || brSuId === "0" || catId === "0" || subCatId === "0") {
		  $("#products").html('<option value="">Select Product</option>');
		  return;
		}

		$.ajax({
		  type: "POST",
		  url: "extra/get_products.php",
		  data: { brSuId: brSuId, catId: catId, subCatId: subCatId },
		  dataType: "html",
		  success: function(response) {
			$("#products").html('<option value="">Select - নির্বাচন করুন</option>' + response);
		  },
		  error: function(jqXHR, textStatus, errorThrown) {
			console.error("AJAX Error (Products):", textStatus, errorThrown, jqXHR.responseText);
			alert("Failed to load products. Try again.");
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
                                    <li class="list-inline-item">Stock ( মজুত ) </li>
                                 </ul>
                              </div>
                              <button id="submitProduct" class="au-btn au-btn-icon au-btn--green"><?php echo $stockId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
                                       <th>Qunatity<br>( পরিমাণ )</th>
                                       <th>Pack Quan<br>( প্যাকের পরিমাণ )</th>
									   <th>Pack Size<br>( প্যাকের আকার )</th>
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
                                        <select name="proId" id="products" class="form-control" required>
                                            <option value="">Select Products</option>
                                                <!-- Options will be dynamically loaded by JavaScript -->
                                        </select>
                                       </td>
                                       <td>
                                          <input type="Number" name="Number"  class="form-control"/>
                                       </td>
                                       <td>
                                          <input type="text" name="packQuan"  class="form-control"/>
                                       </td>
                                       <td>
                                          <select name="packSize" class="form-control" aria-label="Default select example">
											<option value="0">Select - নির্বাচন করুন</option>
											<option value="1">Packet - প্যাকেট</option>
											<option value="2">Cuttun - কাটুন</option>
											<option value="3">Sack - বস্তা</option>
										  </select>
                                       </td>
                                       <td><input type="text" name="buyRate"  class="form-control"/></td>
                                       <td><input type="text" name="sellRate"  class="form-control"/></td>
									   <td><input type="text" name="couponRate"  class="form-control"/></td>
									   <td><input type='text' class="form-control" id='datetimepicker1' /></td>
									   <td><input type="text" name="endDate"  class="form-control"/></td>
									   <td><input type="text" name="afterDis"  class="form-control"/></td>
                                       <td><a class="deleteRow"></a></td>
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
        var counter = 1; // Start serial number from 1

        $("#addrow").on("click", function () {
            var newRow = $("<tr>");
            var cols = "";

            cols += '<td class="serial">' + counter + '</td>'; // Serial number
            cols += `<td>
                        <select name="catId[]" class="form-control">
                            <option value="0">Select - নির্বাচন করুন</option>
                            <?php 
                                $query = mysqli_query($con, "SELECT * FROM PRODUCTS");
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='" . htmlentities($row['id']) . "'>" 
                                         . htmlentities($row['productName']) . " - " 
                                         . htmlentities($row['productName_bn']) . "</option>";
                                }
                            ?>
                        </select>
                    </td>`;
            cols += '<td><input type="number" name="Number[]" class="form-control" value=""/></td>';
            cols += '<td><input type="text" name="packQuan[]" class="form-control" value=""/></td>';
            cols += `<td>
                        <select name="packSize[]" class="form-control">
                            <option value="0">Select - নির্বাচন করুন</option>
                            <option value="1">Packet - প্যাকেট</option>
                            <option value="2">Cuttun - কাটুন</option>
                            <option value="3">Sack - বস্তা</option>
                        </select>
                    </td>`;
            cols += '<td><input type="text" name="buyRate[]" class="form-control" value=""/></td>';
            cols += '<td><input type="text" name="sellRate[]" class="form-control" value=""/></td>';
            cols += '<td><input type="text" name="couponRate[]" class="form-control" value=""/></td>';
            cols += '<td><input type="text" name="startDate[]" class="form-control" value=""/></td>';
            cols += '<td><input type="text" name="endDate[]" class="form-control" value=""/></td>';
            cols += '<td><input type="text" name="afterDis[]" class="form-control" value=""/></td>';
            cols += '<td><input type="button" class="ibtnDel btn btn-sm btn-danger" value="-"></td>';

            newRow.append(cols);
            $("table.order-list tbody").append(newRow);
            counter++;

            updateSerialNumbers(); // Update serial numbers dynamically
        });

        // Delete row function
        $("table.order-list").on("click", ".ibtnDel", function () {
            $(this).closest("tr").remove();
            counter--;
            updateSerialNumbers(); // Update serial numbers after removing a row
        });

        // Function to update serial numbers
        function updateSerialNumbers() {
            $("table.order-list tbody tr").each(function (index) {
                $(this).find(".serial").text(index + 1); // Reassign serial numbers
            });
        }
    });
</script>

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