<?php
   session_start();
   
   include_once 'include/config.php';
   if(strlen($_SESSION['alogin'])==0)
     { 
   header('location:index.php');
   }
   else{
   $oid=$_GET['id'];
   //if(isset($_POST['submit2'])){
   //$status='Print';
   //$remark='Product Delivered Within 24 Hours.';//space char
   
   //$query=mysqli_query($con,"insert into ordertrackhistory(orderId,status,remark) values('$oid','$status','$remark')");
  // $sql=mysqli_query($con,"update orders set orderStatus='$status' where orderId='$oid'");
  // echo "<script>alert('Order updated sucessfully...');</script>";
   //}
   //}
   
    ?>
<script language="javascript" type="text/javascript">
   function f2()
   {
   window.close();
   }ser
   function f3()
   {
   window.print(); 
   }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>View User</title>
      <link href="style.css" rel="stylesheet" type="text/css" />
      <link href="anuj.css" rel="stylesheet" type="text/css">
      <style>
          table { 
	width: 750px; 
	border-collapse: collapse; 
	margin:50px auto;
	}

/* Zebra striping */
tr:nth-of-type(odd) { 
	background: #eee; 
	}

th { 
	background: #3498db; 
	color: white; 
	font-weight: bold; 
	}

td, th { 
	padding: 10px; 
	border: 1px solid #ccc; 
	text-align: left; 
	font-size: 18px;
	}

/* 
Max width before this PARTICULAR table gets nasty
This query will take effect for any screen smaller than 760px
and also iPads specifically.
*/
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	table { 
	  	width: 100%; 
	}

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}

	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		/* Label the data */
		content: attr(data-column);

		color: #000;
		font-weight: bold;
	}

}
      </style>
   </head>
   <body>
      <div style="margin-left:50px;">
          
         <form name="updateticket" id="updateticket" method="post">
             <table>
                 <tr>
                     <td><a href="manage-users.php">
                   <?php
                    $sql=mysqli_query($con,"select * from basic where id='1'");
                	while($row=mysqli_fetch_array($sql))
                	{	?>
                  <img src="logo/<?php echo $row['id'];?>/<?php echo $row['logo'];?>"  alt="<?php if(isset($compName)){ echo $compName;}?>"/>
                  <?php } ?>
               </a></td>
                     <td><?php if(isset($address)){ echo $address.". ";}?><br>
                     Phone: <?php if(isset($phone1)){ echo $phone1.". ";}?>, <?php if(isset($phone2)){ echo $phone2.". ";}?><br>
                     E-Mail: <?php if(isset($email)){ echo $email.". ";}?></td>
                 </tr>
                 
                 <tr>
                  <td><b>User ID</b></td>
                  <td><?php echo $oid;?></td>
                </tr>
                <tr>
                    <td><b>Customer Info.</b></td>
                    <?php 
                     $ret = mysqli_query($con,"SELECT Distinct users.name as usrname, users.contactno as usrcontact, users.email as usremail, users.billingAddress as address, users.cashback as cb FROM users WHERE users.id='$oid'");
                       while($row=mysqli_fetch_array($ret))
                        {
                       ?>
                    <td><b><?php echo $row['usrname'];?></b><br>
                     Address: <?php echo $row['address'];?><br>
                     Phone: <?php echo $row['usrcontact'];?><br>
                     E-Mail: <?php echo $row['usremail'];?><br>
                     </tr>
                     <tr>
                     <td><b style="color:#FF0000;">CashBack Amount</b></td>
                     <td><b style="color:#FF0000;"><?php echo $row['cb'];?></b></td>
                     </tr>
                    <?php } ?>
             </table>

            <table class="table table-bordered">
                <thead>
                
                                 <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Product Name</th>
                                    <th>Image</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Charges</th>
                                    <th style="text-align:right">Total</th>
                                    <th>Status</th>
                                 </tr>
                              </thead>
               <?php 
                  $ret = mysqli_query($con,"SELECT products.id as proid, products.productName as proname, products.productImage1 as pimg, products.productPrice as proprice, products.shippingCharge as delcharge, orders.quantity as qnt, orders.orderId as orid, orders.orderStatus as status FROM products join orders on products.id = orders.productId WHERE orders.userId='$oid'");
                       $cnt=1;
                       while($row=mysqli_fetch_array($ret))
                        {
                       ?>
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $row['orid'];?></td>
                  <td><?php echo $row['proname'];?></td>
                  <td><img src="productimages/<?php echo $row['proid'];?>/<?php echo $row['pimg'];?>" alt="" width="50px" height="50px"></td>
                  <td><?php echo $qty=$row['qnt'];?></td>
                  <td><?php echo $price=$row['proprice'];?></td>
                  <td><?php echo $charge=$row['delcharge'];?></td>
                  <td style="text-align:right"><?php echo (($qty*$price)+$charge);?></td>
                  <td><?php echo $row['status'];?></td>
                </tr>
               <?php $cnt=$cnt+1; } ?>
            </table>
         </form>
      </div>
      <table>
          
      </table>
   </body>
</html>
<?php } ?>