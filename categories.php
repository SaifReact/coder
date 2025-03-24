<?php
   session_start();
   error_reporting(0);
   include('includes/config.php');
   $scid=intval($_GET['scid']);
   if(isset($_GET['action']) && $_GET['action']=="add"){
   	$id=intval($_GET['id']);
   	if(isset($_SESSION['cart'][$id])){
   		$_SESSION['cart'][$id]['quantity']+=$_GET['quantity'];
   	}else{
   		$sql_p="SELECT * FROM products WHERE id={$id}";
   		$query_p=mysqli_query($con,$sql_p);
   		if(mysqli_num_rows($query_p)!=0){
   			$row_p=mysqli_fetch_array($query_p);
   			$_SESSION['cart'][$row_p['id']]=array("quantity" => $_GET['quantity'], "price" => $row_p['productPrice']);
   		//echo "<script type='text/javascript'> document.location ='category.php?cid=$cid'; </script>";
   		}else{
   			$message="Product ID is invalid";
   		}
   	}
   }
   // COde for Wishlist
   if(isset($_GET['pid']) && $_GET['action']=="wishlist" ){
   	if(strlen($_SESSION['login'])==0)
       {   
   header('location:login.php');
   }
   else
   {
   mysqli_query($con,"insert into wishlist(userId,productId) values('".$_SESSION['id']."','".$_GET['pid']."')");
   echo "<script>alert('Product aaded in wishlist');</script>";
   header('location:wishlist.php');
   
   }
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <?php include( 'includes/head.php');?>
   <body class="cnt-home">
      <header class="header-style-1">
         <?php include( 'includes/top-header.php');?>
         <?php include( 'includes/main-header.php');?>
         <?php include( 'includes/menu.php');?>
      </header>
      </div><!-- /.breadcrumb -->
      <div class="body-content outer-top-xs">
         <div class='container'>
            <div class='row'>
               <div class='col-xs-6 col-sm-6 col-md-12'>
                  <div class="breadcrumb">
                     <div class="breadcrumb-inner">
                        <ul class="list-inline list-unstyled">
                           <li><a href="index.php">SubCategory</a></li>
                           <?php $sql=mysqli_query($con,"select subcategory  from subcategory where id='$scid'");
                              while($row=mysqli_fetch_array($sql))
                              {
                                  ?>
                           <li class='active'><?php echo htmlentities($row['subcategory']);?></li>
                           <?php } ?>
                        </ul>
                     </div>
                     <!-- /.breadcrumb-inner -->
                  </div>
                  <!-- ========================================== SECTION – HERO ========================================= -->
                  <div id="myTabContent" class="tab-content">
                     <div class="tab-pane active " id="grid-container">
                        <div class="category-product">
                           <style>
                              .ribbon {
                              height: 20px;
                              position: relative;
                              margin-bottom: 30px;
                              text-transform: uppercase;
                              color: white;
                              }
                              .ribbon1 {
                              position: absolute;
                              top: -10.1px;
                              right: 0px;
                              }
                              .ribbon1 span {
                              position: relative;
                              display: block;
                              text-align: center;
                              background: #FF0000;
                              font-size: 14px;
                              line-height: 1;
                              padding: 12px 8px 10px;
                              border-top-right-radius: 8px;
                              width: 100px;
                              }
                              .ribbon1 span:before, .ribbon1 span:after {
                              position: absolute;
                              content: "";
                              }
                              .ribbon1 span:before {
                              height: 6px;
                              width: 6px;
                              left: -6px;
                              top: 0;
                              background: #FF0000;
                              }
                              .ribbon1 span:after {
                              height: 6px;
                              width: 8px;
                              left: -8px;
                              top: 0;
                              border-radius: 8px 8px 0 0;
                              background: #AC0000;
                              }
                              .quanty input {  width: 50px;
                              height: 30px;
                              padding-left: 10px;
                              margin-bottom: 5px;
                              border: 1px solid #eee;
                              }
                           </style>
                           <div class="row">
                              <?php
                                 $ret=mysqli_query($con,"select * from products where subCategory='$scid'");
                                 $num=mysqli_num_rows($ret);
                                 if($num>0)
                                 {
                                 while ($row=mysqli_fetch_array($ret)) 
                                 {?>							
                              <div class="col-xs-6 col-sm-6 col-md-4 wow fadeInUp">
                                 <div class="products" style="padding:10px; background-color:#FFF; border:1px solid #ececec; border-radius:10px; text-align:center;">
                                    <div class="product">
                                       <div class="ribbon">
                                          <?php if($row['cashback'] > 0 ){?>
                                          <span class="ribbon1"><span>Cash Off<br><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['cashback']);?></span></span>
                                          <?php } ?>
                                       </div>
                                       <div class="product-image">
                                          <div class="image">
                                             <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><img src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="" width="150px" height="150px"></a>
                                          </div>
                                          <!-- /.image -->			                      		   
                                       </div>
                                       <!-- /.product-image -->
                                       <div class="product-info text-center">
                                          <h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
                                          <div class="rating rateit-small"></div>
                                          <div class="description"></div>
                                          <div class="product-price">	
                                             <span class="price">
                                             <?php if(isset($currency)){ echo $currency.". ";}?> <?php echo htmlentities($row['productPrice']);?>			</span>
                                             <span class="price-before-discount"><?php if(isset($currency)){ echo $currency.". ";}?> <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
                                          </div>
                                          <!-- /.product-price -->
                                       </div>
                                       <!-- /.product-info -->
                                       <?php if($row['productAvailability']=='In Stock'){?>
                                       <form name="add_to_cart_<?php echo $row['id']; ?>" id="add_to_cart_<?php echo $row['id']; ?>" method="get" action="category.php">
                                          <div class="quant-input">
                                             <div class="quanty">
                                                <input type="number" id="quantity" name="quantity" min="1" max="10" step="1" value="1">
                                             </div>
                                             <input type="hidden" id="ids" name="id" value="<?php echo $row['id']; ?>">
                                             <input type="hidden" id="page" name="page" value="product" >
                                             <input type="hidden" id="action" name="action" value="add" >
                                          </div>
                                          <div class="action">
                                             <!-- <a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>&qty=<?php echo $_GET['quantity'];?>" class="lnk btn btn-primary"><i class="fa fa-shopping-cart inner-right-vs"></i>Add to Cart</a>-->
                                             <button class="lnk btn btn-primary"><i class="fa fa-shopping-cart inner-right-vs"></i> Add To Cart</button>
                                          </div>
                                       </form>
                                       <?php } else {?>
                                       <div class="action" style="color:red">Out of Stock</div>
                                       <?php } ?>
                                       <div class="action">
                                          <a class="add-to-cart" href="category.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist" title="Wishlist">
                                          <i class="icon fa fa-heart"></i>
                                          </a>
                                       </div>
                                       <!-- /.cart -->
                                    </div>
                                 </div>
                              </div>
                              <?php } } else {?>
                              <div class="col-xs-6 col-sm-6 col-md-12 wow fadeInUp">
                                 <h3>No Product Found</h3>
                              </div>
                              <?php } ?>	
                           </div>
                           <!-- /.row -->
                        </div>
                        <!-- /.category-product -->
                     </div>
                     <!-- /.tab-pane -->
                  </div>
                  <!-- /.col -->
               </div>
            </div>
         </div>
      </div>
      <section class="body-content outer-top-xs">
         <div class="container" >
            <div class="row">
               <?php include('includes/brands-slider.php');?>
            </div>
         </div>
      </section>
      <?php include( 'includes/footer-top.php');?>
      <?php include('includes/footer.php');?>
      <?php include( 'includes/head.php');?>
   </body>
</html>