<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   date_default_timezone_set('Asia/Dhaka'); //Change according timezone
   $currentTime = date( 'Y-m-d h:i:s A', time () );
   
   if(isset($_GET['del']))
   		  {
   		          mysqli_query($con,"delete from users where id = '".$_GET['id']."'");
                     $_SESSION['delmsg']="User deleted !!";
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
                           <h3>Manage Users</h3>
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
                                    <th> Name</th>
                                    <th>Email </th>
                                    <th>Contact no</th>
                                    <th>Billing Address/City/State/Pincode </th>
                                    <th>Reg. Date </th>
                                    <th>Action </th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $query=mysqli_query($con,"select * from users order by id desc");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>									
                                 <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($row['name']);?></td>
                                    <td><?php echo htmlentities($row['email']);?></td>
                                    <td> <?php echo htmlentities($row['contactno']);?></td>
                                    <td><?php echo htmlentities($row['billingAddress'].",".$row['billingCity'].",".$row['billingState']."-".$row['billingPincode']);?></td>
                                    <td><?php echo htmlentities($row['regDate']);?></td>
                                    <td>
                                       <a href="manage-users.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-remove-sign"></i></a>
                                       <a href="user_all.php?id=<?php echo $row['id']?>"><i class="icon-eye-open"></i></a>
                                    </td>
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