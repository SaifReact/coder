<?php
   session_start();
   //error_reporting(0);
   include('includes/config.php');
   if(strlen($_SESSION['login'])==0)
       {   
   header('location:.php');
   }
   else{
   	// code for billing address updation
   	if(isset($_POST['update']))
   	{
   		$baddress=$_POST['billingaddress'];
   		$query=mysqli_query($con,"update users set billingAddress='$baddress' where id='".$_SESSION['id']."'");
   		if($query)
   		{
   echo "<script>alert('Billing Address has been updated');</script>";
   		}
   	}
     
   ?>
<!DOCTYPE html>
<html lang="en">
   <?php include( 'includes/head.php');?>
   <body class="cnt-home">
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
                  <li><a href="#">Home</a></li>
                  <li class='active'>Check Lists</li>
               </ul>
            </div>
            <!-- /.breadcrumb-inner -->
         </div>
         <!-- /.container -->
      </div>
      <!-- /.breadcrumb -->
      <div class="body-content outer-top-bd">
         <div class="container">
            <div class="checkout-box inner-bottom-sm">
               <div class="row">
                  <div class="col-md-8">
                     <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">
                           <!-- panel-heading -->
                           <div class="panel-heading">
                              <h4 class="unicase-checkout-title">
                                 <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                 <span>1</span>Billing Address
                                 </a>
                              </h4>
                           </div>
                           <!-- panel-heading -->
                           <div id="collapseOne" class="panel-collapse collapse in">
                              <!-- panel-body  -->
                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-md-12 col-sm-12 already-registered-login">
                                       <?php
                                          $query=mysqli_query($con,"select * from users where id='".$_SESSION['id']."'");
                                          while($row=mysqli_fetch_array($query))
                                          {
                                          ?>
                                       <form class="register-form" role="form" method="post">
                                          <div class="form-group">
                                             <label class="info-title" for="Billing Address">Billing Address<span>*</span></label>
                                             <textarea class="form-control unicase-form-control text-input"  name="billingaddress" required="required"><?php echo $row['billingAddress'];?></textarea>
                                          </div>
                                          
                                          <button type="submit" name="update" class="btn-upper btn btn-primary checkout-page-button">Update</button>
                                       </form>
                                       <?php } ?>
                                    </div>
                                    <!-- already-registered-login -->		
                                 </div>
                              </div>
                              <!-- panel-body  -->
                           </div>
                           <!-- row -->
                        </div>
                        <!-- checkout-step-01  -->
                       
                     </div>
                     <!-- /.checkout-steps -->
                  </div>
                  <?php include('includes/myaccount-sidebar.php');?>
               </div>
               <!-- /.row -->
            </div>
            <!-- /.checkout-box -->
            <?php include('includes/brands-slider.php');?>
         </div>
      </div>
      <?php include( 'includes/footer-top.php');?>
      <?php include('includes/footer.php');?>
      <?php include( 'includes/js.php');?>
   </body>
</html>
<?php } ?>