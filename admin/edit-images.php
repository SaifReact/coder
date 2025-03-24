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
   	$imageSelect=$_POST['imageSelect'];
   	$imagesName=$_POST['imagesName'];
   	$buttonName=$_POST['buttonName'];
   	$status=$_POST['status'];
   	
   $sql=mysqli_query($con,"update images set imagesName='$imagesName',buttonName='$buttonName',imageSelect='$imageSelect',status='$status' where id='$mid' ");
   $_SESSION['msg']="Image Data Updated Successfully !!";
   
   }
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
    <?php include('include/head.php');?>
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
                           <h3>Edit Images</h3>
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
                                 $query=mysqli_query($con,"select images.*, banner.bannerType as bType, banner.bannerName as bName from images join banner on banner.bannerType = images.imageSelect where images.id='$mid'");
                                 $cnt=1;
                                 while($row=mysqli_fetch_array($query))
                                 {
                                   
                                 ?>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Image Selection</label>
                                 <div class="controls">
                                    <select name="imageSelect" class="span8 tip"  required>
                                       <option value="<?php echo htmlentities($row['bType']);?>"><?php echo htmlentities($row['bName']);?></option>
                                       <?php $query=mysqli_query($con,"select * from banner");
                                          while($rw=mysqli_fetch_array($query))
                                          {
                                          	if($row['bName']==$rw['bannerName'])
                                          	{
                                          		continue;
                                          	}
                                          	else{
                                          	?>
                                       <option value="<?php echo $rw['bannerType'];?>"><?php echo $rw['bannerName'];?></option>
                                       <?php }} ?>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Name</label>
                                 <div class="controls">
                                    <input type="text"    name="imagesName"  placeholder="Enter Image Name" value="<?php echo htmlentities($row['imagesName']);?>" class="span8 tip" >
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Button Name</label>
                                 <div class="controls">
                                    <input type="text"    name="buttonName"  placeholder="Enter Button Name" value="<?php echo htmlentities($row['buttonName']);?>" class="span8 tip" >
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Status</label>
                                 <div class="controls">
                                    <select   name="status"  id="status" class="span8 tip" required>
                                       <option value="<?php echo htmlentities($row['status']);?>"><?php echo htmlentities($row['status']);?></option>
                                       <option value="Active">Active</option>
                                       <option value="Inactive">Inactive</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Image</label>
                                 <div class="controls">
                                    <img src="images/<?php echo htmlentities($mid);?>/<?php echo htmlentities($row['images']);?>" width="200" height="100"> <a href="update-ads.php?id=<?php echo $row['id'];?>">Change Image</a>
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