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

   	$ticketName = $_POST['ticketName'];
   	$ticketImg = $_FILES["ticketImg"]["name"];
   //for getting product id
   $query=mysqli_query($con,"select max(id) as tid from ticket");
   	$result=mysqli_fetch_array($query);
   	 $ticketid=$result['tid']+1;
   	$dir="ticketimages/$ticketid";
   if(!is_dir($dir)){
   		mkdir("ticketimages/".$ticketid);
   	}
   
   	move_uploaded_file($_FILES["ticketImg"]["tmp_name"],"ticketimages/$ticketid/".$_FILES["ticketImg"]["name"]);

   $sql=mysqli_query($con,"insert into ticket(id, ticketName, ticketImg) values('$ticketid', '$ticketName', '$ticketImg')");
   $_SESSION['msg']="Ticket Inserted Successfully !!";
   
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
                           <h3>Insert Ticket</h3>
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
                                 <label class="control-label" for="basicinput">Name</label>
                                 <div class="controls">
                                    <input type="text"    name="ticketName"  placeholder="Enter Ticket Name" class="span8 tip" required>
                                 </div>
                              </div>

                              <div class="control-group">
                                 <label class="control-label" for="basicinput">Image</label>
                                 <div class="controls">
                                    <input type="file" name="ticketImg"  class="span8 tip">
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
                           <h3>Manage Ticket</h3>
                        </div>
                        <div class="module-body table">
                           <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Brands</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $query=mysqli_query($con,"select * from ticket");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>									
                                 <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($row['ticketName']);?></td>
                                    <td><img src="ticketimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['ticketImg']);?>" width="100" height="100"></td>
                                    <td>
                                       <a href="edit-ticket.php?id=<?php echo $row['id']?>" ><i class="icon-edit"></i></a>
                                       <a href="eticket.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-remove-sign"></i></a>
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