<?php
   session_start();
   include('../../includes/config.php');
   if(strlen($_SESSION['alogin'])== 0)
   	{	
   header('location:index.php');
   }
   else{   
   
   ?>

<!DOCTYPE html>
<html lang="en">

<?php include('share/head.php');?>

<body class="animsition">
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <?php include('share/menu.php');?>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                <a href="#">
                                    <img src="images/icon/logo-white.png" alt="CoolAdmin" />
                                </a>
                            </div>
                            <div class="header-button2">
                                <div class="header-button-item js-item-menu">
                                    <i class="zmdi zmdi-search"></i>
                                    <div class="search-dropdown js-dropdown">
                                        <form action="">
                                            <input class="au-input au-input--full au-input--h65" type="text" placeholder="Search for datas &amp; reports..." />
                                            <span class="search-dropdown__icon">
                                                <i class="zmdi zmdi-search"></i>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                                <div class="header-button-item has-noti js-item-menu">
                                    <i class="zmdi zmdi-notifications"></i>
                                    <div class="notifi-dropdown js-dropdown">
                                        <div class="notifi__title">
                                            <p>You have 3 Notifications</p>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                                <i class="zmdi zmdi-email-open"></i>
                                            </div>
                                            <div class="content">
                                                <p>You got a email notification</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c2 img-cir img-40">
                                                <i class="zmdi zmdi-account-box"></i>
                                            </div>
                                            <div class="content">
                                                <p>Your account has been blocked</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c3 img-cir img-40">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="content">
                                                <p>You got a new file</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__footer">
                                            <a href="#">All notifications</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-button-item mr-0 js-sidebar-btn">
                                    <i class="zmdi zmdi-menu"></i>
                                </div>
                                <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-settings"></i>Setting</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-money-box"></i>Billing</a>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-globe"></i>Language</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-pin"></i>Location</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-email"></i>Email</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-notifications"></i>Notifications</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
			<?php include('share/side-menu.php');?>
            
            <!-- END HEADER DESKTOP-->

            <!-- STATISTIC-->
            <section class="statistic">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
							<div class="col-md-6 col-lg-4">
                                <div class="statistic__item">
								<?php
								  $f1="00:00:00";
								  $from=date('Y-m-d')." ".$f1;
								  $t1="23:59:59";
								  $to=date('Y-m-d')." ".$t1;
								  $result = mysqli_query($con,"SELECT * FROM orders where orderStatus = 'N' and orderDate Between '$from' and '$to'");
								  $tOrder = mysqli_num_rows($result);
								  {
								  ?>
                                 <h2 class="number"><?php echo htmlentities($tOrder); ?></h2>
									<?php } ?>
                                    <span class="desc">Today's Order</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="statistic__item">
								<?php	
								  $status='in Process';									 
								  $ret = mysqli_query($con,"SELECT * FROM orders where orderStatus='$status'");
								  $pOrder = mysqli_num_rows($ret);
								  {?>
                                  <h2 class="number"><?php echo htmlentities($pOrder); ?></h2>
								  <?php } ?>
                                    <span class="desc">Pending Order</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-account-o"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-4">
                                <div class="statistic__item">
								<?php	
								  $status='Delivered';									 
								  $rt = mysqli_query($con,"SELECT * FROM orders where orderStatus='$status'");
								  $dOrder = mysqli_num_rows($rt);
								  {?>
                                   <h2 class="number"><?php echo htmlentities($dOrder); ?></h2>
								  <?php } ?>
                                    <span class="desc">Delivered Order</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-calendar-note"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="statistic__item">
								<?php										 
                                  $brands = mysqli_query($con,"SELECT * FROM brands");
                                  $brName = mysqli_num_rows($brands);
                                       {?>
                                    <h2 class="number"><?php echo htmlentities($brName); ?></h2>
									   <?php } ?>
                                    <span class="desc">Brands</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                </div>
                            </div>
							 <div class="col-md-6 col-lg-3">
                                <div class="statistic__item">
								<?php										 
                                  $cats = mysqli_query($con,"SELECT * FROM category");
                                  $catName = mysqli_num_rows($cats);
                                       {?>
                                    <h2 class="number"><?php echo htmlentities($catName); ?></h2>
									   <?php } ?>
                                    <span class="desc">Category</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                </div>
                            </div>
							 <div class="col-md-6 col-lg-3">
                                <div class="statistic__item">
								<?php										 
                                  $scats = mysqli_query($con,"SELECT * FROM subCategory");
                                  $scatName = mysqli_num_rows($scats);
                                       {?>
                                    <h2 class="number"><?php echo htmlentities($scatName); ?></h2>
									   <?php } ?>
                                    <span class="desc">Sub Category</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                </div>
                            </div>
							 <div class="col-md-6 col-lg-3">
                                <div class="statistic__item">
								<?php										 
                                  $pros = mysqli_query($con,"SELECT * FROM products");
                                  $proName = mysqli_num_rows($pros);
                                       {?>
                                    <h2 class="number"><?php echo htmlentities($proName); ?></h2>
									   <?php } ?>
                                    <span class="desc">Products</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6 col-lg-4">
                                <div class="statistic__item">
								<?php										 
                                  $user = mysqli_query($con,"SELECT * FROM users");
                                  $users = mysqli_num_rows($user);
                                       {?>
                                    <h2 class="number"><?php echo htmlentities($users); ?></h2>
									   <?php } ?>
                                    <span class="desc">Customers</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6 col-lg-4">
                                <div class="statistic__item">
								<?php										 
                                  $pros = mysqli_query($con,"SELECT * FROM products");
                                  $proName = mysqli_num_rows($pros);
                                       {?>
                                    <h2 class="number"><?php echo htmlentities($proName); ?></h2>
									   <?php } ?>
                                    <span class="desc">Delivery Man</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6 col-lg-4">
                                <div class="statistic__item">
								<?php
                                       $f11="00:00:00";
                                       $from1=date('Y-m-d')." ".$f11;
                                       $t11="23:59:59";
                                       $to1=date('Y-m-d')." ".$t11;
                                       $result1 = mysqli_query($con,"SELECT * FROM userlog where loginTime Between '$from1' and '$to1'");
                                       $userLog = mysqli_num_rows($result1);
                                       {
                                       ?>
                                    <h2 class="number"><?php echo htmlentities($userLog); ?></h2>
									   <?php } ?>
                                    <span class="desc">User Log</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END STATISTIC-->

            <?php include('share/footer.php');?>
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <?php include('share/js.php');?>

</body>
   <?php } ?>