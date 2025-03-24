
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include ('includes/config.php');

if (isset($_GET['action']) && $_GET['action'] == "add")
{
    print_r($_GET);
   die;
    
    $id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$id]))
    {
        $_SESSION['cart'][$id]['quantity']+=$_GET['quantity'];
    }
    else
    {
        $sql_p = "SELECT * FROM products WHERE id={$id}";
        $query_p = mysqli_query($con, $sql_p);
        if (mysqli_num_rows($query_p) != 0)
        {
            $row_p = mysqli_fetch_array($query_p);
            $_SESSION['cart'][$row_p['id']] = array(
                "quantity" => $_GET['quantity'],
                "price" => $row_p['productPrice']
            );
        }
        else
        {
            $message = "Product ID is invalid";
        }
    }
    echo "
   <script type='text/javascript'>
   	document.location ='index1.php';
   </script>";
}
if (isset($_GET['id']) && $_GET['action'] == "wishlist")
{
    if (strlen($_SESSION['login']) == 0)
    {
        header('location:login.php');
    }
    else
    {
        mysqli_query($con, "insert into wishlist(userId,productId) values('" . $_SESSION['id'] . "','" . $_GET['pid'] . "')");
        echo "<script>alert('Product aaded in wishlist');</script>";
        header('location:wishlist.php');
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

 <?php include('share/head.php');?>

<body>
    <!-- Page Preloder 
    <div id="preloder">
        <div class="loader"></div>
    </div> -->

    <!-- Humberger Begin -->
    <?php include( 'share/humberger.php');?>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php include( 'share/header.php');?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <?php include( 'share/hero.php');?>
    <!-- Hero Section End -->
    
    <!-- Banner Begin -->
    <?php include( 'share/banner.php');?>
    <!-- Banner End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h4>All Products <span style="font-size:18px">- সকল পণ্য</span></h4>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            <?php
            // Check database connection
            if (!$con) {
                die("<p class='text-danger'>Database connection failed: " . mysqli_connect_error() . "</p>");
            }

            // Fetch products
            $query = "SELECT id, productName, productImage1, productPrice, priceAfterDiscount, cashback FROM products";
            $result = mysqli_query($con, $query);

            if (!$result) {
                echo "<p class='text-danger'>Error fetching products: " . mysqli_error($con) . "</p>";
            } elseif (mysqli_num_rows($result) == 0) {
                echo "<p class='text-warning'>No products found.</p>";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Secure output to prevent XSS attacks
                    $productId = htmlspecialchars($row['id']);
                    $productName = htmlspecialchars($row['productName']);
                    $productImage = !empty($row['productImage1']) ? "admin/productimages/$productId/" . htmlspecialchars($row['productImage1']) : "assets/images/no-image.png"; // Default image fallback
                    $productPrice = htmlspecialchars($row['productPrice']);
                    $priceAfterDiscount = htmlspecialchars($row['priceAfterDiscount']);
                    $cashback = htmlspecialchars($row['cashback']);
                    ?>
                    
                    <div class="col-lg-4 col-md-6 col-sm-12">
						<div class="featured__item card border-0 shadow-sm">
							<div class="featured__item__pic position-relative">
								<img src="<?php echo $productImage; ?>" class="card-img-top img-fluid rounded-3" alt="<?php echo $productName; ?>">
								<?php if ($cashback > 0) { ?>
									<div class="product__discount__percent badge bg-danger position-absolute top-0 start-0 m-2 p-2 d-flex flex-column align-items-center">
									<span>Save</span><span><?php echo isset($currency) ? $currency . ". " : ""; ?><?php echo $cashback; ?></span>
									</div>
								<?php } ?>
							</div>

							<div class="card-body text-center">
								<h6 class="product-title fw-bold">
									<a href="shop-details.php?pid=<?php echo $productId; ?>" class="text-dark text-decoration-none">
										<?php echo $productName; ?>
									</a>
								</h6>

								<h5 class="price mt-2">
									<span class="text-success fw-bold">
										<?php echo isset($currency) ? $currency . ". " : ""; ?><?php echo $priceAfterDiscount; ?>
									</span>
									<span class="price-before-discount text-muted text-decoration-line-through fs-6 ms-2">
										<?php echo isset($currency) ? $currency . ". " : ""; ?><?php echo $productPrice; ?>
									</span>
								</h5>

								<form name="add_to_cart_<?php echo $productId; ?>" id="add_to_cart_<?php echo $productId; ?>" method="get" action="index1.php" class="mt-3">
									<div class="row g-2 align-items-center">
										<div class="col-4">
											<a href="index1.php?id=<?php echo $productId; ?>&action=wishlist" class="btn btn-outline-danger w-100" title="Add to Wishlist">
												<i class="fa fa-heart"></i>
											</a>
										</div>

										<div class="col-4">
											<input type="number" name="quantity" class="form-control text-center" min="1" max="10" step="1" value="1">
											<input type="hidden" name="id" value="<?php echo $productId; ?>">
											<input type="hidden" name="page" value="product">
											<input type="hidden" name="action" value="add">
										</div>

										<div class="col-4">
											<button type="submit" class="btn btn-primary w-100">
												<i class="fa fa-shopping-cart"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>


                <?php }
            } ?>
        </div>
    </div>
</section>

    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img1/banner/ramadan.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img1/banner/eid.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->   
    
    <section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <?php 
                $ret = mysqli_query($con, "SELECT * FROM brands");
                while ($row = mysqli_fetch_array($ret)) { 
                ?>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" 
                         data-setbg="admin/brandsimages/<?php echo htmlentities($row['id']); ?>/<?php echo htmlentities($row['brandsImage']); ?>"></div>
                        
                        <!-- Image is set as a background -->
                        <div class="text"><?php echo trim(htmlentities($row['brandsName']) . ' - ' . htmlentities($row['brandsName_en']), ' -'); ?></div>

                    
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

    
<section class="slice-sm footer-top-bar bg-white">
    <div class="container sct-inner">
        <div class="row no-gutters">
            <?php 
            $ret = mysqli_query($con, "SELECT * FROM modal");

            if (!$ret) {
                die("Query failed: " . mysqli_error($con));
            }

            if (mysqli_num_rows($ret) == 0) {
                echo "<p>No data found in the modal table.</p>";
            } else {
                while ($row = mysqli_fetch_assoc($ret)) { 
				?>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-top-box text-center">
							<i class="fa <?php echo trim(htmlentities($row['icon'])); ?>" style="color:#008000; font-size:20px; padding-bottom:5px"></i>
                            <div style="font-size:12px" data-toggle="modal" data-target="#<?php echo trim(htmlentities($row['dataToggle'])); ?>">
                                <?php echo trim(htmlentities($row['modalName'])); ?>
                            </div>
                        </div>
                    </div>
                <?php }
            }
            ?>
        </div>
    </div>
</section>


<div id="sellPolicy" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Seller Policy</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="retPolicy" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Return Policy</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="supPolicy" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Support Policy</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="myProfile" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">My Profile</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="index.php">
                            <h3><?php if(isset($compName)){ echo $compName;}?></h3>
                            </a>
                        </div>
                        <ul>
                            <li>Address: <?php if(isset($address)){ echo $address;}?></li>
                            <li>Phone: <?php if(isset($phone1)){ echo $phone1;}?></li>
                            <li>Email: <?php if(isset($email)){ echo $email;}?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer__widget">
                        <h6>Opening Time</h6>
                        
                        <ul>
                        <li>
                    <table>
                        <tbody>
                           <tr>
                              <td>Monday-Sunday:</td>
                              <td>08.00AM To 10.00PM</td>
                           </tr>
                        </tbody>
                     </table>
                     </li>
                    </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="footer__widget">
                        <h6>Join Our Newsletter Now</h6>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#">
                            <input type="text" placeholder="Enter your mail">
                            <button type="submit" class="site-btn">Subscribe</button>
                        </form>
                        <div class="footer__widget__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text"><p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p></div>
                        <div class="footer__copyright__payment"><img src="img1/payment-item.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <?php include('share/js.php');?>

</body>

</html>