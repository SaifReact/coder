<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   date_default_timezone_set('Asia/Kolkata');// change according timezone
   $currentTime = date( 'd-m-Y h:i:s A', time () );		  

// Delete Product
if (isset($_GET['del']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Fetch image paths before deletion
    $stmt = $con->prepare("SELECT productImage1, productImage2, productImage3 FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->bind_result($image1, $image2, $image3);

    if ($stmt->fetch()) {
        $stmt->close();

        // Delete product record from database
        $stmt = $con->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        if ($stmt->execute()) {
            $stmt->close();

            // Define product image directory
            $productDir = "productimages/$productId";

            // Delete image files if they exist
            foreach ([$image1, $image2, $image3] as $image) {
                $filePath = "$productDir/$image";
                if (!empty($image) && file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Delete directory if it exists and is empty
            if (is_dir($productDir) && count(scandir($productDir)) === 2) {
                rmdir($productDir);
            }

            $_SESSION['delmsg'] = "Product Deleted Successfully!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete product.";
        }
    } 
	$stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
    <?php include('include/head.php');?>
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
                           <h3>Product Lists ( পণ্যের তালিকাসমূহ )</h3>
                        </div>
                        <div class="module-body table">
                           <?php if(isset($_GET['del']))
                              {?>
                           <div class="alert alert-error">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
                           </div>
                           <?php } ?>
                           <br />
                           <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Product Name ( পণ্যের নাম )</th>
									<th>Brands Name ( ব্র্যান্ডস নাম )</th>
                                    <th>Category ( ক্যাটাগরি )</th>
                                    <th>Sub Category ( সাব ক্যাটাগরি )</th>
                                    <th>Creation Date ( সংরক্ষণ তারিখ )</th>
                                    <th>Action ( কর্ম পদ্ধতি )</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $query=mysqli_query($con,"select products.*, category.catName, subcategory.subcategory, brands.brandsName, color.colorName from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory join brands on brands.id=products.brand join color on color.colorType=products.color order by products.id desc ");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>									
                                 <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($row['productName']);?></td>
									<td><?php echo htmlentities($row['brandsName']);?></td>
                                    <td><?php echo htmlentities($row['catName']);?></td>
                                    <td><?php echo htmlentities($row['subcategory']);?></td>
                                    <td><?php echo htmlentities($row['postingDate']);?></td>
                                    <td style="text-align: center;">
                                       <a href="edit-products.php?id=<?php echo $row['id']?>" ><i class="icon-edit" style="font-size: 20px; color: blue;"></i></a>
                                       <a href="manage-products.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-trash" style="font-size: 20px; color: red;"></i></a>
                                    </td>
                                 </tr>
                                 <?php $cnt=$cnt+1; } ?>
                           </table>
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
   <?php } ?>