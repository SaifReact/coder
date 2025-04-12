<?php
session_start();
include("../includes/config.php");

if (!$con) {
    die("Database connection failed in logout.php");
}

if (!empty($_SESSION['alogin']) && !empty($_SESSION['userlog_id'])) {
    $userName = $_SESSION['alogin'];
    $logId = $_SESSION['userlog_id'];

    $stmt = $con->prepare("UPDATE userlog SET status = 0, logoutTime = NOW() WHERE userName = ? AND id = ?");
    
    if ($stmt) {
        $stmt->bind_param("si", $userName, $logId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            error_log("Userlog updated successfully for user: $userName, logId: $logId");
        } else {
            error_log("No rows updated for user: $userName, logId: $logId");
        }

        $stmt->close();
    } else {
        error_log("Prepare failed: " . $con->error);
    }
}

session_unset();
session_destroy();

header("Location: index.php");
exit();
?>
