<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   $cid=intval($_GET['id']);
   if(isset($_POST['submit']))
   {
   	$catName = $_POST['catName'];
   	$catImage = $_FILES["catImage"]["name"];
   	
   	$catid = $cid;
   	
   	if(!is_dir($dir)){
   		mkdir("categoryimages/".$catid);
   	}
   
   move_uploaded_file($_FILES["catImage"]["tmp_name"],"categoryimages/$catid/".$_FILES["catImage"]["name"]);
   $sql=mysqli_query($con,"update  category set catImage='$catImage' where id='$cid' ");
   $_SESSION['msg']="Category Image Updated Successfully !!";
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
                           <h3>Update Brands Image</h3>
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
                                 $query=mysqli_query($con,"select categoryName, catImage from category where id='$cid'");
                                 $cnt=1;
                                 while($row=mysqli_fetch_array($query))
                                 {
                                 ?>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Category Name</label>
                                 <div class="controls">
                                    <input type="text"  name="catName"  readonly value="<?php echo htmlentities($row['categoryName']);?>" class="span8 tip" required>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Current Category Image</label>
                                 <div class="controls">
                                    <img src="categoryimages/<?php echo htmlentities($cid);?>/<?php echo htmlentities($row['catImage']);?>" width="200" height="100"> 
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">New Category Image</label>
                                 <div class="controls">
                                    <input type="file" name="catImage" id="catImage" value="" class="span8 tip" required>
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