<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();

// Include the database configuration
include('../../config/config.php');

// Check if the session is not set or the user is not logged in
if (strlen($_SESSION['alogin']) == 0) {
    // Redirect to login page if not logged in
    header('location:index.php');
    exit; // Stop further execution after redirection
}
?>

<!DOCTYPE html>
<html lang="en"> <?php include('share/head.php');?> <body class="animsition">
    <div class="page-wrapper">
      <!-- MENU SIDEBAR--> <?php include('share/menu.php');?>
      <!-- END MENU SIDEBAR-->
      <!-- PAGE CONTAINER-->
      <div class="page-container2">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop2"> <?php include('share/header.php');?> </header> <?php include('share/side-menu.php');?>
        <!-- END HEADER DESKTOP-->
        <section class="statistic">
          <div class="section__content section__content--p30">
            <div class="container-fluid">
              <div class="row"> <?php
                // Define today's start and end
                $from = date('Y-m-d') . " 00:00:00";
                $to = date('Y-m-d') . " 23:59:59";

                // Fetch all required stats in one go
                try {
                    // Today's Order
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE orderStatus = 'N' AND orderDate BETWEEN ? AND ?");
                    $stmt->execute([$from, $to]);
                    $tOrder = $stmt->fetchColumn();

                    // Pending Order
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE orderStatus = ?");
                    $stmt->execute(['in Process']);
                    $pOrder = $stmt->fetchColumn();

                    // Delivered Order
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE orderStatus = ?");
                    $stmt->execute(['Delivered']);
                    $dOrder = $stmt->fetchColumn();

                    // Brands
                    $brName = $pdo->query("SELECT COUNT(*) FROM brands")->fetchColumn();

                    // Category
                    $catName = $pdo->query("SELECT COUNT(*) FROM category")->fetchColumn();

                    // Sub Category
                    $scatName = $pdo->query("SELECT COUNT(*) FROM subCategory")->fetchColumn();

                    // Products
                    $proName = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();

                    // Customers
                    $users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

                    // Delivery Man (You reused products here; adjust if needed)
                    $deliveryMan = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(); // Update this if you have a delivery table

                    // User Log
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM userlog WHERE logonTime BETWEEN ? AND ?");
                    $stmt->execute([$from, $to]);
                    $userLog = $stmt->fetchColumn();
                } catch (PDOException $e) {
                    echo "Database error: " . $e->getMessage();
                    exit;
                }
                ?>
                <!-- Statistics Boxes --> <?php
                $stats = [
                    ['value' => $tOrder, 'desc' => "Today's Order", 'icon' => 'zmdi-shopping-cart'],
                    ['value' => $pOrder, 'desc' => 'Pending Order', 'icon' => 'zmdi-account-o'],
                    ['value' => $dOrder, 'desc' => 'Delivered Order', 'icon' => 'zmdi-calendar-note'],
                    ['value' => $brName, 'desc' => 'Brands', 'icon' => 'zmdi-money'],
                    ['value' => $catName, 'desc' => 'Category', 'icon' => 'zmdi-money'],
                    ['value' => $scatName, 'desc' => 'Sub Category', 'icon' => 'zmdi-money'],
                    ['value' => $proName, 'desc' => 'Products', 'icon' => 'zmdi-money'],
                    ['value' => $users, 'desc' => 'Customers', 'icon' => 'zmdi-money'],
                    ['value' => $deliveryMan, 'desc' => 'Delivery Man', 'icon' => 'zmdi-money'],
                    ['value' => $userLog, 'desc' => 'User Log', 'icon' => 'zmdi-money'],
                ];

                foreach ($stats as $stat) {
                    echo '
                    
								<div class="col-md-6 col-lg-4">
									<div class="statistic__item">
										<h2 class="number">' . htmlentities($stat['value']) . '</h2>
										<span class="desc">' . $stat['desc'] . '</span>
										<div class="icon">
											<i class="zmdi ' . $stat['icon'] . '"></i>
										</div>
									</div>
								</div>';
                }
                ?>
              </div>
            </div>
          </div>
        </section> <?php include('share/footer.php');?>
        <!-- END PAGE CONTAINER-->
      </div>
    </div> <?php include('share/js.php');?>
  </body>