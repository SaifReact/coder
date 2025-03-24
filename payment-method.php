<?php 
   session_start();
   error_reporting(0);
   include('includes/config.php');
   if(strlen($_SESSION['login'])==0)
       {   
   header('location:login.php');
   }
   else{
   	if (isset($_POST['submit'])) {
   	    
   	    if(isset($_POST['paymethod'])=='CBM') {
   	        
   	        $cashback = $_POST['cashback'];
   	        $value = $_POST['value'];
   	        $cashbackpay = $cashback * $value;
   	        
   
   		mysqli_query($con,"update orders set paymentMethod='".$_POST['paymethod']."', payment='$cashbackpay' where userId='".$_SESSION['id']."' and paymentMethod is null ");
   		unset($_SESSION['cart']);
   		header('location:order-history.php');
   	    }
   	}
   	
   ?>
<!DOCTYPE html>
<html lang="en">
   <?php include( 'includes/head.php');?>
    
   <body class="cnt-home">
       
      <header class="header-style-1">
         <?php include('includes/top-header.php');?>
         <?php include('includes/main-header.php');?>
         <?php include('includes/menu-bar.php');?>
      </header>
      <div class="breadcrumb">
         <div class="container">
            <div class="breadcrumb-inner">
               <ul class="list-inline list-unstyled">
                  <li><a href="home.html">Home</a></li>
                  <li class='active'>Payment Method</li>
               </ul>
            </div>
            <!-- /.breadcrumb-inner -->
         </div>
         <!-- /.container -->
      </div>
      <!-- /.breadcrumb -->
      <div class="body-content outer-top-bd">
         <div class="container">
            <div class="checkout-box faq-page inner-bottom-sm">
               <div class="row">
                  <div class="col-md-12">
                     <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">
                           <!-- panel-heading -->
                           <div class="panel-heading">
                              <h4 class="unicase-checkout-title">
                                 <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                 Select your Payment Method
                                 </a>
                              </h4>
                           </div>
                           <!-- panel-heading -->
                           <div id="collapseOne" class="panel-collapse collapse in">
                              <!-- panel-body  -->
                              <div class="panel-body">
                                 <form name="payment" method="post">
                                     <?php
                   $sql=mysqli_query($con,"select * from users where id='".$_SESSION['id']."'");
                	while($row=mysqli_fetch_array($sql))
                	{	?>
                                     <input type="hidden" name="cashback" id="cashback" value="<?php echo $row['cashback']; ?>" >
                                     <?php } ?>
                                    <input type="radio" name="paymethod" value="COD" checked="checked"> Cash On Delivery
                                    <?php
                   $sql1=mysqli_query($con,"select * from cashoffpayment where id='1'");
                	while($row1=mysqli_fetch_array($sql1))
                	{	?>
                                    <input type="radio" name="paymethod" value="CBM"> Cashback Money (using <?php echo $row1['cashoff']; ?>%)<br><br>
                                    <input type="hidden" name="value" id="value" value="<?php echo $row1['value']; ?>" >
                                    <?php } ?>
                                    <input type="submit" value="Payment- প্রদান করুন" name="submit" class="btn btn-successs">
                                 </form>
                              </div>
                              <!-- panel-body  -->
                           </div>
                           <!-- row -->
                        </div>
                        <!-- checkout-step-01  -->
                     </div>
                     <!-- /.checkout-steps -->
                  </div>
               </div>
               <!-- /.row -->
            </div>
            <!-- /.checkout-box -->
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
      
      <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script type="text/javascript">
         function sum() {
             var cashback1 = document.getElementById('cashback').value;
             alert(cashback1);
             var offvalue = document.getElementById('value').value;
             alert(offvalue);
             var result = parseInt(cashback1) * parseInt(offvalue);
             alert(result);
         if (!isNaN(result)) {
                 document.getElementById('cashbackpay').value = result;
             }
         
         }
      </script>
   </body>
</html>
<?php } ?>