<?php
session_start();
include('../../includes/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

$companyId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$company = ['companyName' => '', 'companyName_bn'  => '', 'status' => '' ];

function getCompany($con, $companyId) {
    $stmt = $con->prepare("SELECT * FROM company WHERE id = ?");
    $stmt->bind_param("i", $companyId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc() ?: null;
}

if ($companyId > 0) {
    $companyData = getCompany($con, $companyId);
    if ($companyData) {
        $company = $companyData;
    } else {
        $_SESSION['msg'] = "Company Not Found.";
        header('Location: company.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
    $companyName = trim($_POST['companyName'] ?? '');
	$companyName_bn = trim($_POST['companyName_bn'] ?? '');
    $status = trim($_POST['status'] ?? 'A'); // Set default status to 'A' if not provided

     // Prevent processing if required fields are missing
    if (empty($companyName) || empty($companyName_bn)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: company.php');
        exit();
    }

    if ($companyId > 0) {
        // Update only if there are changes
        if ($companyName !== $company['companyName'] || $companyName_bn !== $company['companyName_bn'] || $status !== $company['status']) {
            $stmt = $con->prepare("UPDATE company SET companyName = ?, companyName_bn = ?, status = ? WHERE id = ?");
            
            if (!$stmt) {
                die("Prepare failed: Update Column Error" . $con->error); // Debugging: Show MySQL error
            }

            $stmt->bind_param("sssi", $companyName, $companyName_bn, $status, $companyId);
            $stmt->execute();
            $stmt->close();
            
            $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
        }
    } else {
        $stmt = $con->prepare("INSERT INTO company (companyName, companyName_bn, status) VALUES (?, ?, ?)");

        if (!$stmt) {
            die("Prepare failed: Insert Column Error" . $con->error);
        }

        $stmt->bind_param("sss", $companyName, $companyName_bn, $status,);
        
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Database error: Operation failed.";
        }

        $stmt->close();
    }

    header('Location: company.php');
    exit();
}


if (isset($_GET['del']) && $companyId > 0) {
    $coupon = getCompany($con, $companyId);
    if ($coupon) {
        $stmt = $con->prepare("DELETE FROM company WHERE id = ?");
        $stmt->bind_param("i", $companyId);
        if ($stmt->execute()) {
            $_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
        } else {
            $_SESSION['delmsg'] = "Database error: Failed to delete cat.";
        }
        $stmt->close();
    } else {
        $_SESSION['delmsg'] = "Company not found. Cannot delete.";
    }
    header('Location: company.php');
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
                                    <li class="list-inline-item">Company (কোম্পানি) </li>
                                 </ul>
                              </div>
							  <button id="submitCompany" class="au-btn au-btn-icon au-btn--green"><?php echo $companyId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
                              <div class="card-header"><?php echo $companyId ? 'Update' : 'Add'; ?> Company (কোম্পানি <?php echo $companyId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="companyForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                       <div class="col-6">
                                          <label for="companyName" class="control-label mb-1">Company Name ( কোম্পানি নাম )</label>
                                             <input id="companyName" name="companyName" type="text" class="form-control companyName valid"  autocomplete="companyName"
                                                placeholder="Enter Company Name" value="<?php echo htmlentities($company['companyName']); ?>">
                                       </div>
									   <div class="col-6">
                                          <label for="companyName_bn" class="control-label mb-1">Company Name Bangla ( কোম্পানি নাম বাংলা )</label>
                                             <input id="companyName_bn" name="companyName_bn" type="text" class="form-control companyName_bn valid" autocomplete="companyName_bn"
                                                placeholder="Enter Company Name Bangla" value="<?php echo htmlentities($company['companyName_bn']); ?>">
                                       </div>
									</div>
									<div class="row">
									   <?php if ($companyId && $company['status']) { ?>
										<div class="col-6">
											<label for="status">Status ( অবস্থা )</label>
											<select name="status" id="status" class="form-control">
												<option value="A" <?php echo ($company['status'] == 'A') ? 'Active' : ''; ?>>Active (সক্রিয়)</option>
												<option value="I" <?php echo ($company['status'] == 'I') ? 'Inactive' : ''; ?>>Inactive (নিষ্ক্রিয়)</option>
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
                                            <th>Company Name<br> ( কোম্পানি নাম )</th>
											<th>Status <br>( অবস্থা )</th>
											<th>Creation Date <br>( সংরক্ষণ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT * FROM company ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['companyName']).' - '.htmlentities($row['companyName_bn']); ?></td>
									   <td><?php echo htmlentities($row['status'] == 'A') ? 'Active (সক্রিয়)' : 'Inactive (নিষ্ক্রিয়)'; ?></td>
									   <td><?php echo htmlentities($row['creationDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="company.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="company.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
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
		document.getElementById("submitCompany").addEventListener("click", function () {
        document.getElementById("companyForm").submit();
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
