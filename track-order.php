<?php
   session_start();
   include_once 'includes/config.php';
   $oid=$_GET['orid'];
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
      <title>Track Order</title>
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
                     <td><a href="index.php">
                   <?php
                   $sql=mysqli_query($con,"select * from basic where id='1'");
                	while($row=mysqli_fetch_array($sql))
                	{	?>
                  <img src="admin/logo/<?php echo $row['id'];?>/<?php echo $row['logo'];?>"  alt="<?php if(isset($compName)){ echo $compName;}?>"/>
                  <?php } ?>
               </a></td>
                     <td><?php if(isset($address)){ echo $address.". ";}?><br>
                     Phone: <?php if(isset($phone1)){ echo $phone1.". ";}?>, <?php if(isset($phone2)){ echo $phone2.". ";}?><br>
                     E-Mail: <?php if(isset($email)){ echo $email.". ";}?></td>
                 </tr>
                 
                 <tr>
                  <td><b>Order ID</b></td>
                  <td><?php echo $oid;?></td>
                </tr>
                
             </table>
             
             <table class="table table-bordered">
                <thead>
                
                                 <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Image</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th style="text-align:right">Total</th>
                                 </tr>
                              </thead>
               
               
               <?php 
                  $ret = mysqli_query($con,"SELECT products.id as proid, products.productName as proname, products.productImage1 as pimg, products.productPrice as proprice, orders.quantity as qnt FROM products join orders on products.id = orders.productId WHERE orderId='$oid'");
                       $cnt=1;
                       while($row=mysqli_fetch_array($ret))
                        {
                       ?>
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $row['proname'];?></td>
                  <td><img src="admin/productimages/<?php echo $row['proid'];?>/<?php echo $row['pimg'];?>" alt="" width="50px" height="50px"></td>
                  <td><?php echo $qty=$row['qnt'];?></td>
                  <td><?php echo $price=$row['proprice'];?></td>
                  <td style="text-align:right"><?php echo ($qty*$price);?></td>
                </tr>
               
              
               <?php $cnt=$cnt+1; } ?>
               
               <?php 
                  $ret1 = mysqli_query($con,"SELECT Distinct payment.paymentMethod as paymethod, payment.payAmount as payamount, payment.dueAmount as dueamount, payment.fullAmount as fullamount FROM payment join orders on payment.orderId = orders.orderId WHERE orders.orderId='$oid'");

                       while($row1=mysqli_fetch_array($ret1))
                        {
                       ?>
                   <tr>
                        <td colspan="6">Payment Method: <?php echo $row1['paymethod'];?></td>
                   </tr>
                   <tr>
                       <td colspan="5" style="text-align:right">Paid Amount</td>
                       <td style="text-align:right"><?php echo $row1['payamount'];?></td>
                   </tr>
                   
                   <tr>
                       <td colspan="5" style="text-align:right; color:#FF0000;">Due Amount</td>
                       <td style="text-align:right; color:#FF0000;"><?php echo $row1['dueamount'];?></td>
                   </tr>
                   
                   <?php  
                        $total = $row1['fullamount'];
                        $charge = 0;
                        
                        if ($total>30 && $total<=500){    
                            $charge = 40;    
                        }    
                        else if ($total>=501 && $total<=1500) {    
                            $charge = 20;   
                        }    
                        else if ($total>=1501 && $total<=2000) {    
                           $charge = 10;   
                        }    
                        else if ($total>=5000) {    
                            $charge = 100;   
                        }    
                       else {    
                            $charge = 0;   
                        }    
                    ?>
                   
                   <tr>
                       <td colspan="5" style="text-align:right">Delivery Charge</td>
                       <td style="text-align:right"><?php echo $charge;?></td>
                   </tr>
                   
                   <tr>
                       <td colspan="5" style="text-align:right">Total Amount</td>
                       <td style="text-align:right"><?php echo ($total+$charge);?></td>
                   </tr>
                    
                   
               <?php } ?>
               
            </table>
             
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr height="50">
                  <td colspan="2" class="fontkink2" style="padding-left:0px;">
                     <div class="fontpink2"> <b>Update Order !</b></div>
                  </td>
               </tr>

               <?php 
                  $ret = mysqli_query($con,"SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
                       while($row=mysqli_fetch_array($ret))
                        {
                       ?>
               <tr height="20">
                  <td class="fontkink1" ><b>At Date:</b></td>
                  <td  class="fontkink"><?php echo $row['postingDate'];?></td>
               </tr>
               <tr height="20">
                  <td  class="fontkink1"><b>Status:</b></td>
                  <td  class="fontkink"><?php echo $row['status'];?></td>
               </tr>
               <tr height="20">
                  <td  class="fontkink1"><b>Remark:</b></td>
                  <td  class="fontkink"><?php echo $row['remark'];?></td>
               </tr>
               <tr>
                  <td colspan="2">
                     <hr />
                  </td>
               </tr>
               <?php } ?>
               <?php 
                  $st='Delivered';
                     $rt = mysqli_query($con,"SELECT * FROM orders WHERE orderId='$oid'");
                       while($num=mysqli_fetch_array($rt))
                       {
                       $currrentSt=$num['status'];
                     }
                       if($st==$currrentSt)
                       { ?>
               <tr>
                  <td colspan="2"><b>
                     Product Delivered </b>
                  </td>
                  <?php }else  {
                     ?>
               
               
               <?php } ?>
            </table>
         </form>
      </div>
   </body>
</html>