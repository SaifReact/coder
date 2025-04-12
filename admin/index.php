<?php

session_start();
include("../includes/config.php");

if (isset($_POST['submit'])) {
    $userName = $_POST['userName'];
    $password = md5($_POST['password']); // Hash password
    $userIp = $_SERVER['REMOTE_ADDR']; // Get User IP
    $logonTime = date("Y-m-d H:i:s");
    $contactNo = NULL;
    $userId = NULL;
    $userEmail = NULL;

    // Check login in admin table
    $stmt = $con->prepare("SELECT id, contactNo FROM admin WHERE userName = ? AND password = ?");
    $stmt->bind_param("ss", $userName, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // If not found in admin, check the users table
    if (!$admin) {
        $stmt = $con->prepare("SELECT id, contactNo, email FROM cusupdeli WHERE userName = ? AND password = ? AND forwarding = 'usr' AND status = 'A'");
        $stmt->bind_param("ss", $userName, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    }

    // If user found in either admin or users table
    if ($admin || $user) {
        $userData = $admin ?: $user; // Use admin data if found, otherwise use user data
        $_SESSION['alogin'] = $userName;
        $_SESSION['id'] = $userData['id'];
        $contactNo = $userData['contactNo'];
        $userId = $userData['id'];
        $userEmail = $user['email'] ?? NULL; // Only for users, admin doesn't have userEmail

        // Insert successful login attempt into userlog
        $stmt = $con->prepare("INSERT INTO userlog (userName, userEmail, password, contactNo, userIp, status, logonTime) 
                               VALUES (?, ?, ?, ?, ?, 1, ?)");
        $stmt->bind_param("ssssss", $userName, $userEmail, $password, $contactNo, $userIp, $logonTime);
        $stmt->execute();
		
		$_SESSION['userlog_id'] = $con->insert_id;

        // Redirect to home page
        $extra = "home/index.php";
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        exit();
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";

        // Redirect back to login page
        $extra = "index.php";
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        exit();
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
						<input type="text" class="form-control" id="userName" name="userName" placeholder="username">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" id="password" name="password" placeholder="password">
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
					if (isset($con) && $con) {
						$sql = mysqli_query($con, "SELECT * FROM COMPANY a LEFT JOIN BASIC b ON a.id = b.compId WHERE a.id = 1 AND a.status = 'A'");
						if ($sql) {
							while ($row = mysqli_fetch_array($sql)) {
								?>
								<img src="logo/<?php echo $row['id']; ?>/<?php echo $row['logo']; ?>" />
								<?php
							}
						} else {
							echo "Query failed: " . mysqli_error($con);
						}
					} else {
						echo "Database connection not available.";
					}
					?>
				  </a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>