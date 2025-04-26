<?php
session_start();
include("../config/config.php"); // Assumes $pdo is created in this file using PDO

if (isset($_POST['submit'])) {
    $userName = $_POST['userName'];
    $password = md5($_POST['password']); // Consider switching to password_hash in future
    $userIp = $_SERVER['REMOTE_ADDR'];
    $logonTime = date("Y-m-d H:i:s");

    $userData = null;
    $userEmail = null;
    $contactNo = null;

    try {
        // Check admin table
        $stmt = $pdo->prepare("SELECT id, contactNo FROM admin WHERE userName = ? AND password = ?");
        $stmt->execute([$userName, $password]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // If not found in admin, check cusupdeli
        if (!$admin) {
            $stmt = $pdo->prepare("SELECT id, contactNo, email FROM cusupdeli WHERE userName = ? AND password = ? AND forwarding = 'usr' AND status = 'A'");
            $stmt->execute([$userName, $password]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        if ($admin || $user) {
            $userData = $admin ?? $user;
            $contactNo = $userData['contactNo'];
            $userId = $userData['id'];
            $userEmail = $user['email'] ?? null;

            $_SESSION['alogin'] = $userName;
            $_SESSION['id'] = $userId;

            // Insert into userlog
            $stmt = $pdo->prepare("INSERT INTO userlog (userName, userEmail, password, contactNo, userIp, status, logonTime) 
                                   VALUES (?, ?, ?, ?, ?, 1, ?)");
            $stmt->execute([$userName, $userEmail, $password, $contactNo, $userIp, $logonTime]);

            $_SESSION['userlog_id'] = $pdo->lastInsertId();

            // Redirect
            header("Location: home/index.php");
            exit;
        } else {
            $_SESSION['errmsg'] = "Invalid username or password";
            header("Location: index.php");
            exit;
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
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
			<?php
				if (!empty($_SESSION['errmsg'])) {
					echo '<span style="color:red;">' . htmlentities($_SESSION['errmsg']) . '</span>';
					$_SESSION['errmsg'] = ""; // clear it after displaying
				}
			?>
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
					try {
						$stmt = $pdo->prepare("SELECT * FROM COMPANY a LEFT JOIN BASIC b ON a.id = b.compId WHERE a.id = 1 AND a.status = 'A'");
						$stmt->execute();
						$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

						foreach ($companies as $row) {
							echo '<img src="logo/' . $row['id'] . '/' . $row['logo'] . '" />';
						}
					} catch (PDOException $e) {
						echo "Query failed: " . $e->getMessage();
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