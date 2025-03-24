<?php 
   session_start();
   error_reporting(0);
   include('includes/config.php');
   if(strlen($_SESSION['login'])==0)
       {   
   header('location:login.php');
   }
   else{
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <?php include( 'includes/head.php');?>
   <body class="cnt-home">
      <!-- ============================================== HEADER ============================================== -->
      <header class="header-style-1">
         <?php include('includes/top-header.php');?>
         <?php include('includes/main-header.php');?>
         <?php include('includes/menu-bar.php');?>
      </header>
      <!-- ============================================== HEADER : END ============================================== -->
      <div class="breadcrumb">
         <div class="container">
            <div class="breadcrumb-inner">
               <ul class="list-inline list-unstyled">
                  <li><a href="#">Home</a></li>
                  <li class='active'><a href="order-history.php">Order-History</a></li>
               </ul>
            </div>
            <!-- /.breadcrumb-inner -->
         </div>
         <!-- /.container -->
      </div>
      <!-- /.breadcrumb -->
      <div class="body-content outer-top-xs">
         <div class="container">
            <div class="row inner-bottom-sm">
               <div class="shopping-cart">
                  <div class="col-md-12 col-sm-12 shopping-cart-table ">
                     <div class="table-responsive">
                        <form name="cart" method="post">
                           <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display table-responsive" >
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th style="text-align:right">Quantity</th>
                                    <th style="text-align:right">Amount </th>
                                    <th>PayMethod</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php 
                                    $query=mysqli_query($con,"select orders.orderId as orid, orders.orderDate as orderdate, sum(orders.quantity) as totqty, orders.orderStatus as status, payment.fullAmount as fullamt, payment.paymentMethod as paytype from orders join payment on orders.orderId = payment.orderId  where orders.userId='".$_SESSION['id']."' group by orid, orderdate, fullamt, status, paytype  order by orders.id desc");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>										
                                 <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td style="text-align:center"><?php echo htmlentities($row['orid']);?></td>
                                    <td style="text-align:right"><?php echo htmlentities($row['totqty']);?></td>
                                    <td style="text-align:right"><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['fullamt']);?></td>
                                    <td style="text-align:center"><?php echo htmlentities($row['paytype']);?></td>
                                    <td style="text-align:center"><?php echo htmlentities($row['orderdate']);?></td>
                                    <td style="text-align:center">    
                                   <!-- <a href="updateorder.php?oid=<?php echo htmlentities($row['orid']);?>" title="Update order" target="_blank"><i class="icon-edit"></i></a>-->
                                   <?php if ($row['status'] != 'Completed') {?>
                                    <a href="track-order.php?orid=<?php echo htmlentities($row['orid']);?>" title="Track order" target="_blank">
                                       Track
                                       <?php } ?>
                                    </td>
                                 </tr>
                                 <?php $cnt=$cnt+1; } ?>
                              </tbody>
                           </table>
                          
                     </div>
                  </div>
               </div>
               <!-- /.shopping-cart -->
            </div>
            <!-- /.row -->
            </form>
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->
            <?php echo include('includes/brands-slider.php');?>
            <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	
         </div>
         <!-- /.container -->
      </div>
      <!-- /.body-content -->
      <?php include( 'includes/footer-top.php');?>
      <?php include('includes/footer.php');?>
      <?php include( 'includes/js.php');?>
   </body>
</html>
<?php } ?>