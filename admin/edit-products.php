<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $pid = intval($_GET['id']); // product id
    
    if (isset($_POST['submit'])) {
		$brand = $_POST['brand'];
        $category = $_POST['category'];
        $subcat = $_POST['subcategory'];
        $productname = $_POST['productName'];
        $productionprocess = $_POST['productionProcess'];
        $wherefrom = $_POST['whereFrom'];
        $size = $_POST['size'];
        $color = $_POST['color'];
        $productprice = $_POST['productprice'];
        $productpricebd = $_POST['productpricebd'];
        $priceoff = $_POST['priceoff'];
        $cashback = $_POST['cashback'];
        $description = $_POST['description'];
        $productscharge = $_POST['productShippingcharge'];
        $availability = $_POST['availability'];
        
        $productimage1 = $_FILES["productimage1"]["name"];
        $productimage2 = $_FILES["productimage2"]["name"];
        $productimage3 = $_FILES["productimage3"]["name"];
        
        $dir = "productimages/$pid";
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Handle file uploads
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $uploaded_images = [];
        
        for ($i = 1; $i <= 3; $i++) {
            $fileInput = "productimage" . $i;
            if (!empty($_FILES[$fileInput]['name'])) {
                $fileName = basename($_FILES[$fileInput]["name"]);
                $fileTmpName = $_FILES[$fileInput]["tmp_name"];
                $fileSize = $_FILES[$fileInput]["size"];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (in_array($fileExt, $allowed_types) && $fileSize <= 5000000) { // 5MB limit
                    $filePath = "$dir/$fileName";
                    if (move_uploaded_file($fileTmpName, $filePath)) {
                        $uploaded_images[] = $fileName;
                    } else {
                        $_SESSION['error'] = "Failed to upload image $i";
                        break;
                    }
                } else {
                    $_SESSION['error'] = "Invalid file format or size for image $i";
                    break;
                }
            } else {
                $uploaded_images[] = null;
            }
        }

        // Ensure all variables are initialized
        $productimage1 = !empty($uploaded_images[0]) ? $uploaded_images[0] : '';
        $productimage2 = !empty($uploaded_images[1]) ? $uploaded_images[1] : '';
        $productimage3 = !empty($uploaded_images[2]) ? $uploaded_images[2] : '';

        // SQL update query with prepared statements
        $stmt = $con->prepare("UPDATE products 
                       SET brand = ?, category = ?, subCategory = ?, productName = ?, productionProcess = ?, 
                           whereFrom = ?, size = ?, color = ?, productPrice = ?, 
                           description = ?, shippingCharge = ?, availability = ?, 
                           priceAfterDiscount = ?, priceOffPercent = ?, cashback = ?, 
                           productImage1 = ?, productImage2 = ?, productImage3 = ? 
                       WHERE id = ?");

		if (!$stmt) {
			die("Prepare failed: " . $con->error);
		}

		$stmt->bind_param(
			"ssssssssssssssssssi",  
			$brand, 
			$category, 
			$subcat, 
			$productname, 
			$productionprocess, 
			$wherefrom, 
			$size, 
			$color, 
			$productprice, 
			$description, 
			$productscharge, 
			$availability, 
			$productpricebd, 
			$priceoff, 
			$cashback, 
			$productimage1, 
			$productimage2, 
			$productimage3, 
			$pid
		);

		if ($stmt->execute()) {
			$_SESSION['msg'] = "Product Updated Successfully!";
		} else {
			$_SESSION['error'] = "Error updating product: " . $stmt->error;
		}

		$stmt->close();


    }
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
                           <h3>Update Product ( পণ্যের হালনাগাদ )</h3>
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
                              <?php 
                                 $query=mysqli_query($con,"SELECT products.*, districts.id AS did, districts.name AS ename, districts.bn_name AS bname, 
										   category.catName AS catname, category.id AS cid, subcategory.subcategory AS subcatname, 
										   subcategory.id AS subcatid, brands.id AS brandsId, brands.brandsName AS brandsname,
										   color.id as coid, color.colorName as coname, color.colorType as cotype
									FROM products 
									JOIN category ON category.id = products.category 
									JOIN subcategory ON subcategory.id = products.subCategory 
									JOIN brands ON brands.id = products.brand 
									JOIN districts ON districts.id = products.whereFrom 
									join color ON color.colorType = products.color
									WHERE products.id = '$pid'");
                                 $cnt=1;
                                 while($row=mysqli_fetch_array($query))
                                 {
                                   
                                 ?>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">Brands Name ( ব্র্যান্ডস নাম )</label>
                                 <div class="controls">
                                    <select   name="brand"  id="brand" class="span8 tip" required>
                                       <option value="<?php echo htmlentities($row['brandsId']);?>"><?php echo htmlentities($row['brandsname']);?></option>
                                       <?php $query=mysqli_query($con,"select * from brands");
                                          while($rw1=mysqli_fetch_array($query))
                                          {
                                          	if($row['brandsname']==$rw1['brandsName'])
                                          	{
                                          		continue;
                                          	}
                                          	else{
                                          	?>
                                       <option value="<?php echo $rw1['id'];?>"><?php echo $rw1['brandsName'];?></option>
                                       <?php }} ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Category ( ক্যাটাগরি )</label>
                                 <div class="controls">
                                    <select name="category" class="span8 tip" onChange="getSubcat(this.value);"  required>
                                       <option value="<?php echo htmlentities($row['cid']);?>"><?php echo htmlentities($row['catname']);?></option>
                                       <?php $query=mysqli_query($con,"select * from category");
                                          while($rw=mysqli_fetch_array($query))
                                          {
                                          	if($row['catname']==$rw['catName'])
                                          	{
                                          		continue;
                                          	}
                                          	else{
                                          	?>
                                       <option value="<?php echo $rw['id'];?>"><?php echo $rw['catName'];?></option>
                                       <?php }} ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Sub Category ( সাব ক্যাটাগরি )</label>
                                 <div class="controls">
                                    <select   name="subcategory"  id="subcategory" class="span8 tip" required>
                                       <option value="<?php echo htmlentities($row['subcatid']);?>"><?php echo htmlentities($row['subcatname']);?></option>
                                       <?php $query=mysqli_query($con,"select * from subcategory");
                                          while($rw2=mysqli_fetch_array($query))
                                          {
                                          	if($row['subcatname']==$rw2['subcategory'])
                                          	{
                                          		continue;
                                          	}
                                          	else{
                                          	?>
                                       <option value="<?php echo $rw2['id'];?>"><?php echo $rw2['subcategory'];?></option>
                                       <?php }} ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Product Name ( পণ্যের নাম )</label>
                                 <div class="controls">
                                    <input type="text"    name="productName"  placeholder="Enter Product Name" value="<?php echo htmlentities($row['productName']);?>" class="span8 tip" >
                                 </div>
                              </div>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">Production Process ( উৎপাদন প্রক্রিয়া )</label>
                                 <div class="controls">
                                    <input type="text"    name="productionProcess"  placeholder="Enter Product Process" value="<?php echo htmlentities($row['productionProcess']);?>" class="span8 tip" required>
                                 </div>
                              </div>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">Where From ( কোথা থেকে )</label>
                                 <div class="controls">
                                    <select name="whereFrom" class="span8 tip" required>
                                       <option value="<?php echo htmlentities($row['did']);?>"><?php echo htmlentities($row['bname'] . ' - ' . $row['ename']);?></option>
                                       <?php $query=mysqli_query($con,"select * from districts");
                                          while($rw3=mysqli_fetch_array($query))
                                          {
                                          	if($row['did']==$rw3['id'])
                                          	{
                                          		continue;
                                          	}
                                          	else{
                                          	?>
                                       <option value="<?php echo $rw3['id']; ?>"><?php echo $rw3['bn_name'] . ' - ' . $rw3['name']; ?></option>
                                       <?php }} ?>
                                    </select>
                                 </div>
							  </div>
                              
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">Size ( পণ্যের আকার )</label>
                                 <div class="controls">
                                    <input type="text" name="size" id="size" placeholder="Enter Product Size" class="span8 tip" value="<?php echo htmlentities($row['size']);?>">
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Color ( পণ্যের রঙ )</label>
                                 <div class="controls">
                                    <select name="color" class="span8 tip" required>
                                       <option value="<?php echo htmlentities($row['coid']);?>"><?php echo htmlentities($row['coname']);?></option>
                                       <?php $query=mysqli_query($con,"select * from color");
                                          while($rw5=mysqli_fetch_array($query))
                                          {
                                          	if($row['cotype']==$rw5['colorType'])
                                          	{
                                          		continue;
                                          	}
                                          	else{
                                          	?>
                                       <option value="<?php echo $rw5['id']; ?>"><?php echo $rw5['colorName']; ?></option>
                                       <?php }} ?>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Product Price ( পণ্যের দাম )</label>
                                 <div class="controls">
                                    <input type="text"    name="productprice" id="productprice" placeholder="Enter Product Price" class="span8 tip" value="<?php echo htmlentities($row['productPrice']);?>" required onkeyup="sum()">
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Price Off (%) ( মূল্য ছাড় (%) )</label>
                                 <div class="controls">
                                    <input type="text"    name="priceoff" id="priceoff" placeholder="Enter Price Off" class="span8 tip" value="<?php echo htmlentities($row['priceOffPercent']);?>" required onkeyup="sum()">
                                    <input type="hidden"    name="cashback" id="cashback" placeholder="Enter Cash Back" class="span8 tip" value="<?php echo htmlentities($row['cashback']);?>" required readonly>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">After Discount Price ( ছাড়ের পরে মূল্য )</label>
                                 <div class="controls">
                                    <input type="text"    name="productpricebd"  id="txtResult" placeholder="Enter After Discount" class="span8 tip" value="<?php echo htmlentities($row['priceAfterDiscount']);?>" required readonly>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Description ( পণ্যের বর্ণনা )</label>
                                 <div class="controls">
                                    <textarea  name="description"  placeholder="Enter Product Description" rows="6" class="span8 tip">
                                    <?php echo htmlentities($row['description']);?>
                                    </textarea>  
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Delivery Charge ( ডেলিভারি চার্জ )</label>
                                 <div class="controls">
                                    <input type="text"    name="productShippingcharge"  placeholder="Enter Product Shipping Charge" value="<?php echo htmlentities($row['shippingCharge']);?>" class="span8 tip" required>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Availability ( প্রাপ্যতা )</label>
                                 <div class="controls">
                                    <select   name="availability"  id="availability" class="span8 tip" required>
                                       <option value="<?php echo htmlentities($row['availability']);?>"><?php echo htmlentities($row['availability']);?></option>
                                       <option value="In Stock">In Stock</option>
                                       <option value="Out of Stock">Out of Stock</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Current Front Image ( বর্তমান সামনের ছবি )</label>
                                 <div class="controls">
                                    <img src="productimages/<?php echo htmlentities($pid);?>/<?php echo htmlentities($row['productImage1']);?>" width="200" height="100"> 
                                 </div>
                              </div>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">New Front Image ( নতুন সামনের ছবি )</label>
                                 <div class="controls">
									<input type="file" name="productimage1" multiple onchange="previewImages(event, 'imagePreviewContainer')" />
									<div id="imagePreviewContainer" style="display: flex; flex-wrap: wrap;"></div>	
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Current Side Image ( বর্তমান পাশের ছবি )</label>
                                 <div class="controls">
                                    <img src="productimages/<?php echo htmlentities($pid);?>/<?php echo htmlentities($row['productImage2']);?>" width="200" height="100"> 
                                 </div>
                              </div>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">New Side Image ( নতুন পাশের ছবি )</label>
                                 <div class="controls">
									<input type="file" name="productimage2" multiple onchange="previewImages(event, 'imagePreviewSideContainer')" />
									<div id="imagePreviewSideContainer" style="display: flex; flex-wrap: wrap;"></div>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Current Back Image ( বর্তমান পিছনের ছবি )</label>
                                 <div class="controls">
                                    <img src="productimages/<?php echo htmlentities($pid);?>/<?php echo htmlentities($row['productImage3']);?>" width="200" height="100"> 
                                 </div>
                              </div>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">New Back Image ( নতুন পিছনের ছবি )</label>
                                 <div class="controls">
									<input type="file" name="productimage3" multiple onchange="previewImages(event, 'imagePreviewBackContainer')" />
									<div id="imagePreviewBackContainer" style="display: flex; flex-wrap: wrap;"></div>
                                 </div>
                              </div>
                              <?php } ?>
                              <div class="control-group">
                                 <div class="controls">
                                    <button type="submit" name="submit" class="btn btn-success">Update (হালনাগাদ করুন)</button>
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