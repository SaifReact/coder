<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   	$pid=intval($_GET['id']);// product id
   if(isset($_POST['submit']))
   {
   	$productname=$_POST['productName'];
   	$productimage2=$_FILES["productimage2"]["name"];
   
   //dir="productimages";
   //unlink($dir.'/'.$pimage);
   
   
   	move_uploaded_file($_FILES["productimage2"]["tmp_name"],"productimages/$pid/".$_FILES["productimage2"]["name"]);
   	$sql=mysqli_query($con,"update  products set productImage2='$productimage2' where id='$pid' ");
   $_SESSION['msg']="Product Image Updated Successfully !!";
   
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
                           <h3>Update Side Image</h3>
                        </div>
                        <div class="module-body">
                           <?php if(isset($_POST['submit']))
                              {?>
                           <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                           </div>
                           <?php } ?>
                           <br />
                           <form class="form-horizontal row-fluid" name="insertproduct" method="post" enctype="multipart/form-data">
                              <?php 
                                 $query=mysqli_query($con,"select productName,productImage2 from products where id='$pid'");
                                 $cnt=1;
                                 while($row=mysqli_fetch_array($query))
                                 {
                                   
                                 
                                 
                                 ?>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Product Name</label>
                                 <div class="controls">
                                    <input type="text"    name="productName"  readonly value="<?php echo htmlentities($row['productName']);?>" class="span8 tip" required>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Current Side Image</label>
                                 <div class="controls">
                                    <img src="productimages/<?php echo htmlentities($pid);?>/<?php echo htmlentities($row['productImage2']);?>" width="200" height="100"> 
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">New Side Image</label>
                                 <div class="controls">
                                    <input type="file" name="productimage2" id="productimage2" value="" class="span8 tip" required>
                                 </div>
                              </div>
                              <?php } ?>
                              <div class="control-group">
                                 <div class="controls">
                                    <button type="submit" name="submit" class="btn btn-success">Update</button>
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
   <?php } ?>