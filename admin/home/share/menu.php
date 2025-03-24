<aside class="menu-sidebar2">
            <div class="logo">
				<a href="index.php">
					<?php
					$sql=mysqli_query($con,"select * from basic where id='1'");
					while($row=mysqli_fetch_array($sql))
					{	?>
					<img src="../logo/<?php echo $row['id'];?>/<?php echo $row['logo'];?>"  alt="<?php if(isset($compName)){ echo $compName;}?>"/>
					<?php } ?>
				</a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="images/icon/avatar-big-01.jpg" alt="John Doe" />
                    </div>
					<?php
					$sql=mysqli_query($con,"select * from admin where id='1'");
					while($row=mysqli_fetch_array($sql))
					{	?>
				    <h4 class="name"><?php echo $row['username'];?></h4>
					<?php } ?>
                    <a href="../logout.php">Sign out</a>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
						<li>
                            <a href="index.php">
                                <i class="fas fa-shopping-basket"></i>Dashboard</a>
                        </li>
						<li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Order Manage
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
									<a href="inbox.html">
										<i class="fas fa-chart-bar"></i>Inbox</a>
									<span class="inbox-num">3</span>
								</li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Basic Setting
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="basic.php">
                                        <i class="fas fa-tachometer-alt"></i>Company Info</a>
                                </li>
                                <li>
                                    <a href="index2.html">
                                        <i class="fas fa-tachometer-alt"></i>Import Images</a>
                                </li>
								<li>
                                    <a href="index2.html">
                                        <i class="fas fa-tachometer-alt"></i>Cashoff Pay</a>
                                </li>
                            </ul>
                        </li>
						
						<li>
                            <a href="brands.php">
                                <i class="fas fa-shopping-basket"></i>Brands</a>
                        </li>
                        
                        
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-trophy"></i>Categories
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="category.php">
                                        <i class="fas fa-table"></i>Add Category</a>
                                </li>
                                <li>
                                    <a href="subcategory.php">
                                        <i class="far fa-check-square"></i>Sub Category</a>
                                </li>
                            </ul>
                        </li>
						<li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-trophy"></i>Products
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="table.html">
                                        <i class="fas fa-table"></i>Add Product</a>
                                </li>
                                <li>
                                    <a href="form.html">
                                        <i class="far fa-check-square"></i>Manage Products</a>
                                </li>
                            </ul>
                        </li>
						<li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-trophy"></i>Inventory
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="table.html">
                                        <i class="fas fa-table"></i>Add Item</a>
                                </li>
                                <li>
                                    <a href="form.html">
                                        <i class="far fa-check-square"></i>Manage Items</a>
                                </li>
                            </ul>
                        </li>
						<li>
                            <a href="index.php">
                                <i class="fas fa-shopping-basket"></i>Delivery Man</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Users
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="login.html">
                                        <i class="fas fa-sign-in-alt"></i>Manage users</a>
                                </li>
                                <li>
                                    <a href="register.html">
                                        <i class="fas fa-user"></i>Cashpay to users</a>
                                </li>
                                <li>
                                    <a href="forget-pass.html">
                                        <i class="fas fa-unlock-alt"></i>User Log</a>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>
                </nav>
            </div>
        </aside>