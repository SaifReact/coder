<?php
   session_start();
   include('include/config.php');
   if(strlen($_SESSION['alogin'])==0)
   	{	
   header('location:index.php');
   }
   else{
   date_default_timezone_set('Asia/Dhaka');// change according timezone
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
                           <h3>Today's Orders</h3>
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
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Contact no</th>
                                    <th>Address</th>
                                    <th style="text-align:right">Amount </th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php 
                                    $f1="00:00:00";
                                    $from=date('Y-m-d')." ".$f1;
                                    $t1="23:59:59";
                                    $to=date('Y-m-d')." ".$t1;
                                    $query=mysqli_query($con,"select Distinct orders.orderId as orid, orders.orderDate as orderdate, payment.fullAmount as fullamt, users.name as username, users.contactno as usercontact, users.billingAddress as billingAddress from orders join payment on orders.orderId = payment.orderId join users on orders.userId=users.id where orders.orderStatus='N' and orders.orderDate Between '$from' and '$to' order by orders.id desc");
                                    //$query=mysqli_query($con,"select users.name as username, users.contactno as usercontact, users.billingAddress as billingAddress, products.productName as productname, products.shippingCharge as shippingcharge, orders.quantity as quantity, orders.orderDate as orderdate, products.productPrice as productprice, orders.id as id, orders.orderId as orid from orders join users on orders.userId = users.id join products on products.id = orders.productId where orders.orderStatus = 'N' and orders.orderDate Between '$from' and '$to'");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>										
                                 <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($row['orid']);?></td>
                                    <td><?php echo htmlentities($row['username']);?></td>
                                    <td><?php echo htmlentities($row['usercontact']);?></td>
                                    <td><?php echo htmlentities($row['billingAddress']);?></td>
                                    <td style="text-align:right"><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['fullamt']);?></td>
                                    <td><?php echo htmlentities($row['orderdate']);?></td>
                                    <td><a href="updateorder.php?oid=<?php echo htmlentities($row['orid']);?>" title="Update order" target="_blank"><i class="icon-edit"></i></a>
                                    </td>
                                 </tr>
                                 <?php $cnt=$cnt+1; } ?>
                              </tbody>
                           </table>
                        </div>
                     </div
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