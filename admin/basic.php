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
                           <h3>Manage Company Info.</h3>
                        </div>
                        <div class="module-body table">
                           <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Logo</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Currency</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $query=mysqli_query($con,"select * from basic");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>									
                                 <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($row['compName']);?></td>
                                    <td><img src="logo/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['logo']); ?>" width="100" height="100"></td>
                                    <td> <?php echo htmlentities($row['address']);?></td>
                                    <td><?php echo htmlentities($row['phone1']);?></td>
                                    <td><?php echo htmlentities($row['email']);?></td>
									<td><img src="logo/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['currency']); ?>" width="50" height="50"></td>
                                    <td>
                                       <a href="edit-basic.php?id=<?php echo $row['id']?>" ><i class="icon-edit"></i></a>
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