<?php 
   session_start();
   error_reporting(0);
   include('includes/config.php');
   if(isset($_GET['action']) && $_GET['action']=="add"){
   	$id=intval($_GET['id']);
   	if(isset($_SESSION['cart'][$id])){
   		$_SESSION['cart'][$id]['quantity']++;
   	}else{
   		$sql_p="SELECT * FROM products WHERE id={$id}";
   		$query_p=mysqli_query($con,$sql_p);
   		if(mysqli_num_rows($query_p)!=0){
   			$row_p=mysqli_fetch_array($query_p);
   			$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
   					echo "<script>alert('Product has been added to the cart')</script>";
   		echo "<script type='text/javascript'> document.location ='cart.php'; </script>";
   		}else{
   			$message="Product ID is invalid";
   		}
   	}
   }
   $pid=intval($_GET['pid']);
   if(isset($_GET['pid']) && $_GET['action']=="wishlist" ){
   	if(strlen($_SESSION['login'])==0)
       {   
   header('location:login.php');
   }
   else
   {
   mysqli_query($con,"insert into wishlist(userId,productId) values('".$_SESSION['id']."','$pid')");
   echo "<script>alert('Product aaded in wishlist');</script>";
   header('location:wishlist.php');
   
   }
   }
   if(isset($_POST['submit']))
   {
   	$qty=$_POST['quality'];
   	$price=$_POST['price'];
   	$value=$_POST['value'];
   	$name=$_POST['name'];
   	$summary=$_POST['summary'];
   	$review=$_POST['review'];
   	mysqli_query($con,"insert into productreviews(productId,quality,price,value,name,summary,review) values('$pid','$qty','$price','$value','$name','$summary','$review')");
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
               <?php
                  $ret=mysqli_query($con,"select category.categoryName as catname,subCategory.subcategory as subcatname,products.productName as pname from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory where products.id='$pid'");
                  while ($rw=mysqli_fetch_array($ret)) {
                  
                  ?>
               <ul class="list-inline list-unstyled">
                  <li><a href="index.php">Home</a></li>
                  <li><?php echo htmlentities($rw['catname']);?></a></li>
                  <li><?php echo htmlentities($rw['subcatname']);?></li>
                  <li class='active'><?php echo htmlentities($rw['pname']);?></li>
               </ul>
               <?php }?>
            </div>
            <!-- /.breadcrumb-inner -->
         </div>
         <!-- /.container -->
      </div>
      <!-- /.breadcrumb -->
      <div class="body-content outer-top-xs">
         <div class='container'>
            <div class='row single-product outer-bottom-sm '>
               <div class='col-md-4 sidebar'>
                  <div class="sidebar-module-container">
                     <!-- ==============================================CATEGORY============================================== -->
                     <div class="side-menu animate-dropdown outer-bottom-xs">
                     <div class="side-menu animate-dropdown outer-bottom-xs">
                        <div class="head"><i class="icon fa fa-align-justify fa-fw"></i>Sub Categories</div>
                        <nav class="yamm megamenu-horizontal" role="navigation">
                           <ul class="nav">
                              <li class="dropdown menu-item">
                                 <?php $sql=mysqli_query($con,"select id,subcategory  from subcategory");
                                    while($row=mysqli_fetch_array($sql))
                                    {
                                        ?>
                                 <a href="sub-category.php?scid=<?php echo $row['id'];?>" class="dropdown-toggle"><span style="padding-right:5px;"><img src="img/20_20.png" /></span>
                                 <?php echo $row['subcategory'];?></a>
                                 <?php }?>
                              </li>
                           </ul>
                        </nav>
                     </div>
                  </div>
                     
                     <!-- ============================================== CATEGORY : END ============================================== -->					<!-- ============================================== HOT DEALS ============================================== -->
                     <div class="sidebar-widget hot-deals wow fadeInUp">
                        <h3 class="section-title">hot deals</h3>
                        <div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-xs">
                           <?php
                              $ret=mysqli_query($con,"select * from products order by rand() limit 4 ");
                              while ($rws=mysqli_fetch_array($ret)) {
                              
                              ?>
                           <div class="item">
                              <div class="products text-center" style="padding:10px; background-color:#FFF; border:1px solid #ececec; border-radius:10px; text-align:center;">
                                 <div class="hot-deal-wrapper">
                                    <div class="image">
                                       <img src="admin/productimages/<?php echo htmlentities($rws['id']);?>/<?php echo htmlentities($rws['productImage1']);?>"  width="160px" height="160px" alt="">
                                    </div>
                                 </div>
                                 <!-- /.hot-deal-wrapper -->
                                 <div class="product-info text-center m-t-20">
                                    <h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($rws['id']);?>"><?php echo htmlentities($rws['productName']);?></a></h3>
                                    <div class="rating rateit-small"></div>
                                    <div class="product-price">	
                                       <span class="price">
                                       <?php if(isset($currency)){ echo $currency.". ";}?> <?php echo htmlentities($rws['productPrice']);?>.00
                                       </span>
                                       
                                       <?php if($row[ 'productPriceBeforeDiscount']> 0 ){?>
                                       <span class="price-before-discount"><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
									   <?php } ?>
                                    </div>
                                    <!-- /.product-price -->
                                 </div>
                                 <!-- /.product-info -->
                                 <div class="cart clearfix animate-effect">
                                    <div class="action">
                                       <div class="add-cart-button btn-group text-center">
                                          <button class="btn btn-primary icon" data-toggle="dropdown" type="button">
                                          <?php if($row['productAvailability']=='In Stock'){?>
                                          <button class="btn btn-primary icon" data-toggle="dropdown" type="button">
                                          <i class="fa fa-shopping-cart"></i>													
                                          </button>
                                          <a href="category.php?page=product&action=add&id=<?php echo $row['id']; ?>">
                                          <button class="btn btn-primary" type="button">Add to cart</button></a>
                                          <?php } else {?>
                                          <div class="action" style="color:red">Out of Stock</div>
                                          <?php } ?>
                                       </div>
                                    </div>
                                    <!-- /.action -->
                                 </div>
                                 <!-- /.cart -->
                              </div>
                           </div>
                           <?php } ?>        
                        </div>
                        <!-- /.sidebar-widget -->
                     </div>
                     <!-- ============================================== COLOR: END ============================================== -->
                  </div>
               </div>
               <!-- /.sidebar -->
               <?php 
                  $ret=mysqli_query($con,"select * from products where id='$pid'");
                  while($row=mysqli_fetch_array($ret))
                  {
                  
                  ?>
               <div class='col-md-8'>
                  <div class="row  wow fadeInUp">
                     <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
                        <div class="product-item-holder size-big single-product-gallery small-gallery">
                           <div id="owl-single-product">
                              <div class="single-product-gallery-item" id="slide1">
                                  <a data-lightbox="image-1" data-title="<?php echo htmlentities($row['productName']);?>" href="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>">
                                 <img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" width="350px" height="350px" />
                                 </a>
                                 
                              </div>
                              <div class="single-product-gallery-item" id="slide1">
                                 <a data-lightbox="image-1" data-title="<?php echo htmlentities($row['productName']);?>" href="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>">
                                 <img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" width="350px" height="350px"/>
                                 </a>
                              </div>
                              <!-- /.single-product-gallery-item -->
                              <div class="single-product-gallery-item" id="slide2">
                                 <a data-lightbox="image-1" data-title="Gallery" href="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage2']);?>">
                                 <img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage2']);?>" />
                                 </a>
                              </div>
                              <!-- /.single-product-gallery-item -->
                              <div class="single-product-gallery-item" id="slide3">
                                 <a data-lightbox="image-1" data-title="Gallery" href="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage3']);?>">
                                 <img class="img-responsive demo-img pos-center" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage3']);?>" />
                                 </a>
                              </div>
                           </div>
                           <!-- /.single-product-slider -->
                           <div class="single-product-gallery-thumbs gallery-thumbs">
                              <div id="owl-single-product-thumbnails">
                                 <div class="item">
                                    <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="1" href="#slide1">
                                    <img class="img-responsive"  alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" />
                                    </a>
                                 </div>
                                 <div class="item">
                                    <a class="horizontal-thumb" data-target="#owl-single-product" data-slide="2" href="#slide2">
                                    <img class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage2']);?>"/>
                                    </a>
                                 </div>
                                 <div class="item">
                                    <a class="horizontal-thumb" data-target="#owl-single-product" data-slide="3" href="#slide3">
                                    <img class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage3']);?>" height="200" />
                                    </a>
                                 </div>
                              </div>
                              <!-- /#owl-single-product-thumbnails -->
                           </div>
                        </div>
                     </div>
                     <div class='col-sm-6 col-md-7 product-info-block'>
                        <div class="product-info">
                           <h1 class="name"><?php echo htmlentities($row['productName']);?></h1>
                           <?php $rt=mysqli_query($con,"select * from productreviews where productId='$pid'");
                              $num=mysqli_num_rows($rt);
                              {
                              ?>		
                           <div class="rating-reviews m-t-20">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <div class="rating rateit-small"></div>
                                 </div>
                                 <div class="col-sm-8">
                                    <div class="reviews">
                                       <a href="#" class="lnk">(<?php echo htmlentities($num);?> Reviews)</a>
                                    </div>
                                 </div>
                              </div>
                              <!-- /.row -->		
                           </div>
                           <!-- /.rating-reviews -->
                           <?php } ?>
                           <div class="stock-container info-container m-t-10">
                              <div class="row">
                                 <div class="col-sm-4">
                                    <div class="stock-box">
                                       <span class="label">Availability :</span>
                                    </div>
                                 </div>
                                 <div class="col-sm-8">
                                    <div class="stock-box">
                                       <span class="value"><?php echo htmlentities($row['productAvailability']);?></span>
                                    </div>
                                 </div>
                              </div>
                              <!-- /.row -->	
                           </div>
                           <div class="stock-container info-container m-t-10">
                              <div class="row">
                                 <div class="col-sm-4">
                                    <div class="stock-box">
                                       <span class="label">Product Brand :</span>
                                    </div>
                                 </div>
                                 <div class="col-sm-8">
                                    <div class="stock-box">
                                         <?php 
                  $rett=mysqli_query($con,"select * from brands where id='".$row['productCompany']."'");
                  while($row1=mysqli_fetch_array($rett))
                  {
                  
                  ?>
                                       <span class="value"><?php echo htmlentities($row1['brandsName']);?></span>
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                              <!-- /.row -->	
                           </div>
                           <div class="stock-container info-container m-t-10">
                              <div class="row">
                                 <div class="col-sm-4">
                                    <div class="stock-box">
                                       <span class="label">Shipping Charge :</span>
                                    </div>
                                 </div>
                                 <div class="col-sm-8">
                                    <div class="stock-box">
                                       <span class="value"><?php if($row['shippingCharge']==0)
                                          {
                                          	echo "Free";
                                          }
                                          else
                                          {
                                          	if(isset($currency)){ echo $currency.". ";} echo htmlentities($row['shippingCharge']);
                                          }
                                          
                                          ?></span>
                                    </div>
                                 </div>
                              </div>
                              <!-- /.row -->	
                           </div>
                           <div class="stock-container info-container m-t-10">
                              <div class="row">
                                 <div class="col-sm-4">
                                    <div class="stock-box">
                                       <span class="label">Cash Off :</span>
                                    </div>
                                 </div>
                                 <div class="col-sm-8">
                                    <div class="stock-box">
                                       <span class="value"><?php if($row['cashback']==0)
                                          {
                                          	echo "0";
                                          }
                                          else
                                          {
                                          	if(isset($currency)){ echo $currency.". ";} echo htmlentities($row['cashback']);
                                          }
                                          
                                          ?></span>
                                    </div>
                                 </div>
                              </div>
                              <!-- /.row -->	
                           </div>
                           <div class="price-container info-container m-t-20">
                              <div class="row">
                                 <div class="col-sm-12">
                                    <div class="price-box">
                                       <span class="price"><?php if(isset($currency)){ echo $currency.". ";}?> <?php echo htmlentities($row['productPrice']);?></span>
									   <?php if($row[ 'productPriceBeforeDiscount']> 0 ){?>
                                       <span class="price-strike"><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
									   <?php } ?>
                                    </div>
                                 </div>
                                 
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.price-container -->
                           <div class="quantity-container info-container">
                              <div class="row">
                                 
                                 
                                 <div class="col-sm-4">
                                    <?php if($row['productAvailability']=='In Stock'){?>
                                    <a href="product-details.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART</a>
                                    <?php } else {?>
                                    <div class="action">Out of Stock</div>
                                    <?php } ?>
                                 </div>
                                 <div class="col-sm-8">
                                     <div class="favorite-button">
                                       <a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Wishlist" href="product-details.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist">
                                       <i class="fa fa-heart"></i>
                                       </a>
                                       </a>
                                    </div>
                                 </div>
                                 
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.quantity-container -->
                           <div class="product-social-link m-t-20 text-left">
                              <span class="social-label">Share :</span>
                              <div class="social-icons">
                                 <ul class="list-inline">
                                    <li><a class="fa fa-facebook" href="http://facebook.com/transvelo"></a></li>
                                    <li><a class="fa fa-twitter" href="#"></a></li>
                                    <li><a class="fa fa-linkedin" href="#"></a></li>
                                 </ul>
                                 <!-- /.social-icons -->
                              </div>
                           </div>
                        </div>
                        <!-- /.product-info -->
                     </div>
                     <!-- /.col-sm-7 -->
                  </div>
                  <!-- /.row -->
                  <div class="product-tabs inner-bottom-xs  wow fadeInUp">
                     <div class="row">
                        <div class="col-sm-3">
                           <ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
                              <li class="active"><a data-toggle="tab" href="#description">DESCRIPTION</a></li>
                              <li><a data-toggle="tab" href="#review">REVIEW</a></li>
                           </ul>
                           <!-- /.nav-tabs #product-tabs -->
                        </div>
                        <div class="col-sm-9">
                           <div class="tab-content">
                              <div id="description" class="tab-pane in active">
                                 <div class="product-tab">
                                    <p class="text"><?php echo $row['productDescription'];?></p>
                                 </div>
                              </div>
                              <!-- /.tab-pane -->
                              <div id="review" class="tab-pane">
                                 <div class="product-tab">
                                    <div class="product-reviews">
                                       <h4 class="title">Customer Reviews</h4>
                                       <?php $qry=mysqli_query($con,"select * from productreviews where productId='$pid'");
                                          while($rvw=mysqli_fetch_array($qry))
                                          {
                                          ?>
                                       <div class="reviews" style="border: solid 1px #000; padding-left: 2% ">
                                          <div class="review">
                                             <div class="review-title"><span class="summary"><?php echo htmlentities($rvw['summary']);?></span><span class="date"><i class="fa fa-calendar"></i><span><?php echo htmlentities($rvw['reviewDate']);?></span></span></div>
                                             <div class="text">"<?php echo htmlentities($rvw['review']);?>"</div>
                                             <div class="text"><b>Quality :</b>  <?php echo htmlentities($rvw['quality']);?> Star</div>
                                             <div class="text"><b>Price :</b>  <?php echo htmlentities($rvw['price']);?> Star</div>
                                             <div class="text"><b>value :</b>  <?php echo htmlentities($rvw['value']);?> Star</div>
                                             <div class="author m-t-15"><i class="fa fa-pencil-square-o"></i> <span class="name"><?php echo htmlentities($rvw['name']);?></span></div>
                                          </div>
                                       </div>
                                       <?php } ?><!-- /.reviews -->
                                    </div>
                                    <!-- /.product-reviews -->
                                    <form role="form" class="cnt-form" name="review" method="post">
                                       <div class="product-add-review">
                                          <h4 class="title">Write your own review</h4>
                                          <div class="review-table">
                                             <div class="table-responsive">
                                                <table class="table table-bordered">
                                                   <thead>
                                                      <tr>
                                                         <th class="cell-label">&nbsp;</th>
                                                         <th>1 star</th>
                                                         <th>2 stars</th>
                                                         <th>3 stars</th>
                                                         <th>4 stars</th>
                                                         <th>5 stars</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                         <td class="cell-label">Quality</td>
                                                         <td><input type="radio" name="quality" class="radio" value="1"></td>
                                                         <td><input type="radio" name="quality" class="radio" value="2"></td>
                                                         <td><input type="radio" name="quality" class="radio" value="3"></td>
                                                         <td><input type="radio" name="quality" class="radio" value="4"></td>
                                                         <td><input type="radio" name="quality" class="radio" value="5"></td>
                                                      </tr>
                                                      <tr>
                                                         <td class="cell-label">Price</td>
                                                         <td><input type="radio" name="price" class="radio" value="1"></td>
                                                         <td><input type="radio" name="price" class="radio" value="2"></td>
                                                         <td><input type="radio" name="price" class="radio" value="3"></td>
                                                         <td><input type="radio" name="price" class="radio" value="4"></td>
                                                         <td><input type="radio" name="price" class="radio" value="5"></td>
                                                      </tr>
                                                      <tr>
                                                         <td class="cell-label">Value</td>
                                                         <td><input type="radio" name="value" class="radio" value="1"></td>
                                                         <td><input type="radio" name="value" class="radio" value="2"></td>
                                                         <td><input type="radio" name="value" class="radio" value="3"></td>
                                                         <td><input type="radio" name="value" class="radio" value="4"></td>
                                                         <td><input type="radio" name="value" class="radio" value="5"></td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                                <!-- /.table .table-bordered -->
                                             </div>
                                             <!-- /.table-responsive -->
                                          </div>
                                          <!-- /.review-table -->
                                          <div class="review-form">
                                             <div class="form-container">
                                                <div class="row">
                                                   <div class="col-sm-6">
                                                      <div class="form-group">
                                                         <label for="exampleInputName">Your Name <span class="astk">*</span></label>
                                                         <input type="text" class="form-control txt" id="exampleInputName" placeholder="" name="name" required="required">
                                                      </div>
                                                      <!-- /.form-group -->
                                                      <div class="form-group">
                                                         <label for="exampleInputSummary">Summary <span class="astk">*</span></label>
                                                         <input type="text" class="form-control txt" id="exampleInputSummary" placeholder="" name="summary" required="required">
                                                      </div>
                                                      <!-- /.form-group -->
                                                   </div>
                                                   <div class="col-md-6">
                                                      <div class="form-group">
                                                         <label for="exampleInputReview">Review <span class="astk">*</span></label>
                                                         <textarea class="form-control txt txt-review" id="exampleInputReview" rows="4" placeholder="" name="review" required="required"></textarea>
                                                      </div>
                                                      <!-- /.form-group -->
                                                   </div>
                                                </div>
                                                <!-- /.row -->
                                                <div class="action text-right">
                                                   <button name="submit" class="btn btn-primary btn-upper">REVIEW</button>
                                                </div>
                                                <!-- /.action -->
                                    </form>
                                    <!-- /.cnt-form -->
                                    </div><!-- /.form-container -->
                                    </div><!-- /.review-form -->
                                    </div><!-- /.product-add-review -->										
                                 </div>
                                 <!-- /.product-tab -->
                              </div>
                              <!-- /.tab-pane -->
                           </div>
                           <!-- /.tab-content -->
                        </div>
                        <!-- /.col -->
                     </div>
                     <!-- /.row -->
                  </div>
                  <!-- /.product-tabs -->
                  <?php $cid=$row['category'];
                     $subcid=$row['subCategory']; } ?>
                  <!-- ============================================== UPSELL PRODUCTS ============================================== -->
                  <section class="section featured-product wow fadeInUp">
                      <h3 class="section-title">Realted Products </h3>
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
                  </style>
                        <?php 
                           $qry=mysqli_query($con,"select * from products where subCategory='$subcid' and category='$cid'");
                           while($rw=mysqli_fetch_array($qry))
                           {
                           
                           			?>	
                         <div class="col-xs-12 col-sm-12 col-md-4 wow fadeInUp" >
                                 <div class="products" style="padding:10px; background-color:#FFF; border:1px solid #ececec; border-radius:10px; text-align:center;">
                                    <div class="product">
                                       <div class="ribbon">
                                          <?php if($rw['cashback'] > 0 ){?>
                                          <span class="ribbon1"><span>Cash Off<br><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($rw['cashback']);?></span></span>
                                          <?php } ?>
                                       </div>
                                       <div class="product-image">
                                          <div class="image">
                                             <a href="product-details.php?pid=<?php echo htmlentities($rw['id']);?>">
                                             <img  src="admin/productimages/<?php echo htmlentities($rw['id']);?>/<?php echo htmlentities($rw['productImage1']);?>" data-echo="admin/productimages/<?php echo htmlentities($rw['id']);?>/<?php echo htmlentities($rw['productImage1']);?>"  width="150px" height="150px" alt=""></a>
                                          </div>
                                          <!-- /.image -->			
                                       </div>
                                       <!-- /.product-image -->
                                       <div class="product-info text-center">
                                          <h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($rw['id']);?>"><?php echo htmlentities($rw['productName']);?></a></h3>
                                          <div class="rating rateit-small"></div>
                                          <div class="description"></div>
                                          <div class="product-price">	
                                             <span class="price">
                                             <?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($rw['productPrice']);?>			</span>
                                             <span class="price-before-discount"><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($rw['productPriceBeforeDiscount']);?>	</span>
                                          </div>
                                          <!-- /.product-price -->
                                       </div>
                                       <!-- /.product-info -->
                                       <?php if($rw['productAvailability']=='In Stock'){?>
                                       <div class="action"><a href="index.php?page=product&action=add&id=<?php echo $rw['id']; ?>" class="lnk btn btn-primary"><i class="fa fa-shopping-cart inner-right-vs"></i>Add to Cart</a></div>
                                       <?php } else {?>
                                       <div class="action" style="color:red">Out of Stock</div>
                                       <?php } ?>
                                       <div class="action">
                                                      <a class="add-to-cart" href="category.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist" title="Wishlist">
                                                      <i class="icon fa fa-heart"></i>
                                                      </a></div>
                                    </div>
                                    <!-- /.product -->
                                 </div>
                                 <!-- /.products -->
                              </div>
                        <!-- /.item -->
                        <?php } ?>
                     </div>
                     <!-- /.home-owl-carousel -->
                  </section>
                  <!-- /.section -->
                  <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->
               </div>
               <!-- /.col -->
               <div class="clearfix"></div>
            </div>
            <?php include('includes/brands-slider.php');?>
         </div>
      </div>
      <?php include( 'includes/footer-top.php');?>
      <?php include('includes/footer.php');?>
      <?php include( 'includes/js.php');?>
   </body>
</html>