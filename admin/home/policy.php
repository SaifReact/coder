<?php
session_start();
include('../../config/config.php');

if (empty($_SESSION['alogin'])) {
    header('Location: index.php');
    exit();
}

$policyId = isset($_GET['id']) ? intval(base64_decode($_GET['id'])) : 0;
$action = isset($_GET['del']) ? $_GET['del'] : '';
$policy = ['compId' => '', 'policyName' => '', 'dataToggle' => '', 'icon' => '', 'description' => ''];

	// Get policy function
	function getPolicy(PDO $pdo, int $policyId): ?array {
		$stmt = $pdo->prepare("SELECT a.*, b.id, b.companyName, b.companyName_bn FROM policy a 
		INNER JOIN company b ON a.compId = b.id WHERE a.id = ?");
		$stmt->execute([$policyId]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result ?: null;
	}

	// If editing (normal loading)
	if ($policyId > 0 && !$action) {
		$policyData = getPolicy($pdo, $policyId);
		if ($policyData) {
			$policy = $policyData;
		} else {
			$_SESSION['msg'] = "Policy Not Found.";
			header('Location: policy.php');
			exit();
		}
	}	
	
	// If Update and Insert request
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try { 
		$compId = trim($_POST['compId'] ?? '');
		$policyName = trim($_POST['policyName'] ?? '');
		$dataToggle = trim($_POST['dataToggle'] ?? '');
		$icon = trim($_POST['icon'] ?? '');
        $description = trim($_POST['description'] ?? '');
		$status = trim($_POST['status'] ?? 'A');

        if (empty($compId) || empty($policyName) || empty($dataToggle) || empty($icon) || empty($description)) {
            $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
            header('Location: policy.php');
            exit();
        }

        if ($policyData) {
            // UPDATE
            $sql = "UPDATE policy SET compId = :compId, policyName = :policyName, dataToggle = :dataToggle, 
				icon = :icon, description = :description, status = :status WHERE id = :policyId";

			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				'compId' => $compId, 'policyName' => $policyName, 'dataToggle' => $dataToggle, 'icon' => $icon,
				'description' => $description, 'status' => $status, 'policyId' => $policyId
			]);

			$_SESSION['msg'] = $stmt->rowCount() ? "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!" : "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
        } else {
            // INSERT
            $sql = "INSERT INTO policy (compId, policyName, dataToggle, icon, description, status)
                    VALUES (:compId, :policyName, :dataToggle, :icon, :description, :status)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'compId' => $compId, 'policyName' => $policyName, 'dataToggle' => $dataToggle,
                'icon' => $icon, 'description' => $description, 'status' => $status]);
			
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        }
	} catch (PDOException $e) {
		$_SESSION['warnmsg'] = "Process Error: " . $e->getMessage();
	}
		header('Location: policy.php');
		exit();
	}
	
	// If delete request
	if ($policyId > 0 && $action === 'delete') {
		try {
			$stmt = $pdo->prepare("DELETE FROM policy WHERE id = ?");
			$stmt->execute([$policyId]);

			if ($stmt->rowCount()) {
				$_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
			} else {
				$_SESSION['delmsg'] = "Policy Not Found to Delete.";
			}
		} catch (PDOException $e) {
			$_SESSION['delmsg'] = "Delete Failed: " . $e->getMessage();
		}
		header('Location: policy.php');
		exit();
	}
?>
<?php include('share/main.php');?>
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
							  <button id="submitPolicy" class="au-btn au-btn-icon au-btn--green"><?php echo $policyId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
                              <div class="card-header"><?php echo $policyId ? 'Update' : 'Add'; ?> Policy (নীতিসমূহ <?php echo $policyId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="policyForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
									   <div class="col-6">
											<div class="form-group">
												<label for="compId" class="form-control-label">Company Name (কোম্পানির নাম)</label>
												<?php
												$selectedCompId = $policy['compId'] ?? 0;

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
                                             <label for="policyName" class="control-label mb-1">Policy Name (নীতি নাম)</label>
											 <input id="policyName" name="policyName" type="text" class="form-control policyName valid"  autocomplete="policyName" 
                                                placeholder="Policy Name - নীতি নাম" value="<?php echo htmlentities($policy['policyName']); ?>">
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <div class="form-group">
                                             <label for="dataToggle" class="control-label mb-1">Data Toggle (ডেটা টগল)</label>
                                             <input id="dataToggle" name="dataToggle" type="text" class="form-control dataToggle valid"  autocomplete="dataToggle" 
                                                placeholder="Enter Data Toggley Name" value="<?php echo htmlentities($policy['dataToggle']); ?>">
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <label for="icon" class="control-label mb-1">Icon (আইকন)</label>
                                             <input id="icon" name="icon" type="text" class="form-control icon valid"  autocomplete="icon"
                                                placeholder="Enter Icon" value="<?php echo htmlentities($policy['icon']); ?>">
                                       </div>
									   <div class="col-6">
									   <?php if ($policyId && $policy['status']) { ?>
											<label for="status">Status (অবস্থা)</label>
											<select name="status" id="status" class="form-control">
												<option value="A" <?php echo ($policy['status'] == 'A') ? 'Active' : ''; ?>>Active (সক্রিয়)</option>
												<option value="I" <?php echo ($policy['status'] == 'I') ? 'Inactive' : ''; ?>>Inactive (নিষ্ক্রিয়)</option>
											</select>
										<?php } ?>
										</div>
									   <div class="col-12">
                                          <label for="description" class="control-label mb-1">Description (বর্ণনা)</label>
                                          <textarea name="description" placeholder="Content..." class="form-control"><?php echo htmlentities($policy['description'] ?? ''); ?></textarea>
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
											<th>Company Name (কোম্পানির নাম)</th>
                                            <th>Policy Name <br>(নীতিসমূহ)</th>
											<th>Data Toggle <br>(ডেটা টগল)</th>
											<th>Description <br>(বর্ণনা)</th>
                                            <th>Icon <br>(আইকন)</th>
											<th>Creation Date <br>(সংরক্ষণ তারিখ)</th>
                                            <th>Action <br>(কর্ম পদ্ধতি)</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
									try {
										$stmt = $pdo->query("SELECT a.*, b.companyName, b.companyName_bn FROM policy a INNER JOIN company b ON a.compId = b.id");
										$cnt = 1;
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
									?>
									<tr>
										<td><?php echo $cnt++; ?></td>
										<td><?php echo htmlentities($row['companyName']) . ' - ' . htmlentities($row['companyName_bn']); ?></td>
										<td><?php echo htmlentities($row['policyName']); ?></td>
										<td><?php echo htmlentities($row['dataToggle']); ?></td>
										<td><?php echo htmlentities($row['description']); ?></td>
										<td><?php echo htmlentities($row['icon']); ?></td>
										<td><?php echo htmlentities($row['creationDate']); ?></td>
										<td>
										<div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="policy.php?id=<?php echo urlencode(base64_encode($row['id'])); ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="policy.php?id=<?php echo urlencode(base64_encode($row['id'])); ?>&del=delete" onclick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
													<i class="zmdi zmdi-delete" style="color:#FF0000"></i>
												</a>
											</button>
										</div>
										</td>
									</tr>
									<?php 
										}
									} catch (PDOException $e) {
										echo "<tr><td colspan='7'>Error loading data: " . htmlentities($e->getMessage()) . "</td></tr>";
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
		document.getElementById("submitPolicy").addEventListener("click", function () {
        document.getElementById("policyForm").submit();
		});
	</script>

   </body>
   </html>
