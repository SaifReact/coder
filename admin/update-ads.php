<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   	$mid=intval($_GET['id']);
   if(isset($_POST['submit']))
   {
   	$imageName=$_POST['imageName'];
   	$adsimage=$_FILES["adsimage"]["name"];
   //$dir="productimages";
   //unlink($dir.'/'.$pimage);
   
   
   	move_uploaded_file($_FILES["adsimage"]["tmp_name"],"images/$mid/".$_FILES["adsimage"]["name"]);
   	$sql=mysqli_query($con,"update  images set images='$adsimage' where id='$mid' ");
   $_SESSION['msg']="Ads Image Updated Successfully !!";
   
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
                           <h3>Update Image</h3>
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
                                 $query=mysqli_query($con,"select imagesName, images from images where id='$mid'");
                                 $cnt=1;
                                 while($row=mysqli_fetch_array($query))
                                 {                                 ?>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Image Name</label>
                                 <div class="controls">
                                    <input type="text"    name="imageName"  readonly value="<?php echo htmlentities($row['imagesName']);?>" class="span8 tip" required>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Image</label>
                                 <div class="controls">
                                    <img src="images/<?php echo htmlentities($mid);?>/<?php echo htmlentities($row['images']);?>" width="200" height="100"> 
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">New Image</label>
                                 <div class="controls">
                                    <input type="file" name="adsimage" id="adsimage" value="" class="span8 tip" required>
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