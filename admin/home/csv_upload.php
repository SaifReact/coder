<?php
session_start();
include('../../includes/config.php');

// Ensure that the session is properly started and user is logged in
if (empty($_SESSION['alogin'])) {
    header('Location: index.php'); // Redirect to login page
    exit();
}

$csvId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if the CSV file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    // Check if file is not empty
    if (($handle = fopen($file, 'r')) !== false) {
        // Read the header row
        $header = fgetcsv($handle);

        // Start database transaction for better performance (optional)
        $con->begin_transaction();

        // Loop through each row
        while (($data = fgetcsv($handle)) !== false) {
            // Sanitize and assign values from CSV
            $name = $data[0];
            $email = $data[1];
            $phone = $data[2];

            // Prepare and bind the SQL statement to prevent SQL injection
            $stmt = $con->prepare("INSERT INTO xxx (name, email, phone) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $phone);

            // Execute the prepared statement
            if (!$stmt->execute()) {
                $_SESSION['warnmsg'] = "Error while inserting data: " . $stmt->error;
                $con->rollback(); // Rollback the transaction if there's an error
                break; // Stop the loop if there's an error
            }

            // Reset prepared statement for the next iteration
            $stmt->close();
        }

        // Commit the transaction if no errors occurred
        if (!isset($_SESSION['warnmsg'])) {
            $con->commit();
            $_SESSION['msg'] = "Added Successfully (সফলভাবে সংযুক্ত করা হয়েছে)!";
        }

        fclose($handle);
    } else {
        $_SESSION['warnmsg'] = "File reading error or empty file.";
    }

    // Redirect after processing
    header('Location: csv_upload.php'); // Redirect to csv_upload page
    exit(); // Make sure no further code is executed after the redirect
} 
?>

<!DOCTYPE html>
<html lang="en">
<?php include('share/head.php'); ?>

<body class="animsition">
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <?php include('share/menu.php'); ?>
        <!-- END MENU SIDEBAR-->
        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <?php include('share/header.php'); ?>
            <?php include('share/side-menu.php'); ?>
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
                                            <li class="list-inline-item">CSV File Upload (সিএসভি ফাইল আপলোড) </li>
                                        </ul>
                                    </div>
                                    <button id="submitCSV" class="au-btn au-btn-icon au-btn--green"><?php echo $csvId ? '' : 'Submit (সংরক্ষণ করুন)'; ?></button>
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
                                    <div class="card-header"><?php echo $csvId ? '' : 'Add'; ?> CSV File Upload ( সিএসভি ফাইল আপলোড <?php echo $csvId ? '' : 'সংযুক্তকরণ'; ?> )</div>
                                    <div class="card-body">
                                        <form id="csvForm" action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="csv_file" class="control-label mb-1">CSV File ( সিএসভি ফাইল )</label>
                                                        <input type="file" class="form-control-file" name="csv_file" accept=".csv" required >
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="csv_file" class="control-label mb-1">CSV File Upload Info ( সিএসভি ফাইল আপলোড ইনফো )</label>
                                                        <p></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- STATISTIC-->
            <?php include('share/footer.php'); ?>
            <!-- END PAGE CONTAINER-->
        </div>
    </div>
    <?php include('share/js.php'); ?>
    <script>
        document.getElementById("submitCSV").addEventListener("click", function () {
            document.getElementById("csvForm").submit(); // Trigger form submission
        });
    </script>
    <script>
        $(document).ready(function () {
            // Check if session messages exist and display them
            <?php if (!empty($_SESSION['msg'])) { ?>
                toastr.success("<?php echo addslashes($_SESSION['msg']); ?>");
                <?php unset($_SESSION['msg']); ?>
            <?php } ?>
            <?php if (!empty($_SESSION['warnmsg'])) { ?>
                toastr.warning("<?php echo addslashes($_SESSION['warnmsg']); ?>");
                <?php unset($_SESSION['warnmsg']); ?>
            <?php } ?>
        });
    </script>
</body>

</html>
