<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   	
   if(isset($_POST['submit']))
   {
   	$banner=$_POST['banner'];
   	$imagesName=$_POST['imagesName'];
	$buttonName=$_POST['buttonName'];
   	$images=$_FILES["images"]["name"];
   //for getting brands id
   $query=mysqli_query($con,"select max(id) as imid from images");
   	$result=mysqli_fetch_array($query);
   	 $imagesid=$result['imid']+1;
   	$dir="images/$imagesid";
   if(!is_dir($dir)){
   		mkdir("images/".$imagesid);
   	}
   
   	move_uploaded_file($_FILES["images"]["tmp_name"],"images/$imagesid/".$_FILES["images"]["name"]);
   $sql=mysqli_query($con,"insert into images(imagesName,images,buttonName,imageSelect,status) values('$imagesName','$images','$buttonName','$banner','Active')");
   $_SESSION['msg']="Images Inserted Successfully !!";
   
   }
   
   if(isset($_GET['del']))
    {
            mysqli_query($con,"delete from images where id = '".$_GET['id']."'");
                  $_SESSION['delmsg']="Images deleted !!";
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
                           <h3>Insert Images</h3>
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
                                 <label class="control-label" for="basicinput">Selection</label>
                                 <div class="controls">
                                    <select name="banner" class="span8 tip" required>
                                       <option value="">-- Select --</option>
                                       <?php $query=mysqli_query($con,"select * from banner");
                                          while($row=mysqli_fetch_array($query))
                                          {?>
                                       <option value="<?php echo $row['bannerType'];?>"><?php echo $row['bannerName'];?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">Images Name</label>
                                 <div class="controls">
                                    <input type="text"    name="imagesName"  placeholder="Enter Images Name" class="span8 tip" required>
                                 </div>
                              </div>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Image</label>
                                 <div class="controls">
                                    <input type="file" name="images" id="images" value="" class="span8 tip" required>
                                 </div>
                              </div>
							  <div class="control-group">
                                 <label class="control-label" for="basicinput">Button Name</label>
                                 <div class="controls">
                                    <input type="text"    name="buttonName"  placeholder="Enter Button Name" class="span8 tip" >
                                 </div>
                              </div>
                              <div class="control-group">
                                 <div class="controls">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="module">
                        <div class="module-head">
                           <h3>Manage Brands</h3>
                        </div>
                        <div class="module-body table">
                           <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Name</th>
									<th>Button</th>
                                    <th>Image Selection</th> 
                                    <th>Status</th> 
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $query=mysqli_query($con,"select * from images");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>									
                                 <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($row['imagesName']);?></td>
                                    <td><?php echo htmlentities($row['buttonName']);?></td>
                                    <td><?php echo htmlentities($row['imageSelect']);?></td>
                                    <td><?php echo htmlentities($row['status']);?></td>
                                    <td>
                                       <a href="edit-images.php?id=<?php echo $row['id']?>" ><i class="icon-edit"></i></a>
                                       <a href="images.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-remove-sign"></i></a>
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
      <?php include('include/head.php');?>
   </body>
   <?php } ?>