<?php
   session_start();
   error_reporting(0);
   include('includes/config.php');
   
   $cid = intval($_GET['cid']);
   
   if (isset($_GET['action']) && $_GET['action'] == "add") {
       $id = intval($_GET['id']);
       if (isset($_SESSION['cart'][$id])) {
           $_SESSION['cart'][$id]['quantity']+=$_GET['quantity'];
       } else {
           $sql_p   = "SELECT * FROM products WHERE id={$id}";
           $query_p = mysqli_query($con, $sql_p);
           if (mysqli_num_rows($query_p) != 0) {
               $row_p  = mysqli_fetch_array($query_p);
               $_SESSION['cart'][$row_p['id']] = array(
                   "quantity" => $_GET['quantity'],
                   "price" => $row_p['productPrice']
               );
               echo "<script type='text/javascript'> document.location ='category.php?cid=$cid'; </script>";
           } else {
               $message = "Product ID is invalid";
           }
       }
       
   }
   // COde for Wishlist
   if (isset($_GET['pid']) && $_GET['action'] == "wishlist") {
       if (strlen($_SESSION['login']) == 0) {
           header('location:login.php');
       } else {
           mysqli_query($con, "insert into wishlist(userId,productId) values('" . $_SESSION['id'] . "','" . $_GET['pid'] . "')");
           echo "<script>alert('Product aaded in wishlist');</script>";
           header('location:wishlist.php');
           
       }
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <?php include( 'includes/head.php');?>
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
      </div><!-- /.breadcrumb -->
      <div class="body-content outer-top-xs">
         <div class='container'>
            <div class='row outer-bottom-sm'>
               <div class='col-xs-12 col-sm-12 col-md-3 sidebar'>
                  <div class="side-menu animate-dropdown outer-bottom-xs">
                     <div class="side-menu animate-dropdown outer-bottom-xs">
                        <div class="head"><i class="icon fa fa-align-justify fa-fw"></i>Sub Categories</div>
                        <nav class="yamm megamenu-horizontal" role="navigation">
                           <ul class="nav">
                              <li class="dropdown menu-item">
                                 <?php $sql=mysqli_query($con,"select id,subcategory  from subcategory where categoryid='$cid'");
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
               </div>
               <!-- /.sidebar -->
               <div class='col-xs-6 col-sm-6 col-md-9'>
                  <div class="breadcrumb">
                     <div class="breadcrumb-inner">
                        <ul class="list-inline list-unstyled">
                           <li><a href="index.php">Category</a></li>
                           <?php $sql=mysqli_query($con,"select categoryName  from category where id='$cid'");
                              while($row=mysqli_fetch_array($sql))
                              {
                                  ?>
                           <li class='active'><?php echo htmlentities($row['categoryName']);?></li>
                           <?php } ?>
                        </ul>
                     </div>
                     <!-- /.breadcrumb-inner -->
                  </div>
                  <div id="myTabContent" class="tab-content">
                     <div class="tab-pane active " id="grid-container">
                        <div class="category-product">
                           <?php
                              $ret=mysqli_query($con,"select * from products where category='$cid'");
                              $num=mysqli_num_rows($ret);
                              if($num>0)
                              {
                              while ($row=mysqli_fetch_array($ret)) 
                              {?>							
                           <div class="col-xs-12 col-sm-12 col-md-4 wow fadeInUp" >
                              <div class="products" style="padding:10px; background-color:#FFF; border:1px solid #ececec; border-radius:10px; text-align:center;">
                                 <div class="product">
                                    <div class="ribbon">
                                       <?php if($row['cashback'] > 0 ){?>
                                       <span class="ribbon1"><span>Cash Off<br><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['cashback']);?></span></span>
                                       <?php } ?>
                                    </div>
                                    <div class="product-image">
                                       <div class="image">
                                          <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><img src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="" width="100px" height="100px"></a>
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
                           <div class="col-xs-12 col-sm-12 col-md-4 wow fadeInUp">
                              <h3>No Product Found</h3>
                           </div>
                           <?php } ?>	
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
      <?php include( 'includes/js.php');?>
   </body>
</html>