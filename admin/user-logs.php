<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   
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
                           <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th> User Email</th>
                                    <th>User IP </th>
                                    <th>Login Time</th>
                                    <th>Logout Time </th>
                                    <th>Status </th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $query=mysqli_query($con,"select * from userlog order by id desc");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>									
                                 <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($row['userEmail']);?></td>
                                    <td><?php echo htmlentities($row['userip']);?></td>
                                    <td> <?php echo htmlentities($row['loginTime']);?></td>
                                    <td><?php echo htmlentities($row['logout']); ?></td>
                                    <td><?php $st=$row['status'];
                                       if($st==1)
                                       {
                                       	echo "Successfull";
                                       }
                                       else
                                       {
                                       	echo "Failed";
                                       }
                                       										 ?></td>
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