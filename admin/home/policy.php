<?php
session_start();
include('../../includes/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

$policyId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$policy = ['policyName' => '', 'dataToggle' => '', 'description'  => '', 'icon'  => ''];

function getPolicy($con, $policyId) {
    $stmt = $con->prepare("SELECT * FROM policy WHERE id = ?");
    $stmt->bind_param("i", $policyId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc() ?: null;
}

if ($policyId > 0) {
    $policyData = getPolicy($con, $policyId);
    if ($policyData) {
        $policy = $policyData;
    } else {
        $_SESSION['msg'] = "Policy Not Found.";
        header('Location: policy.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $description = trim($_POST['description'] ?? '');

    // Prevent processing if required fields are missing
    if (empty($description)) {
        $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
        header('Location: policy.php');
        exit();
    }

    // Check if category is being updated
    if ($policyId > 0) {
    // Check if any data has changed
    if (
        $description !== $policy['description']  
    ) {
        // Prepare the SQL statement
        $stmt = $con->prepare("UPDATE policy SET description = ? WHERE id = ?");

        if ($stmt === false) {
            die("Prepare failed: " . $con->error);
        }

        // Bind parameters
        $stmt->bind_param("si",$description, $policyId);

        // Execute and close
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
        } else {
            $_SESSION['warnmsg'] = "Update failed: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
    }
} else {
    $_SESSION['warnmsg'] = "Invalid Policy ID!";
}

    // Redirect to the basic.php page with appropriate messages
    header('Location: policy.php');
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
                                    <li class="list-inline-item">Policy (নীতিসমূহ) </li>
                                 </ul>
                              </div>
							  <button id="submitPolicy" class="au-btn au-btn-icon au-btn--green"><?php echo $policyId ? 'Update (হালনাগাদ করুন)' : ''; ?></button>
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
								
                              <div class="card-header"><?php echo $policyId ? 'Update' : ''; ?> Policy (নীতিসমূহ <?php echo $policyId ? 'হালনাগাদ' : ''; ?> )</div>
                              <div class="card-body">
                                 <form id="policyForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
									   <div class="col-12">
											<div class="form-group">
												<label for="select" class="form-control-label">Policy Name ( নীতি নাম )</label>
												<select name="policyName" id="policyName" class="form-control" disabled>
													<?php if (!empty($policy['id'])) { ?>
														<option value="<?php echo htmlentities($policy['ic']); ?>"> 
															<?php echo htmlentities($policy['policyName']); ?>
														</option>
													<?php } else { ?>
														<option value="0"> Please Select - নির্বাচন করুন</option>
													<?php } ?>

													<?php 
													$query = mysqli_query($con, "SELECT * FROM POLICY");
													while ($row = mysqli_fetch_assoc($query)) {
														echo "<option value='" . htmlentities($row['id']) . "'>". htmlentities($row['policyName']) . "</option>";

													}
													?>
												</select>
											</div>
										</div>

                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="dataToggle" class="control-label mb-1">Data Toggle ( ডেটা টগল )</label>
                                             <input id="dataToggle" name="dataToggle" type="text" class="form-control dataToggle valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="dataToggle" 
                                                placeholder="Enter Data Toggley Name" value="<?php echo htmlentities($policy['dataToggle']); ?>" disabled>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="icon" class="control-label mb-1">Icon ( আইকন)</label>
                                             <input id="icon" name="icon" type="text" class="form-control icon valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="icon"
                                                placeholder="Enter Icon" value="<?php echo htmlentities($policy['icon']); ?>" disabled>
                                       </div>
									   <div class="col-12">
                                          <label for="description" class="control-label mb-1">Description ( বর্ণনা)</label>
                                             <textarea name="description" id="description" rows="5" placeholder="Content..." class="form-control"><?php echo htmlentities($policy['description'] ?? ''); ?></textarea>
                                       </div>
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
                                            <th>Policy Name <br>( নীতিসমূহ )</th>
											<th>Data Toggle <br>( ডেটা টগল )</th>
											<th>Description <br>( বর্ণনা )</th>
                                            <th>icon <br>( আইকন )</th>
											<th>Updation Date <br>( হালনাগাদ তারিখ )</th>
                                            <th>Action <br>( কর্ম পদ্ধতি )</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
                                        $query = $con->query("SELECT * FROM policy ORDER BY id DESC");
                                        $cnt = 1;
                                        while ($row = $query->fetch_assoc()) { 
                                        ?>
                                    <tr>
                                       <td><?php echo $cnt++; ?></td>
									   <td><?php echo htmlentities($row['policyName']); ?></td>
									   <td><?php echo htmlentities($row['dataToggle']); ?></td>
									   <td><?php echo htmlentities($row['description']); ?></td>
									   <td><?php echo htmlentities($row['icon']); ?></td>
                                       <td><?php echo htmlentities($row['updationDate']); ?></td>
									   <td>
                                        <div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="policy.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
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
		document.getElementById("submitPolicy").addEventListener("click", function () {
        document.getElementById("policyForm").submit();
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
