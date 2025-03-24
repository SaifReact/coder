<?php 
   session_start();
   error_reporting(0);
   include('includes/config.php');
   if(isset($_POST['submit'])){
   		if(!empty($_SESSION['cart'])){
   		foreach($_POST['quantity'] as $key => $val){
   			if($val==0){
   				unset($_SESSION['cart'][$key]);
   			}else{
   				$_SESSION['cart'][$key]['quantity']=$val;
   
   			}
   		}
   		//	echo "<script>alert('Your Cart hasbeen Updated');</script>";
   		}
   	}
   // Code for Remove a Product from Cart
   if(isset($_POST['remove_code']))
   	{
   
   if(!empty($_SESSION['cart'])){
   		foreach($_POST['remove_code'] as $key){
   			
   				unset($_SESSION['cart'][$key]);
   		}
   			echo "<script>alert('Remove From Shopping Cart..!');</script>";
   	}
   }
   // code for insert product in order table
   
   
   if(isset($_POST['ordersubmit'])) 
   {
   	
   if(strlen($_SESSION['login'])==0)
       {   
   header('location:login.php');
   }
   }
   
   if(isset($_POST['pay'])){
    $cashback = $_POST['CASHBACK'] + $_SESSION['cb']; //905+75=980
    $query = mysqli_query($con,"update users set cashback = '$cashback' where id='".$_SESSION['id']."'");
    $random = 'ORD'.rand(10,10000);
   	$quantity=$_POST['quantity'];
   	$pdd=$_SESSION['pid'];
   	$value=array_combine($pdd,$quantity);
   
   
   		foreach($value as $qty=> $val34){
            mysqli_query($con,"insert into orders(userId,productId,quantity,orderId,orderStatus) values('".$_SESSION['id']."','$qty','$val34','$random','N')");
        }
        
        $paymethod= $_POST ['paymethod'];
        
   if($paymethod=='COD'){
   $codvalue = $_POST['CODVALUE'];//0
   $fullAmount = $_SESSION['tp'];//430
   $dueAmount = $fullAmount - $codvalue;//430-0=430
   $query1=mysqli_query($con,"insert into payment(userId,orderId,paymentMethod,payAmount,dueAmount,fullAmount) values('".$_SESSION['id']."','$random','".$_POST['paymethod']."','$codvalue','$dueAmount','$fullAmount')");
   
   }
   else{
   $cashoff = $_POST['CASHBACK']; //905
   $value = $_POST['VALUE']; //.4
   $formCashback = $cashoff * $value; //362
   $updateCashoff = ($cashoff - $formCashback) + $_SESSION['cb'] ; //905-362=543
   $query1 = mysqli_query($con,"update users set cashback = '$updateCashoff' where id='".$_SESSION['id']."'");
   $fullAmount = $_SESSION['tp']; //430
   $dueAmount = $fullAmount - $formCashback; //430-362=68
   $query2=mysqli_query($con,"insert into payment(userId,orderId,paymentMethod,payAmount,dueAmount,fullAmount) values('".$_SESSION['id']."','$random','".$_POST['paymethod']."','$formCashback','$dueAmount','$fullAmount')");
   }
   unset($_SESSION['cart']);
   header('location:order-history.php');
   }
   
   
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
   <script type="text/javascript">
         function sum() {
             var subtotal = document.getElementById('subtotal').value;
             var delivery = document.getElementById('delicharge').value;
             var result = parseInt(subtotal) + parseInt(delivery);
         if (!isNaN(result)) {
                 document.getElementById('total').value = result;
             }
         }
      </script>
   
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
                  <li class='active'>Shopping Cart</li>
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
                           <?php
                              if(!empty($_SESSION['cart'])){
                              	?>
                           <table class="table table-bordered">
                              <thead>
                                 <tr>
                                    <th class="cart-romove item" width="5%">X</th>
                                    <th class="cart-description item">Product</th>
                                    <th class="cart-qty item">Quantity</th>
                                    <th class="cart-sub-total item">Price Per unit</th>
                                    <th class="cart-total last-item" style="text-align:right;">Total</th>
                                 </tr>
                              </thead>
                              <!-- /thead -->
                              <tbody>
                                 <?php
                                    $pdtid=array();
                                       $sql = "SELECT * FROM products WHERE id IN(";
                                    		foreach($_SESSION['cart'] as $id => $value){
                                    		$sql .=$id. ",";
                                    		}
                                    		$sql=substr($sql,0,-1) . ") ORDER BY id ASC";
                                    		$query = mysqli_query($con,$sql);
                                    		$totalprice=0;
                                    		$totalqunty=0;
                                    		$totalcashback=0;
                                    		if(!empty($query)){
                                    		while($row = mysqli_fetch_array($query)){
                                    			$quantity= $_SESSION['cart'][$row['id']]['quantity'];
                                    			$subtotal= $_SESSION['cart'][$row['id']]['quantity']*$row['productPrice'];//+$row['shippingCharge'];
                                                $totalprice += $subtotal;
                                                
                                    			$subcashback= $_SESSION['cart'][$row['id']]['quantity']*$row['cashback'];
                                    			$totalcashback +=$subcashback;
                                    			
                                    			$_SESSION['qnty']=$totalqunty+=$quantity;
                                    
                                    			array_push($pdtid,$row['id']);
                                    ?>
                                 <tr>
                                    <td class="romove-item"><input type="checkbox" name="remove_code[]" value="<?php echo htmlentities($row['id']);?>" /></td>
                                    <td class="cart-image" style="text-align:center;">
                                       <img src="admin/productimages/<?php echo $row['id'];?>/<?php echo $row['productImage1'];?>" alt="" width="100px" height="100px">
                                       <h4 class='cart-product-description'><a href="product-details.php?pid=<?php echo htmlentities($pd=$row['id']);?>" ><?php echo $row['productName'];
                                          $_SESSION['sid']=$pd;
                                        ?></a></h4>
                                       <div class="row">
                                          <div class="col-sm-12">
                                             <div class="rating rateit-small"></div>
                                             <br>
                                             <?php $rt=mysqli_query($con,"select * from productreviews where productId='$pd'");
                                                $num=mysqli_num_rows($rt);
                                                {
                                                ?>
                                             <div class="reviews">
                                                ( <?php echo htmlentities($num);?> Reviews )
                                             </div>
                                             <?php } ?>
                                          </div>
                                          
                                       </div>
                                    </td>
                                    <td class="cart-product-quantity">
                                       <div class="quant-input">
                                          <div class="arrows">
                                             <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                             <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                          </div>
                                          <input id="quantity[<?php echo $row['id']; ?>]" class="quantity_up_down" type="text" value="<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?>" name="quantity[<?php echo $row['id']; ?>]">
                                       </div>
                                    </td>
                                    <td class="cart-product-sub-total"><span class="cart-sub-total-price quantity_up_down_sub_total_price"><?php if(isset($currency)){ echo $currency.". ";}?> <?php echo $row['productPrice']; ?>.00</span></td>
                                    <!--<td class="cart-product-sub-total"><span class="cart-sub-total-price"><?php if(isset($currency)){ echo $currency.". ";}?><?php echo $row['shippingCharge']; ?>.00</span></td>-->
                                    <td class="cart-product-grand-total" style="font-weight:bold; text-align:right;"><span class="cart-grand-total-price  quantity_up_down_grand_total_price"><?php if(isset($currency)){ echo $currency.". ";}?><?php echo  $_SESSION['st']="$subtotal". ".00"; ?></span>
                                    </td>
                                 </tr>
                                 <?php } }
                                    $_SESSION['pid']=$pdtid;
                                    				?>
                              </tbody>
                              <tfoot style="background: #FFF;">
                                  
                                 <tr>
                                    <td colspan="2" style="font-size:16px; text-align:right; font-weight:bold; text-transform: uppercase; color: blue;">
                                       Cash Back Total
                                    </td>
                                    <td style="font-size:16px; text-align:right; font-weight:bold; text-transform: uppercase; color: blue;">
                                       <?php if(isset($currency)){ echo $currency.". ";}?><?php echo $_SESSION['cb']="$totalcashback". ".00"; ?>
                                    </td>
                                    <td style="font-size:16px; text-align:right; font-weight:bold; text-transform: uppercase; color: #5cb85c">
                                       Grand Total (Tk.)
                                    </td>
                                    <td style="font-size:16px; text-align:right; font-weight:bold; text-transform: uppercase; color: #5cb85c;">
                                        <?php if(isset($currency)){ echo $currency.". ";}?><?php echo $_SESSION['tp']="$totalprice". ".00"; ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="5">
                                       <div class="shopping-cart-btn">
                                          <span class="">
                                             <!--<a href="index.php" class="btn btn-upper btn-primary outer-left-xs">Continue Shopping</a>-->
                                             <input type="submit" name="submit" value="Update Cart" id="text" class="btn btn-upper btn-primary  outer-right-xs" >
                                             <button type="submit" name="ordersubmit" id="ordersubmit" class="btn btn-success pull-right">PROCCED TO LOGIN</button>
                                          </span>
                                       </div>
                                    </td>
                                 </tr>
                              </tfoot>
                              <!-- /tbody -->
                           </table>
                           <!-- /table -->
                     </div>
                  </div>
                  <div class="col-md-7 col-sm-12 estimate-ship-tax">
                  <table class="table table-bordered">
                  <thead>
                  <tr>
                  <th>
                  <span class="estimate-title">Billing Address</span>
                  </th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                  <td>
                  <div class="form-group">
                  <?php
                     $query=mysqli_query($con,"select * from users where id='".$_SESSION['id']."'");
                     while($row=mysqli_fetch_array($query))
                     {
                     ?>
                  <div class="form-group">
                  <label class="info-title" for="Billing Address">Address<span>*</span></label>
                  <textarea class="form-control unicase-form-control text-input"  name="billingaddress" required="required"><?php echo $row['billingAddress'];?></textarea>
                  </div>
                  <button type="submit" name="update" class="btn-upper btn btn-primary checkout-page-button">Update</button>
                  <?php } ?>
                  </div>
                  </td>
                  </tr>
                  </tbody><!-- /tbody -->
                  </table><!-- /table -->
                  <?php } else {
                     echo "Your shopping Cart is empty";
                     		}?>
                  </div>
                  <?php
                  if(strlen($_SESSION['login'])>0){ ?>
                  <div class="col-md-5 col-sm-12">
                  <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">
                           <!-- panel-heading -->
                           <div class="panel-heading">
                              <h4 class="unicase-checkout-title">
                                 <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                 Select Your Payment Method 
                                 </a>
                              </h4>
                           </div>
                           <!-- panel-heading -->
                           <div id="collapseOne" class="panel-collapse collapse in">
                              <!-- panel-body  -->
                              <div class="panel-body">
                                 <form name="payment" method="post">
                                      <input type="radio" name="paymethod" value="COD"  checked="checked"> Cash On Delivery<br><br>
                                      <input type="hidden" name="CODVALUE" value="0">
                                     <?php
                                       $sql=mysqli_query($con,"select * from users where id='".$_SESSION['id']."'");
                                    	while($row=mysqli_fetch_array($sql))
                                    	{	?>
                                     <input type="hidden" name="CASHBACK" id="cashback" value="<?php echo $row['cashback']; ?>" >
                                    <?php
                                       $sql1=mysqli_query($con,"select * from cashoffpayment where id='1'");
                                    	while($row1=mysqli_fetch_array($sql1))
                                    	{ if($row['cashback']>300){ 	?>
                                    <input type="radio" name="paymethod" value="CBM" > Cashback Money (Using <?php echo $row1['cashoff']; ?>%)<br><br>
                                    <?php  } ?>
                                    <input type="hidden" name="VALUE" id="value" value="<?php echo $row1['value']; ?>">
                                    <?php } ?>
                                    <?php } ?>
                                   
                                    <input type="submit" value="Payment- প্রদান করুন" class="btn btn-danger" name="pay" id="pay">
                                 </form>
                              </div>
                              <!-- panel-body  -->
                           </div>
                           <!-- row -->
                        </div>
                        <!-- checkout-step-01  -->
                     </div>
                  </div>	
                 <?php  } ?>
               </div>
            </div>
            </form>
            <?php echo include('includes/brands-slider.php');?>
         </div>
      </div>
      <?php include( 'includes/footer-top.php');?>
      <?php include('includes/footer.php');?>
      <?php include( 'includes/js.php');?>
   </body>
</html>