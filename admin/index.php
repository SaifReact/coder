<?php
   session_start();
   error_reporting(0);
   include("include/config.php");
   if(isset($_POST['submit']))
   {
   	$username=$_POST['username'];
   	$password=md5($_POST['password']);
   $ret=mysqli_query($con,"SELECT * FROM admin WHERE username='$username' and password='$password'");
   $num=mysqli_fetch_array($ret);

   if($num>0)
   {
   $extra="home/index.php";
   $_SESSION['alogin']=$_POST['username'];
   $_SESSION['id']=$num['id'];
   $host=$_SERVER['HTTP_HOST'];
   $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
   header("location:http://$host$uri/$extra");
   exit();
   }
   else
   {
   $_SESSION['errmsg']="Invalid username or password";
   $extra="index.php";
   $host  = $_SERVER['HTTP_HOST'];
   $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
   header("location:http://$host$uri/$extra");
   exit();
   }
   }
   ?>
   
<!DOCTYPE html>
<html>
<head>
   <?php include('include/head.php');?>
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Sign In</h3>
			</div>
			<div class="card-body">
			<span style="color:red;" ><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
				<form class="form-vertical" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" id="inputEmail" name="username" placeholder="username">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" id="inputPassword" name="password" placeholder="password">
					</div>
					<div class="form-group">
						<input type="submit" value="Login" name="submit" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					<a href="index.php">
					<?php
					$sql=mysqli_query($con,"select * from basic where id='1'");
					while($row=mysqli_fetch_array($sql))
					{	?>
					<img src="logo/<?php echo $row['id'];?>/<?php echo $row['logo'];?>"  alt="<?php if(isset($compName)){ echo $compName;}?>"/>
					<?php } ?>
				</a>
				</div>
				
			</div>
		</div>
	</div>
</div>
</body>
</html>