<?php
session_start();
include('../../config/config.php');

if (empty($_SESSION['alogin'])) {
    header('Location: index.php');
    exit();
}

$compWiseImgId = isset($_GET['id']) ? intval(base64_decode($_GET['id'])) : 0;
$action = isset($_GET['del']) ? $_GET['del'] : '';
$compWiseImg = ['compId' => '', 'compInputName' => '', 'status' => ''];

	// Get policy function
	function getCompWiseImg(PDO $pdo, int $compWiseImgId): ?array {
		$stmt = $pdo->prepare("SELECT a.*, b.id, b.companyName, b.companyName_bn FROM compwiseimg a 
		INNER JOIN company b ON a.compId = b.id WHERE a.id = ?");
		$stmt->execute([$compWiseImgId]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result ?: null;
	}

	// If editing (normal loading)
	if ($compWiseImgId > 0 && !$action) {
		$compWiseImgData = getCompWiseImg($pdo, $compWiseImgId);
		if ($compWiseImgData) {
			$compWiseImg = $compWiseImgData;
		} else {
			$_SESSION['warnmsg'] = "Compnay Wise Image Not Found.";
			header('Location: compwiseimg.php');
			exit();
		}
	}	
	
	// If Update and Insert request
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try { 
		$compId = trim($_POST['compId'] ?? '');
		$compInputName = trim($_POST['compInputName'] ?? '');;
		$status = trim($_POST['status'] ?? 'A');

        if (empty($compId) || empty($compInputName)) {
            $_SESSION['warnmsg'] = "Input Information are required (ইনপুট তথ্য অতি আবশ্যক).";
            header('Location: compwiseimg.php');
            exit();
        }

        if ($compWiseImgData) {
			// UPDATE
			if (
				$compWiseImgData['compId'] === $compId &&
				$compWiseImgData['compInputName'] === $compInputName &&
				$compWiseImgData['status'] === $status
			) {
				$_SESSION['warnmsg'] = "No changes detected (কোন পরিবর্তন সনাক্ত করা যায়নি)।";
			} else {
				$sql = "UPDATE compwiseimg SET compId = :compId, compInputName = :compInputName, status = :status WHERE id = :compWiseImgId";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([
					'compId' => $compId,
					'compInputName' => $compInputName,
					'status' => $status,
					'compWiseImgId' => $compWiseImgId
				]);
				$_SESSION['msg'] = "Updated Successfully (সফলভাবে হালনাগাদ করা হয়েছে)!";
			}
        } else {
            // INSERT
            $sql = "INSERT INTO compwiseimg (compId, compInputName, status) VALUES (:compId, :compInputName, :status)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['compId' => $compId, 'compInputName' => $compInputName, 'status' => $status]);
			
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        }
	} catch (PDOException $e) {
		$_SESSION['delmsg'] = "Process Error: " . $e->getMessage();
	}
		header('Location: compwiseimg.php');
		exit();
	}
	
	// If delete request
	if ($compWiseImgId > 0 && $action === 'delete') {
		try {
			$stmt = $pdo->prepare("DELETE FROM compwiseimg WHERE id = ?");
			$stmt->execute([$compWiseImgId]);

			if ($stmt->rowCount()) {
				$_SESSION['delmsg'] = "Deleted Successfully (সফলভাবে মুছে ফেলা হয়েছে)!";
			} else {
				$_SESSION['delmsg'] = "Company Wise Image Not Found to Delete.";
			}
		} catch (PDOException $e) {
			$_SESSION['delmsg'] = "Delete Failed: " . $e->getMessage();
		}
		header('Location: compwiseimg.php');
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
                                    <li class="list-inline-item">Compnay Wise Image (কোম্পানি ভিত্তিক ছবি) </li>
                                 </ul>
                              </div>
							  <button id="submitCompWiseImg" class="au-btn au-btn-icon au-btn--green"><?php echo $compWiseImgId ? 'Update (হালনাগাদ করুন)' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
                              <div class="card-header"><?php echo $compWiseImgId ? 'Update' : 'Add'; ?> Compnay Wise Image (কোম্পানি ভিত্তিক ছবি <?php echo $compWiseImgId ? 'হালনাগাদ' : 'সংযুক্তকরণ'; ?> )</div>
                              <div class="card-body">
                                 <form id="compWiseImgForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
									   <div class="col-6">
											<div class="form-group">
												<label for="compId" class="form-control-label">Company Name (কোম্পানির নাম)</label>
												<?php
												$selectedCompId = $compWiseImg['compId'] ?? 0;

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
                                             <label for="compInputName" class="control-label mb-1">Company Wise Image Name (কোম্পানি ভিত্তিক ছবি নাম)</label>
											 <input id="compInputName" name="compInputName" type="text" class="form-control compInputName valid"  autocomplete="compInputName" 
                                                placeholder="Company Wise Image Input - কোম্পানি ভিত্তিক ছবি ইনপুট" value="<?php echo htmlentities($compWiseImg['compInputName']); ?>">
                                          </div>
                                       </div>
                                       
                                       
									   <div class="col-6">
									   <?php if ($compWiseImgId && $compWiseImg['status']) { ?>
											<label for="status">Status (অবস্থা)</label>
											<select name="status" id="status" class="form-control">
												<option value="A" <?php echo ($compWiseImg['status'] == 'A') ? 'Active' : ''; ?>>Active (সক্রিয়)</option>
												<option value="I" <?php echo ($compWiseImg['status'] == 'I') ? 'Inactive' : ''; ?>>Inactive (নিষ্ক্রিয়)</option>
											</select>
										<?php } ?>
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
                                            <th>Company Wise Image Name <br> (কোম্পানি ভিত্তিক ছবি নাম)</th>
											<th>Creation Date <br>(সংরক্ষণ তারিখ)</th>
                                            <th>Action <br>(কর্ম পদ্ধতি)</th>
                                        </tr>
                                    </thead>
                                 <tbody>
								 <?php 
									try {
										$stmt = $pdo->query("SELECT a.*, b.companyName, b.companyName_bn FROM compwiseimg a INNER JOIN company b ON a.compId = b.id");
										$cnt = 1;
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
									?>
									<tr>
										<td><?php echo $cnt++; ?></td>
										<td><?php echo htmlentities($row['companyName']) . ' - ' . htmlentities($row['companyName_bn']); ?></td>
										<td><?php echo htmlentities($row['compInputName']); ?></td>
										<td><?php echo htmlentities($row['creationDate']); ?></td>
										<td>
										<div class="table-data-feature">
											<button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
												<a href="compwiseimg.php?id=<?php echo urlencode(base64_encode($row['id'])); ?>" style="text-decoration: none; display: flex; align-items: center;">
													<i class="zmdi zmdi-edit" style="color:#008000"></i>
												</a>
											</button>
											<button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
												<a href="compwiseimg.php?id=<?php echo urlencode(base64_encode($row['id'])); ?>&del=delete" onclick="return confirm('Are you sure (আপনি কি নিশ্চিত)?')">
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
		document.getElementById("submitCompWiseImg").addEventListener("click", function () {
        document.getElementById("compWiseImgForm").submit();
		});
	</script>

   </body>
   </html>
