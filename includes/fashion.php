<section class="body-content outer-top-xs">
   <div class="container" >
      <div class="info-boxes wow fadeInUp">
         <div class="info-boxes-inner">
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-6">
                  <div id="product-tabs-slider" class="scroll-tabs inner-bottom-s  wow fadeInUp">
                      <div class="section-title">
                         <h2>Education</h2>
                      </div>
                     <div class="tab-content outer-top-xs">
                        <div class="tab-pane in active" id="all">
                           <div class="product-slider">
                              <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="2">
                                 <?php
                                    $ret=mysqli_query($con,"select * from products where category = 10");
                                    while ($row=mysqli_fetch_array($ret)) 
                                    { ?>
                                 <div class="item item-carousel">
                                    <div class="products text-center" style="padding:10px; background-color:#FFF; border:1px solid #ececec; border-radius:10px; text-align:center;">
                                       <div class="product">
                                          <div class="ribbon">
                                             <?php if($row['cashback'] > 0 ){?>
                                             <span class="ribbon1"><span>Cash Off<br><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['cashback']);?></span></span>
                                             <?php } ?>
                                          </div>
                                          <div class="product-image">
                                             <div class="image">
                                                <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                <img  src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>"  width="100px" height="100px" alt=""></a>
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
                                                <?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['productPrice']);?>			</span>
                                                <span class="price-before-discount"><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['productPriceBeforeDiscount']);?>	</span>
                                             </div>
                                             <!-- /.product-price -->
                                          </div>
                                          <!-- /.product-info -->
                                          <?php if($row['productAvailability']=='In Stock'){?>
                                          <!--<div class="action"><a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary"><i class="fa fa-shopping-cart inner-right-vs"></i>Add to Cart</a></div>-->
                                          <form name="add_to_cart_<?php echo $row['id']; ?>" id="add_to_cart_<?php echo $row['id']; ?>" method="get" action="index.php">
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
                                                      <a class="add-to-cart" href="index.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist" title="Wishlist">
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
                           </div>
                           <!-- /.product-slider -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-12 col-md-6">
                  <div id="product-tabs-slider" class="scroll-tabs inner-bottom-s  wow fadeInUp">
                        <div class="section-title">
                         <h2>Bazar</h2>
                        </div>
                     <div class="tab-content outer-top-xs">
                        <div class="tab-pane in active" id="all">
                           <div class="product-slider">
                              <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="2">
                                 <?php
                                    $ret=mysqli_query($con,"select * from products where category = 12");
                                    while ($row=mysqli_fetch_array($ret)) 
                                    { ?>
                                 <div class="item item-carousel">
                                    <div class="products text-center" style="padding:10px; background-color:#FFF; border:1px solid #ececec; border-radius:10px; text-align:center;">
                                       <div class="product">
                                          <div class="ribbon">
                                             <?php if($row['cashback'] > 0 ){?>
                                             <span class="ribbon1"><span>Cash Off<br><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['cashback']);?></span></span>
                                             <?php } ?>
                                          </div>
                                          <div class="product-image">
                                             <div class="image">
                                                <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                <img  src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage3']);?>" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage3']);?>"  width="100px" height="100px" alt=""></a>
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
                                                <?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['productPrice']);?>			</span>
                                                <span class="price-before-discount"><?php if(isset($currency)){ echo $currency.". ";}?><?php echo htmlentities($row['productPriceBeforeDiscount']);?>	</span>
                                             </div>
                                             <!-- /.product-price -->
                                          </div>
                                          <!-- /.product-info -->
                                          <?php if($row['productAvailability']=='In Stock'){?>
                                          <!--<div class="action"><a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary"><i class="fa fa-shopping-cart inner-right-vs"></i>Add to Cart</a></div>-->
                                          <form name="add_to_cart_<?php echo $row['id']; ?>" id="add_to_cart_<?php echo $row['id']; ?>" method="get" action="index.php">
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
                                                      <a class="add-to-cart" href="index.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist" title="Wishlist">
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
                           </div>
                           <!-- /.product-slider -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>