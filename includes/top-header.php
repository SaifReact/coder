<?php 
   session_start();
?>

<div class="top-bar animate-dropdown">
   <div class="container">
       <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-10 cnt-account">
                <ul class="list-unstyled">
               <?php if(strlen($_SESSION['login']))
                  {   ?>
               <li><a href="account.php"><i class="icon fa fa-user"></i>Welcome -<?php echo htmlentities($_SESSION['username']);?></a></li>
               <?php } ?>
               <?php $ret=mysqli_query($con, "select * from basic"); while ($row=mysqli_fetch_array($ret)) { ?>
               <li><a href="#"><i class="icon fa fa-mobile"></i>+88 <?php echo htmlentities($row['phone1']);?></a></li>
               <li><a href="#"><i class="icon fa fa-envelope"></i><?php echo htmlentities($row['email']);?></a></li>
               <?php } ?>
               <!--<li><a href="account.php"><i class="icon fa fa-user"></i>Account</a></li>
               <li><a href="wishlist.php"><i class="icon fa fa-heart"></i>Wishlist</a></li>-->
               <li><a href="cart.php"><i class="icon fa fa-shopping-cart"></i>Contact</a></li>
               <?php if(strlen($_SESSION['login'])==0)
                  {   ?>
               <li><a href="login.php"><i class="icon fa fa-sign-in"></i>Login</a></li>
               <?php }
                  else{ ?>
               <li><a href="logout.php"><i class="icon fa fa-sign-out"></i>Logout</a></li>
               <?php } ?>	
            </ul>
           </div>
           <div class="col-xs-12 col-sm-12 col-md-2 cnt-block">
               <ul class="list-unstyled list-inline">
               <li class="dropdown dropdown-small">
                  <a href="track-orders.php" class="dropdown-toggle" ><span class="key">Track Order</b></a>
               </li>
                </ul>
           </div>
       </div>
      
      <!-- /.header-top-inner -->
   </div>
   <!-- /.container -->
</div>
<!-- /.header-top -->