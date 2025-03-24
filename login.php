<?php
   session_start();
   error_reporting(0);
   include('includes/config.php');
   // Code user Registration
   if(isset($_POST['submit']))
   {
   $name=$_POST['fullname'];
   $email=$_POST['emailid'];
   $contactno=$_POST['contactno'];
   $password=md5($_POST['password']);
   $query=mysqli_query($con,"insert into users(name,email,contactno,password) values('$name','$email','$contactno','$password')");
   if($query)
   {
   	echo "<script>alert('You are successfully register');</script>";
   }
   else{
   echo "<script>alert('Not register something went worng');</script>";
   }
   }
   // Code for User login
   if(isset($_POST['login']))
   {
      $contactno=$_POST['contactno'];
      $password=md5($_POST['password']);
   $query=mysqli_query($con,"SELECT * FROM users WHERE contactno='$contactno' and password='$password'");
   $num=mysqli_fetch_array($query);
   if($num>0)
   {
   $extra="cart.php";
   $_SESSION['login']=$_POST['contactno'];
   $_SESSION['id']=$num['id'];
   $_SESSION['username']=$num['name'];
   $uip=$_SERVER['REMOTE_ADDR'];
   $status=1;
   $log=mysqli_query($con,"insert into userlog(userEmail,userip,status) values('".$_SESSION['login']."','$uip','$status')");
   $host=$_SERVER['HTTP_HOST'];
   $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
   header("location:http://$host$uri/$extra");
   exit();
   }
   else
   {
   $extra="login.php";
   $contactno=$_POST['contactno'];
   $uip=$_SERVER['REMOTE_ADDR'];
   $status=0;
   $log=mysqli_query($con,"insert into userlog(userEmail,userip,status) values('$contactno','$uip','$status')");
   $host  = $_SERVER['HTTP_HOST'];
   $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
   header("location:http://$host$uri/$extra");
   $_SESSION['errmsg']="Invalid email id or Password";
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
                  <li><a href="index.php">Home</a></li>
                  <li class='active'>Authentication</li>
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
                     <h4 class="">sign in (সাইন ইন করুন)</h4>
                     
                     <form class="register-form outer-top-xs" method="post">
                        <span style="color:red;" >
                        <?php
                           echo htmlentities($_SESSION['errmsg']);
                           ?>
                        <?php
                           echo htmlentities($_SESSION['errmsg']="");
                           ?>
                        </span>
                        <div class="form-group">
                           <label class="info-title" for="exampleInputEmail1">Contact No. (মোবাইল নং) <span>*</span></label>
                           <input type="contactno" name="contactno" class="form-control unicase-form-control text-input" id="exampleInputEmail1" >
                        </div>
                        <div class="form-group">
                           <label class="info-title" for="exampleInputPassword1">Password (পাসওয়ার্ড) <span>*</span></label>
                           <input type="password" name="password" class="form-control unicase-form-control text-input" id="exampleInputPassword1" >
                        </div>
                        <div class="radio outer-xs">
                           <a href="forgot-password.php" class="forgot-password pull-right">Forgot your Password? (আপনি কি পাসওয়ার্ড ভুলে গেছেন?)</a>
                        </div>
                        <button type="submit" class="btn-upper btn btn-success checkout-page-button" name="login">Login - প্রবেশ করুন</button>
                     </form>
                  </div>
                  <!-- Sign-in -->
                  <!-- create a new account -->
                  <div class="col-md-6 col-sm-6 create-new-account">
                     <h4 class="checkout-subtitle" style="font-size:18px;">create a new account (একটি নতুন অ্যাকাউন্ট তৈরি করুন)</h4>
                     <form class="register-form outer-top-xs" role="form" method="post" name="register" onSubmit="return valid();">
                        <div class="form-group">
                           <label class="info-title" for="fullname">Full Name (পুরো নাম) <span>*</span></label>
                           <input type="text" class="form-control unicase-form-control text-input" id="fullname" name="fullname" required="required">
                        </div>
                        <div class="form-group">
                           <label class="info-title" for="contactno">Contact No. (মোবাইল নং)   <span>*</span></label>
                           <input type="text" class="form-control unicase-form-control text-input" id="contactno" name="contactno" maxlength="11" required >
                        </div>
                        <div class="form-group">
                           <label class="info-title" for="exampleInputEmail2">Email Address (ইমেল ঠিকানা)</label>
                           <input type="email" class="form-control unicase-form-control text-input" id="email"  name="emailid">
                           <span id="user-availability-status1" style="font-size:12px;"></span>
                        </div>
                        <div class="form-group">
                           <label class="info-title" for="password">Password (পাসওয়ার্ড) <span>*</span></label>
                           <input type="password" class="form-control unicase-form-control text-input" id="password" name="password"  required >
                        </div>
                        <div class="form-group">
                           <label class="info-title" for="confirmpassword">Confirm Password (পাসওয়ার্ড নিশ্চিত করুন) <span>*</span></label>
                           <input type="password" class="form-control unicase-form-control text-input" id="confirmpassword" name="confirmpassword" required >
                        </div>
                        <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button" id="submit">Sign Up - নিবন্ধন করুন</button>
                     </form>
                     
                  </div>
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