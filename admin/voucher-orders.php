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
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
       <?php include('include/head.php');?>
      <script language="javascript" type="text/javascript">
         var popUpWin=0;
         function popUpWindow(URLStr, left, top, width, height)
         {
          if(popUpWin)
         {
         if(!popUpWin.closed) popUpWin.close();
         }
         popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
         }
         
      </script>
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
                           <h3>Delivered Orders</h3>
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
                           <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display table-responsive" >
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact no</th>
                                    <th>Address</th>
                                    <th>Order ID</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php 
                                    $st='Completed';
                                    $query=mysqli_query($con,"select Distinct orders.orderId as orid, users.name as username, users.contactno as usercontact, users.billingAddress as billingAddress from orders join users on  orders.userId=users.id where orders.orderStatus='$st' order by orders.id desc");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>										
                                 <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($row['username']);?></td>
                                    <td><?php echo htmlentities($row['usercontact']);?></td>
                                    <td><?php echo htmlentities($row['billingAddress']);?></td>
                                    <td><?php echo htmlentities($row['orid']);?></td>
                                    <td><a href="voucher.php?oid=<?php echo htmlentities($row['orid']);?>" title="Voucher" target="_blank"><i class="icon-print"></i></a>
                                    </td>
                                 </tr>
                                 <?php $cnt=$cnt+1; } ?>
                              </tbody>
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