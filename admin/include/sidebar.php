<div class="span3">
   <div class="sidebar">
      <ul class="widget widget-menu unstyled">
	     <li><a href="home.php"><i class="menu-icon icon-dashboard"></i>Dashboard</a></li>
         <li>
            <a class="collapsed" data-toggle="collapse" href="#togglePages">
            <i class="menu-icon icon-cog"></i>
            <i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
            Order Management
            </a>
            <ul id="togglePages" class="collapse unstyled">
               <li>
                  <a href="todays-orders.php">
                  <i class="icon-hand-right"></i>
                  Today's Orders
                  <?php
                     $f1="00:00:00";
                     $from=date('Y-m-d')." ".$f1;
                     $t1="23:59:59";
                     $to=date('Y-m-d')." ".$t1;
                     $result = mysqli_query($con,"SELECT * FROM orders where orderStatus = 'N' and orderDate Between '$from' and '$to'");
                     $num_rows1 = mysqli_num_rows($result);
                     {
                     ?>
                  <b class="label red pull-right"><?php echo htmlentities($num_rows1); ?></b>
                  <?php } ?>
                  </a>
               </li>
               <li>
                  <a href="pending-orders.php">
                  <i class="icon-hand-right"></i>
                  Pending Orders
                  <?php	
                     $status='In Process';									 
                     $ret = mysqli_query($con,"SELECT * FROM orders where orderStatus='$status'");
                     $num = mysqli_num_rows($ret);
                     {?><b class="label orange pull-right"><?php echo htmlentities($num); ?></b>
                  <?php } ?>
                  </a>
               </li>
               <li>
                  <a href="delivered-orders.php">
                  <i class="icon-hand-right"></i>
                  Delivered Orders
                  <?php	
                     $status='Delivered Process';									 
                     $rt = mysqli_query($con,"SELECT * FROM orders where orderStatus='$status'");
                     $num1 = mysqli_num_rows($rt);
                     {?><b class="label green pull-right"><?php echo htmlentities($num1); ?></b>
                  <?php } ?>
                  </a>
               </li>
               <li>
                  <a href="voucher-orders.php">
                  <i class="icon-hand-right"></i>
                  Voucher Print
                  <?php	
                     $status='Completed';									 
                     $rt = mysqli_query($con,"SELECT * FROM orders where orderStatus='$status'");
                     $num1 = mysqli_num_rows($rt);
                     {?><b class="label blue pull-right"><?php echo htmlentities($num1); ?></b>
                  <?php } ?>
                  </a>
               </li>
            </ul>
         </li>
		 <li><a class="collapsed" data-toggle="collapse" href="#users"><i class="menu-icon icon-group"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Users </a>
			<ul id="users" class="collapse unstyled">
			<li><a href="manage-users.php"><i class="menu-icon icon-hand-right"></i>Manage users</a></li>
			<li><a href="cashpay.php"><i class="menu-icon icon-hand-right"></i>Cashpay to users</a></li>
			<li><a href="user-logs.php"><i class="menu-icon icon-hand-right"></i>User Login Log </a></li>
			</ul>
		 </li>
      </ul>
      <ul class="widget widget-menu unstyled">
         <li><a href="brands.php"><i class="menu-icon icon-sign-blank"></i> Brands </a></li>
		 <li><a class="collapsed" data-toggle="collapse" href="#categories"><i class="menu-icon icon-th-large"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Categories </a>
			<ul id="categories" class="collapse unstyled">
			<li><a href="category.php"><i class="menu-icon icon-hand-right"></i> Add Category </a></li>
            <li><a href="subcategory.php"><i class="menu-icon icon-hand-right"></i>Sub Category </a></li>
			</ul>
		 </li>
		 <li><a class="collapsed" data-toggle="collapse" href="#products"><i class="menu-icon icon-th"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Products </a>
			<ul id="products" class="collapse unstyled">
			<li><a href="product.php"><i class="menu-icon icon-hand-right"></i>Add Product </a></li>
			<li><a href="manage-products.php"><i class="menu-icon icon-hand-right"></i>Manage Products </a></li>
			</ul>
		 </li>
         <li><a href="cashoff.php"><i class="menu-icon icon-table"></i>Cashoff Payment </a></li>
      </ul>
      <!--/.widget-nav-->
      <ul class="widget widget-menu unstyled">
         <li><a class="collapsed" data-toggle="collapse" href="#basicPages"><i class="menu-icon icon-cogs"></i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>Basic Setting </a>
			<ul id="basicPages" class="collapse unstyled">
			<li><a href="basic.php"><i class="icon-hand-right"></i>Company Info.</a></li>
			<li><a href="eticket.php"><i class="icon-hand-right"></i>Ticket Info.</a></li>
			<li><a href="images.php"><i class="icon-hand-right"></i>Ads Images</a></li>
			</ul>
		 </li>
         <li>
            <a href="logout.php">
            <i class="menu-icon icon-signout"></i>
            Logout
            </a>
         </li>
      </ul>
   </div>
   <!--/.sidebar-->
</div>
<!--/.span3-->