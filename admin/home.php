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
                     <div class="btn-controls">
                        <div class="btn-box-row row-fluid">
                           <?php
                              $f1="00:00:00";
                              $from=date('Y-m-d')." ".$f1;
                              $t1="23:59:59";
                              $to=date('Y-m-d')." ".$t1;
                              $result = mysqli_query($con,"SELECT * FROM orders where orderStatus = 'N' and orderDate Between '$from' and '$to'");
                              $num_rows1 = mysqli_num_rows($result);
                              {
                              ?>
                           <a href="todays-orders.php" class="btn-box big span4">
                              <i class=" icon-random"></i><b><?php echo htmlentities($num_rows1); ?></b>
                              <?php } ?>
                              <p class="text-muted"> Today's Order </p>
                           </a>
                           <?php	
                              $status='in Process';									 
                              $ret = mysqli_query($con,"SELECT * FROM orders where orderStatus='$status'");
                              $num = mysqli_num_rows($ret);
                              {?>
                           <a href="pending-orders.php" class="btn-box big span4">
                              <i class="icon-truck"></i><b><?php echo htmlentities($num); ?></b>
                              <?php } ?>
                              <p class="text-muted"> Pending Orders</p>
                           </a>
                           <?php	
                              $status='Delivered';									 
                              $rt = mysqli_query($con,"SELECT * FROM orders where orderStatus='$status'");
                              $num1 = mysqli_num_rows($rt);
                              {?>
                           <a href="delivered-orders.php" class="btn-box big span4">
                              <i class="icon-briefcase"></i><b><?php echo htmlentities($num1); ?></b>
                              <b class="label green pull-right"></b>
                              <?php } ?>
                              <p class="text-muted">Delivered Orders</p>
                           </a>
                        </div>
                        <div class="btn-box-row row-fluid">
                           <div class="span12">
                              <div class="row-fluid">
                                 <div class="span12">
                                    <?php										 
                                       $pro = mysqli_query($con,"SELECT * FROM products");
                                       $pro_num = mysqli_num_rows($pro);
                                       {?>
                                    <a href="manage-products.php" class="btn-box small span4">
                                       <i class="icon-shopping-cart"></i><b><?php echo htmlentities($pro_num); ?></b>
                                       <?php } ?>
                                       <p>Products</p>
                                    </a>
                                    <?php										 
                                       $user = mysqli_query($con,"SELECT * FROM users");
                                       $user_num = mysqli_num_rows($user);
                                       {?>
                                    <a href="manage-users.php" class="btn-box small span4">
                                       <i class="icon-group"></i><b><?php echo htmlentities($user_num); ?></b>
                                       <?php } ?>
                                       <p>Clients</p>
                                    </a>
                                    <?php										 
                                       $brands = mysqli_query($con,"SELECT * FROM brands");
                                       $brn_num = mysqli_num_rows($brands);
                                       {?>
                                    <a href="brands.php" class="btn-box small span4">
                                       <i class="icon-hand-right"></i><b><?php echo htmlentities($brn_num); ?></b>
                                       <?php } ?>
                                       <p>Brands</p>
                                    </a>
                                 </div>
                              </div>
                              <div class="row-fluid">
                                 <div class="span12">
                                    <?php										 
                                       $cat = mysqli_query($con,"SELECT * FROM category");
                                       $cat_num = mysqli_num_rows($cat);
                                       {?>
                                    <a href="category.php" class="btn-box small span4">
                                       <i class="icon-hand-left"></i><b><?php echo htmlentities($cat_num); ?></b>
                                       <?php } ?>
                                       <p>Categories</p>
                                    </a>
                                    <?php										 
                                       $scat = mysqli_query($con,"SELECT * FROM subcategory");
                                       $scat_num = mysqli_num_rows($scat);
                                       {?>
                                    <a href="subcategory.php" class="btn-box small span4">
                                       <i class="icon-hand-up"></i><b><?php echo htmlentities($scat_num); ?></b>
                                       <?php } ?>
                                       <p>Sub Categories</p>
                                    </a>
                                    <?php
                                       $f11="00:00:00";
                                       $from1=date('Y-m-d')." ".$f11;
                                       $t11="23:59:59";
                                       $to1=date('Y-m-d')." ".$t11;
                                       $result1 = mysqli_query($con,"SELECT * FROM userlog where loginTime Between '$from1' and '$to1'");
                                       $num_rows11 = mysqli_num_rows($result1);
                                       {
                                       ?>
                                    <a href="user-logs.php" class="btn-box small span4">
                                       <i class=" icon-plus-sign-alt"></i><b><?php echo htmlentities($num_rows11); ?></b>
                                       <?php } ?>
                                       <p class="text-muted"> User's Log </p>
                                    </a>
                                 </div>
                              </div>
                           </div>
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