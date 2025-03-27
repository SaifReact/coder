<?php
session_start();
include('../include/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

$couponId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$coupon = ['couponCode' => '', 'cashOff'  => '', 'value' => '', 'status' => '' ];

function getCoupon($con, $couponId) {
    $stmt = $con->prepare("SELECT * FROM coupon");
    $stmt->bind_param("i", $couponId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc() ?: null;
}

if ($couponId > 0) {
    $couponData = getCoupon($con, $couponId);
    if ($couponData) {
        $coupon = $couponData;
    } else {
        $_SESSION['msg'] = "Coupon Not Found.";
        header('Location: coupon.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cashOff = trim($_POST['cashOff'] ?? '');
    $value = $cashOff / 100;
    $couponCode = 'coupon' . $cashOff;
    $status = trim($_POST['status'] ?? 'A'); // Set default status to 'A' if not provided

    if (empty($cashOff)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: coupon.php');
        exit();
    }

    if ($couponId > 0) {
        // Update only if there are changes
        if ($cashOff !== $coupon['cashOff'] || $value !== $coupon['value'] || $couponCode !== $coupon['couponCode'] || $status !== $coupon['status']) {
            $stmt = $con->prepare("UPDATE coupon SET couponCode = ?, cashOff = ?, value = ?, status = ? WHERE id = ?");
            
            if (!$stmt) {
                die("Prepare failed: hi" . $con->error); // Debugging: Show MySQL error
            }

            $stmt->bind_param("ssssi", $couponCode, $cashOff, $value, $status, $couponId);
            $stmt->execute();
            $stmt->close();
            
            $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
        }
    } else {
        $stmt = $con->prepare("INSERT INTO coupon (couponCode, cashOff, value, status) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            die("Prepare failed: hello" . $con->error);
        }

        $stmt->bind_param("ssss", $couponCode, $cashOff, $value, $status);
        
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Operation failed.";
        }

        $stmt->close();
    }

    header('Location: coupon.php');
    exit();
}


if (isset($_GET['del']) && $couponId > 0) {
    $coupon = getCoupon($con, $couponId);
    if ($coupon) {
        $stmt = $con->prepare("DELETE FROM coupon WHERE id = ?");
        $stmt->bind_param("i", $couponId);
        if ($stmt->execute()) {
            $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete cat.";
        }
        $stmt->close();
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
            <?php include('share/header.php');?>
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
                                          <label for="cashOff" class="control-label mb-1">Cash Offer ( নগদ অফার - নীট মূল্য হতে যত টাকা কমবে )</label>
                                             <input id="cashOff" name="cashOff" type="text" class="form-control cashOff valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="cashOff"
                                                placeholder="Enter Cash Off Taka" value="<?php echo htmlentities($coupon['cashOff']); ?>">
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
                                        $query = $con->query("SELECT * FROM coupon ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['cashOff']); ?></td>
									   <td><?php echo htmlentities($row['couponCode']); ?></td>
									   <td><?php echo htmlentities($row['value']); ?></td>
									   <td><?php echo htmlentities($row['status'] == 'A') ? 'Active (সক্রিয়)' : 'Inactive (নিষ্ক্রিয়)'; ?></td>
									   <td><?php echo htmlentities($row['creation_date']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="coupon.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="coupon.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
													<i class="zmdi zmdi-delete" style="color:#FF0000"></i>
												</a>
											</button>
                                        </div>
                                       </td>
                                    </tr>
                                   <?php } ?>
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
