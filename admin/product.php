<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit();
}

if (isset($_POST['submit'])) {
    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
	$brand = sanitizeInput($_POST['brands']);
    $category = sanitizeInput($_POST['category']);
    $subcat = sanitizeInput($_POST['subcategory']);
    $productname = sanitizeInput($_POST['productName']);
    $productionprocess = sanitizeInput($_POST['productionProcess']);
    $wherefrom = sanitizeInput($_POST['whereFrom']);
    $size = sanitizeInput($_POST['size']);
    $color = sanitizeInput($_POST['color']);
    $productprice = sanitizeInput($_POST['productprice']);
    $productpricebd = sanitizeInput($_POST['productpricebd']);
    $priceoff = sanitizeInput($_POST['priceoff']);
    $cashback = sanitizeInput($_POST['cashback']);
    $description = sanitizeInput($_POST['productDescription']);
    $productscharge = sanitizeInput($_POST['productShippingcharge']);
    $availability = sanitizeInput($_POST['productAvailability']);

    $query = mysqli_query($con, "SELECT MAX(id) AS pid FROM products");
    $result = mysqli_fetch_array($query);
    $productid = $result['pid'] + 1;

    $dir = "productimages/$productid";
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $uploaded_images = [];
    
    for ($i = 1; $i <= 3; $i++) {
        $fileInput = "productimage" . $i;
        if (!empty($_FILES[$fileInput]['name'])) {
            $fileName = basename($_FILES[$fileInput]["name"]);
            $fileTmpName = $_FILES[$fileInput]["tmp_name"];
            $fileSize = $_FILES[$fileInput]["size"];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExt, $allowed_types) && $fileSize <= 5000000) {
                $filePath = "$dir/$fileName";
                if (move_uploaded_file($fileTmpName, $filePath)) {
                    $uploaded_images[] = $fileName;
                } else {
                    $_SESSION['error'] = "Failed to upload image $i";
                }
            } else {
                $_SESSION['error'] = "Invalid file format or size for image $i";
            }
        } else {
            $uploaded_images[] = null;
        }
    }

    list($productimage1, $productimage2, $productimage3) = $uploaded_images;

    // Prepare statement with error checking
    $stmt = $con->prepare("INSERT INTO products  
		(id, brand, category, subCategory, productName, productionProcess, whereFrom, size, color, productPrice, priceOffPercent, priceAfterDiscount,
			cashback, description, shippingCharge, availability, productImage1, productImage2, productImage3)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("issssssssssssssssss", 
        $productid, $brand, $category, $subcat, $productname, $productionprocess, $wherefrom, 
        $size, $color, $productprice, $priceoff, $productpricebd, $cashback, $description, $productscharge, 
        $availability, $productimage1, $productimage2, $productimage3        
    );

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Product Inserted Successfully!";
    } else {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    header("Location: manage-products.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include('include/head.php');?>
      <script>
         function getSubcat(val) {
         	$.ajax({
         	type: "POST",
         	url: "get_subcat.php",
         	data:'cat_id='+val,
         	success: function(data){
         		$("#subcategory").html(data);
         	}
         	});
         }
         function selectCountry(val) {
         $("#search-box").val(val);
         $("#suggesstion-box").hide();
         }
      </script>	
      <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script type="text/javascript">
         function sum() {
             var price = document.getElementById('productprice').value;
             var discount = document.getElementById('priceoff').value;
             var result = parseInt(price) * (parseInt(discount)/100);
         if (!isNaN(result)) {
                 document.getElementById('cashback').value = result;
             }
         var total = parseInt(price) - parseInt(result)
             if (!isNaN(total)) {
                 document.getElementById('txtResult').value = total;
             }
         }
      </script>
   </head>
   <body>
      <?php include('include/header.php');?>
      <div class="wrapper">
         <div class="container">
            <div class="row">
               <?php include('include/sidebar.php');?>				
               <div class="span9">
                  <div class="content">
                     <div class="module">
                        <div class="module-head">
                           <h3>Add Product ( পণ্য সংযুক্তকরণ )</h3>
                        </div>
                        <div class="module-body">
                           <?php if(isset($_POST['submit']))
                              {?>
                           <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                           </div>
                           <?php } ?>
                           <?php if(isset($_GET['del']))
                              {?>
                           <div class="alert alert-error">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
                           </div>
                           <?php } ?>
                           <br />
                           <form class="form-horizontal row-fluid" name="insertproduct" method="post" enctype="multipart/form-data">
						   <div class="control-group">
                                 <label class="control-label" for="basicinput">Brands Name ( ব্র্যান্ডস নাম )</label>
                                 <div class="controls">
                                    <select name="brands" class="span8 tip"  required>
                                       <option value="">Select Brands</option>
                                       <?php $query=mysqli_query($con,"select * from brands");
                                          while($row=mysqli_fetch_array($query))
                                          {?>
                                       <option value="<?php echo $row['id'];?>"><?php echo $row['brandsName'];?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Category ( ক্যাটাগরি )</label>
                                 <div class="controls">
                                    <select name="category" class="span8 tip" onChange="getSubcat(this.value);"  required>
                                       <option value="">Select Category</option>
                                       <?php $query=mysqli_query($con,"select * from category");
                                          while($row=mysqli_fetch_array($query))
                                          {?>
                                       <option value="<?php echo $row['id'];?>"><?php echo $row['catName'];?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Sub Category ( সাব ক্যাটাগরি )</label>
                                 <div class="controls">
                                    <select   name="subcategory"  id="subcategory" class="span8 tip" required>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Product Name ( পণ্যের নাম )</label>
                                 <div class="controls">
                                    <input type="text"    name="productName"  placeholder="Enter Product Name" class="span8 tip" required>
                                 </div>
                              </div>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">Production Process ( উৎপাদন প্রক্রিয়া )</label>
                                 <div class="controls">
                                    <input type="text"    name="productionProcess"  placeholder="Enter Product Process" class="span8 tip" required>
                                 </div>
                              </div>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">Where From ( কোথা থেকে )</label>
                                 <div class="controls">
                                    <select name="whereFrom" class="span8 tip" required>
                                       <option value="">Select Districts</option>
                                       <?php $query=mysqli_query($con,"select * from districts");
                                          while($row=mysqli_fetch_array($query))
                                          {?>
                                       <option value="<?php echo $row['id']; ?>"><?php echo $row['bn_name'] . ' - ' . $row['name']; ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
							  </div>
                              
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Size / Quantity ( পণ্যের আকার / পরিমাণ )</label>
                                 <div class="controls">
                                    <input type="text" name="size" id="size" placeholder="Enter Product Size or Quantity" class="span8 tip" required >
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Color ( পণ্যের রঙ )</label>
                                 <div class="controls">
                                    <select name="color" class="span8 tip"  required>
                                       <option value="">Select Color</option>
                                       <?php $query=mysqli_query($con,"select * from color");
                                          while($row=mysqli_fetch_array($query))
                                          {?>
                                       <option value="<?php echo $row['colorType'];?>"><?php echo $row['colorName'];?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Product Price ( পণ্যের দাম )</label>
                                 <div class="controls">
                                    <input type="text"    name="productprice" id="productprice" placeholder="Enter Product Price" class="span8 tip" required onkeyup="sum()">
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Price Off (%) ( মূল্য ছাড় (%) )</label>
                                 <div class="controls">
                                    <input type="text"    name="priceoff" id="priceoff" placeholder="Enter Price Off" class="span8 tip" required onkeyup="sum()">
                                    <input type="hidden"    name="cashback" id="cashback" placeholder="Enter Cash Back" class="span8 tip" required readonly>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">After Discount Price ( ছাড়ের পরে মূল্য )</label>
                                 <div class="controls">
                                    <input type="text"    name="productpricebd"  id="txtResult" placeholder="Enter After Discount" class="span8 tip" required readonly>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Description ( পণ্যের বর্ণনা )</label>
                                 <div class="controls">
                                    <textarea  name="productDescription"  placeholder="Enter Product Description" rows="6" class="span8 tip">
                                    </textarea>  
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Delivery Charge ( ডেলিভারি চার্জ )</label>
                                 <div class="controls">
                                    <input type="text"    name="productShippingcharge"  placeholder="Enter Product Delivery Charge" class="span8 tip" required>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Availability ( প্রাপ্যতা )</label>
                                 <div class="controls">
                                    <select   name="productAvailability"  id="productAvailability" class="span8 tip" required>
                                       <option value="">Select</option>
                                       <option value="In Stock">In Stock</option>
                                       <option value="Out of Stock">Out of Stock</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Front Image ( সামনের ছবি )</label>
                                 <div class="controls">
									<input type="file" name="productimage1" multiple onchange="previewImages(event, 'imagePreviewContainer')" />
									<div id="imagePreviewContainer" style="display: flex; flex-wrap: wrap;"></div>	
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Side Image ( পাশের ছবি )</label>
                                 <div class="controls">
									<input type="file" name="productimage2" multiple onchange="previewImages(event, 'imagePreviewSideContainer')" />
									<div id="imagePreviewSideContainer" style="display: flex; flex-wrap: wrap;"></div>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Back Image ( পিছনের ছবি )</label>
                                 <div class="controls">
									<input type="file" name="productimage3" multiple onchange="previewImages(event, 'imagePreviewBackContainer')" />
									<div id="imagePreviewBackContainer" style="display: flex; flex-wrap: wrap;"></div>
                                 </div>
                              </div>
							 			  
							  <div class="control-group">
                                 <div class="controls">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit ( সংরক্ষণ করুন )</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <!--/.content-->
               </div>
               <!--/.span9-->
            </div>
         </div>
         <!--/.container-->
      </div>
      <!--/.wrapper-->
      <?php include('include/footer.php');?>
      <?php include('include/js.php');?>
   </body>
   </html>
