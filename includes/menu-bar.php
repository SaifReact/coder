<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<style>
		    ol, ul, li {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}
menu, nav, section {
	display: block;
}

ol, ul {
	list-style: none;
}

nav.navigation{
	position:relative;
	height:50px;
	background-color: #12cca7;
	z-index:2;
}
.nav-logo{
	float:left;
	height:50px;
	line-height:50px;
	padding:0 20px;
	background-color:#11999e;
	color:#FFF;
	font-weight:bold;
	text-transform:uppercase;
}
ul.nav-menu, ul.nav-menu li, ul.nav-menu li a{
	float:left;
}
ul.nav-menu{
	padding-left:10px;
}
ul.nav-menu li a{
	height:50px;
	line-height:50px;
	padding:0 10px;
	font-size:15px;
	font-weight:bold;
	color:#000;
	text-decoration:none;
}
ul.nav-menu li a:hover{
	color:#FF0000;
}
		</style>
		
		<nav class="navigation">
		    <div class="nav-logo"><a href="index.php" class="active">Home</a></div>
		<?php $sql=mysqli_query($con,"select id,categoryName  from category");
        while($row=mysqli_fetch_array($sql))
        { ?>
			<ul class="nav-menu">
				
				<li><a href="category.php?cid=<?php echo $row['id'];?>"> <?php echo $row['categoryName'];?></a></li>
				
			</ul>
			
			<?php } ?>
			
		</nav>
		
		