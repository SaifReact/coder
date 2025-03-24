<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   	$tid=intval($_GET['id']);// product id
   if(isset($_POST['submit']))
   {
   	$ticketName=$_POST['ticketName'];
   	
   $sql=mysqli_query($con,"update  ticket set ticketName='$ticketName' where id='$tid' ");
   $_SESSION['msg']="Ticket Updated Successfully !!";
   
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
                           <h3>Edit Ticket</h3>
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
                                 $query=mysqli_query($con,"select * from ticket where id='$tid'");
                                 $cnt=1;
                                 while($row=mysqli_fetch_array($query))
                                 {
                                 ?>
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Name</label>
                                 <div class="controls">
                                    <input type="text"    name="ticketName"  placeholder="Enter Product Name" value="<?php echo htmlentities($row['ticketName']);?>" class="span8 tip" >
                                 </div>
                              </div>
                              
                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Image</label>
                                 <div class="controls">
                                    <img src="ticketimages/<?php echo htmlentities($tid);?>/<?php echo htmlentities($row['ticketImg']);?>" width="200" height="100"> <a href="update-ticketimages.php?id=<?php echo $row['id'];?>">Change Image</a>
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