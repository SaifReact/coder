<?php
   session_start();
   error_reporting(0);
   include('includes/config.php');
   
   if(isset($_POST['change']))
   {
       $email=$_POST['email'];
       $contact=$_POST['contact'];
       $password=md5($_POST['password']);
   $query=mysqli_query($con,"SELECT * FROM users WHERE contactno='$contact'");
   $num=mysqli_fetch_array($query);
   if($num>0)
   {
   $extra="forgot-password.php";
   mysqli_query($con,"update users set password='$password' WHERE contactno='$contact' ");
   $host=$_SERVER['HTTP_HOST'];
   $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
   header("location:http://$host$uri/$extra");
   $_SESSION['errmsg']="Password Changed Successfully";
   exit();
   }
   else
   {
   $extra="forgot-password.php";
   $host  = $_SERVER['HTTP_HOST'];
   $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
   header("location:http://$host$uri/$extra");
   $_SESSION['errmsg']="Invalid Contact No";
   exit();
   }
   }
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <?php include( 'includes/head.php');?>
   <body class="cnt-home">
      <!-- ============================================== HEADER ============================================== -->
      <header class="header-style-1">
         <!-- ============================================== TOP MENU ============================================== -->
         <?php include('includes/top-header.php');?>
         <!-- ============================================== TOP MENU : END ============================================== -->
         <?php include('includes/main-header.php');?>
         <!-- ============================================== NAVBAR ============================================== -->
         <?php include('includes/menu-bar.php');?>
         <!-- ============================================== NAVBAR : END ============================================== -->
      </header>
      <!-- ============================================== HEADER : END ============================================== -->
      <div class="breadcrumb">
         <div class="container">
            <div class="breadcrumb-inner">
               <ul class="list-inline list-unstyled">
                  <li><a href="home.html">Home</a></li>
                  <li class='active'>Forgot Password</li>
               </ul>
            </div>
            <!-- /.breadcrumb-inner -->
         </div>
         <!-- /.container -->
      </div>
      <!-- /.breadcrumb -->
      <div class="body-content outer-top-bd">
         <div class="container">
            <div class="sign-in-page inner-bottom-sm">
               <div class="row">
                  <!-- Sign-in -->			
                  <div class="col-md-6 col-sm-6 sign-in">
                     <h4 class="">Forgot password (পাসওয়ার্ড ভুলে গেছেন)</h4>
                     <form class="register-form outer-top-xs" name="register" method="post">
                        <span style="color:red;" >
                        <?php
                           echo htmlentities($_SESSION['errmsg']);
                           ?>
                        <?php
                           echo htmlentities($_SESSION['errmsg']="");
                           ?>
                        </span>
                        <div class="form-group">
                           <label class="info-title" for="exampleInputPassword1">Contact No. (মোবাইল নং)  <span>*</span></label>
                           <input type="text" name="contact" class="form-control unicase-form-control text-input" id="contact" required>
                        </div>
                        <div class="form-group">
                           <label class="info-title" for="exampleInputEmail1">Email Address (ইমেল ঠিকানা) </label>
                           <input type="email" name="email" class="form-control unicase-form-control text-input" id="exampleInputEmail1"  >
                        </div>
                        <div class="form-group">
                           <label class="info-title" for="password">Password (পাসওয়ার্ড) <span>*</span></label>
                           <input type="password" class="form-control unicase-form-control text-input" id="password" name="password"  required >
                        </div>
                        <div class="form-group">
                           <label class="info-title" for="confirmpassword">Confirm Password (পাসওয়ার্ড নিশ্চিত করুন) <span>*</span></label>
                           <input type="password" class="form-control unicase-form-control text-input" id="confirmpassword" name="confirmpassword" required >
                        </div>
                        <button type="submit" class="btn-upper btn btn-success checkout-page-button" name="change">Change - পরিবর্তন</button>
                     </form>
                  </div>
                  <!-- Sign-in -->
                  <!-- create a new account -->			
               </div>
               <!-- /.row -->
            </div>
            <?php include('includes/brands-slider.php');?>
         </div>
      </div>
      <?php include( 'includes/footer-top.php');?>
      <?php include('includes/footer.php');?>
      <?php include( 'includes/js.php');?>
   </body>
</html>