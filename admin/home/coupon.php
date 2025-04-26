<?php
session_start();
include('../../config/config.php'); // Assumes PDO connection is stored in $pdo

if (empty($_SESSION['alogin'])) {
    header('Location: index.php');
    exit();
}

$couponId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$coupon = ['compId' => '', 'proId' => '', 'couponCode' => '', 'cashOff' => '', 'value' => '', 'cashOffPrice' => '', 'status' => ''];

// Fetch coupon by ID
function getCoupon(PDO $pdo, int $couponId): ?array {
    $stmt = $pdo->prepare("SELECT * FROM coupon WHERE id = :id");
    $stmt->execute([':id' => $couponId]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

// Load existing coupon if ID is provided
if ($couponId > 0) {
    $couponData = getCoupon($pdo, $couponId);
    if ($couponData) {
        $coupon = $couponData;
    } else {
        $_SESSION['msg'] = "Coupon Not Found.";
        header('Location: coupon.php');
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cashOff = trim($_POST['cashOff'] ?? '');
    $value = $cashOff / 100;
    $couponCode = 'coupon' . $cashOff;
    $status = trim($_POST['status'] ?? 'A');

    if (empty($cashOff)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: coupon.php');
        exit();
    }

    if ($couponId > 0) {
        // Update if changes exist
        if ($cashOff !== $coupon['cashOff'] || $value != $coupon['value'] || $couponCode !== $coupon['couponCode'] || $status !== $coupon['status']) {
            $stmt = $pdo->prepare("UPDATE coupon SET couponCode = :couponCode, cashOff = :cashOff, value = :value, status = :status WHERE id = :id");
            $stmt->execute([
                ':couponCode' => $couponCode,
                ':cashOff' => $cashOff,
                ':value' => $value,
                ':status' => $status,
                ':id' => $couponId
            ]);
            $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
        }
    } else {
        $stmt = $pdo->prepare("INSERT INTO coupon (couponCode, cashOff, value, status) VALUES (:couponCode, :cashOff, :value, :status)");
        $success = $stmt->execute([
            ':couponCode' => $couponCode,
            ':cashOff' => $cashOff,
            ':value' => $value,
            ':status' => $status
        ]);

        if ($success) {
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Operation failed.";
        }
    }

    header('Location: coupon.php');
    exit();
}

// Handle deletion
if (isset($_GET['del']) && $couponId > 0) {
    $coupon = getCoupon($pdo, $couponId);
    if ($coupon) {
        $stmt = $pdo->prepare("DELETE FROM coupon WHERE id = :id");
        $stmt->execute([':id' => $couponId]);
        $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
    } else {
        $_SESSION['delmsg'] = "Coupon not found. Cannot delete.";
    }
    header('Location: coupon.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
   <?php include('share/head.php');?>
   <body class="animsition">
      <div class="page-wrapper">
         <!-- MENU SIDEBAR-->
         <?php include('share/menu.php');?>
         <!-- END MENU SIDEBAR-->
         <!-- PAGE CONTAINER-->
         <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop2"> <?php include('share/header.php');?> </header>
            <?php include('share/side-menu.php');?>
            <!-- END HEADER DESKTOP-->
            <!-- BREADCRUMB-->
            <section class="au-breadcrumb m-t-75">
               <div class="section__content section__content--p30">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="au-breadcrumb-content">
                              <div class="au-breadcrumb-left">
                                 <ul class="list-unstyled list-inline au-breadcrumb__list">
                                    <li class="list-inline-item active">
                                       <a href="#">Dashboard</a>
                                    </li>
                                    <li class="list-inline-item seprate">
                                       <span>/</span>
                                    </li>
                                    <li class="list-inline-item">Coupon (কুপন) </li>
                                 </ul>
                              </div>
							  <button id="submitCoupon" class="au-btn au-btn-icon au-btn--green"><?php echo $couponId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- END BREADCRUMB-->
            <div class="main-content">
               <div class="section__content section__content--p30">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card">
                              <div class="card-header"><?php echo $couponId ? 'Update' : 'Add'; ?> coupon (কুপন <?php echo $couponId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="couponForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
									   <div class="col-6">
											<div class="form-group">
												<label for="compId" class="form-control-label">Company Name ( কোম্পানির নাম )</label>
												<?php
												$selectedCompId = $basic['compId'] ?? 0;

												echo '<select name="compId" id="compId" class="form-control">';
												echo '<option value="0"' . ($selectedCompId == 0 ? ' selected' : '') . '>Please Select - নির্বাচন করুন</option>';

												try {
													$stmt = $pdo->query("SELECT id, companyName, companyName_bn FROM company WHERE status = 'A'");
													while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
														$id = (int)$row['id'];
														$selected = ($id === (int)$selectedCompId) ? ' selected' : '';
														$name = htmlentities($row['companyName']);
														$name_bn = htmlentities($row['companyName_bn']);
														echo "<option value='{$id}'{$selected}>{$name} - {$name_bn}</option>";
													}
												} catch (PDOException $e) {
													echo '<option value="">Error loading companies</option>';
												}

												echo '</select>';
												?>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="proId" class="form-control-label">Product Name ( পণ্যের নাম )</label>
												<?php
												$selectedProId = $basic['proId'] ?? 0;

												echo '<select name="proId" id="proId" class="form-control">';
												echo '<option value="0"' . ($selectedProId == 0 ? ' selected' : '') . '>Please Select - নির্বাচন করুন</option>';

												try {
													$stmt = $pdo->query("SELECT * FROM products WHERE status = 'A'");
													while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
														$id = (int)$row['id'];
														$selected = ($id === (int)$selectedProId) ? ' selected' : '';
														$name = htmlentities($row['productName']);
														$name_bn = htmlentities($row['productName_bn']);
														echo "<option value='{$id}'{$selected}>{$name} - {$name_bn}</option>";
													}
												} catch (PDOException $e) {
													echo '<option value="">Error loading products</option>';
												}

												echo '</select>';
												?>
											</div>
										</div>
										<div class="col-6">
                                          <label for="price" class="control-label mb-1">Price ( বর্তমান মূল্য )</label>
                                             <input id="price" name="price" type="text" class="form-control price valid" autocomplete="price"
                                                placeholder="Enter Present Price" value="<?php echo htmlentities($coupon['price']); ?>" disabled>
                                       </div>
                                       <div class="col-6">
                                          <label for="cashOff" class="control-label mb-1">Cash Offer ( নগদ অফার (%) )</label>
                                             <input id="cashOff" name="cashOff" type="text" class="form-control cashOff valid" autocomplete="cashOff"
                                                placeholder="Enter Cash Off Taka" value="<?php echo htmlentities($coupon['cashOff']); ?>">
                                       </div>
									   <div class="col-6">
                                          <label for="cashOff" class="control-label mb-1">Cash Off Price ( অফারের পরের মূল্য )</label>
                                             <input id="cashOffPrice" name="cashOffPrice" type="text" class="form-control cashOffPrice valid" autocomplete="cashOffPrice"
                                                placeholder="Enter Cash Off Price" value="<?php echo htmlentities($coupon['cashOffPrice']); ?>" disabled>
                                       </div>
									   <?php if ($couponId && $coupon['status']) { ?>
										<div class="col-6">
											<label for="status">Status</label>
											<select name="status" id="status" class="form-control">
												<option value="A" <?php echo ($coupon['status'] == 'A') ? 'Active' : ''; ?>>Active (সক্রিয়)</option>
												<option value="I" <?php echo ($coupon['status'] == 'I') ? 'Inactive' : ''; ?>>Inactive (নিষ্ক্রিয়)</option>
											</select>
										</div>
									<?php } ?>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row m-t-30">
                        <div class="col-md-12">
                           <!-- DATA TABLE-->
                           <div class="table-responsive m-b-40">
                              <table class="table table-borderless table-data3">
                                 <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cash Off <br> ( নগদ অফার )</th>
											<th>Coupon Code <br> ( কুপন কোড )</th>
											<th>Value <br>( শতকরা % )</th>
											<th>Status <br>( অবস্থা )</th>
											<th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
									try {
										$stmt = $pdo->query("SELECT * FROM coupon ORDER BY id DESC");
										$coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
										$cnt = 1;

										foreach ($coupons as $row): 
									?>
									<tr>
										<td><?= $cnt++; ?></td>
										<td><?= htmlentities($row['cashOff']) ?></td>
										<td><?= htmlentities($row['couponCode']) ?></td>
										<td><?= htmlentities($row['value']) ?></td>
										<td><?= $row['status'] === 'A' ? 'Active (সক্রিয়)' : 'Inactive (নিষ্ক্রিয়)' ?></td>
										<td><?= htmlentities($row['creation_date']) ?></td>
										<td>
											<div class="table-data-feature">
												<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
													<a href="coupon.php?id=<?= $row['id'] ?>" style="text-decoration: none; display: flex; align-items: center;">
														<i class="zmdi zmdi-edit" style="color:#008000"></i>
													</a>
												</button>
												<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
													<a href="coupon.php?id=<?= $row['id'] ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
														<i class="zmdi zmdi-delete" style="color:#FF0000"></i>
													</a>
												</button>
											</div>
										</td>
									</tr>
									<?php 
										endforeach;
									} catch (PDOException $e) {
										echo "<tr><td colspan='7'>Error: " . htmlentities($e->getMessage()) . "</td></tr>";
									}
									?>

                                 </tbody>
                              </table>
                           </div>
                           <!-- END DATA TABLE-->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- STATISTIC-->
            <?php include('share/footer.php');?>
            <!-- END PAGE CONTAINER-->
         </div>
      </div>
      <?php include('share/js.php');?>
	  <script>
		document.getElementById("submitCoupon").addEventListener("click", function () {
        document.getElementById("couponForm").submit();
		});
	</script>
	<script>
		$(document).ready(function () {
			<?php if (!empty($_SESSION['msg'])) { ?>
				toastr.success("<?php echo addslashes($_SESSION['msg']); ?>");
				<?php unset($_SESSION['msg']); ?>
			<?php } ?>
			<?php if (!empty($_SESSION['warnmsg'])) { ?>
				toastr.warning("<?php echo addslashes($_SESSION['warnmsg']); ?>");
				<?php unset($_SESSION['warnmsg']); ?>
			<?php } ?>
			<?php if (!empty($_SESSION['delmsg'])) { ?>
				toastr.error("<?php echo addslashes($_SESSION['delmsg']); ?>");
				<?php unset($_SESSION['delmsg']); ?>
			<?php } ?>
		});
	</script>

   </body>
