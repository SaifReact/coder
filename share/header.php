<?php
if (isset($_Get['action']))
{
    if (!empty($_SESSION['cart']))
    {
        foreach ($_POST['quantity'] as $key => $val)
        {
            if ($val == 0)
            {
                unset($_SESSION['cart'][$key]);
            }
            else
            {
                $_SESSION['cart'][$key]['quantity'] = $val;
            }
        }
    }
}
?>
	
<header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <?php $ret=mysqli_query($con, "select * from basic"); while ($row=mysqli_fetch_array($ret)) { ?>
                                <li><i class="fa fa-envelope"></i> <?php echo htmlentities($row['email']);?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </div>
                            
                            <div class="header__top__right__auth">
                                <a href="#"><i class="fa fa-user"></i> Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="header__logo">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="header__logo__left">
                          <a href="index.php">
							<?php
							$sql=mysqli_query($con,"select * from basic where id='1'");
							while($row=mysqli_fetch_array($sql))
							{	?>
							<img src="admin/logo/<?php echo $row['id'];?>/<?php echo $row['logo'];?>"  alt="<?php if(isset($compName)){ echo $compName;}?>"/>
							<?php } ?>
						  </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <nav class="header__menu">
							<ul>
								<li class="active"><a href="./index.php"><i class="fa fa-home"></i> Home - প্রচ্ছদ</a></li>
								<li><a href="./shop-grid.html"><i class="fa fa-rss"></i> Blog - ব্লগ</a></li>
								<li><a href="./contact.html"><i class="fa fa-phone"></i>  Contact - যোগাযোগ</a></li>
							</ul>
						</nav>
                    </div>
					<div class="col-lg-3 col-md-3">
                        <div class="header__cart">
							<ul>
								<li>
									<a href="#">
										<i class="fa fa-heart" style="color:red"></i>
										<span>2</span>
									</a>
								</li>
								<li>
									<a href="#">
										<i class="fa fa-shopping-cart"></i>
										<span>3</span>
									</a>
								</li>
							</ul>
							<div class="header__cart__price">Total: <span>Tk. 0.00</span></div>
						</div>
                    </div>
                </div>
            </div>
        </div>
		
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
    
