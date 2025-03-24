<div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="index.php">
                   <?php
                   $sql=mysqli_query($con,"select * from basic where id='1'");
                	while($row=mysqli_fetch_array($sql))
                	{	?>
                  <img src="admin/logo/<?php echo $row['id'];?>/<?php echo $row['logo'];?>"  alt="<?php if(isset($compName)){ echo $compName;}?>"/>
                  <?php } ?>
               </a>
        </div>

        <div class="humberger__menu__widget">
            <div class="header__top__right__auth">
                <a href="#"><i class="fa fa-user"></i> Login</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="./shop-grid.html"><i class="fa fa-shopping-cart"></i>  Shop</a></li>
                <li><a href="./contact.html"><i class="fa fa-phone"></i>  Contact</a></li>
                <li><a href="#"><i class="fa fa-heart"></i> <span style="color:#FF0000;">1</span>  wishlist</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <?php $ret=mysqli_query($con, "select * from basic"); while ($row=mysqli_fetch_array($ret)) { ?>
                <li><i class="fa fa-envelope"></i> <?php echo htmlentities($row['email']);?></li>
                <?php } ?>
            </ul>
        </div>
    </div>