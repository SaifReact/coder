<?php
session_start();
include("include/config.php");

// Check if a user is logged in before updating the database
if (!empty($_SESSION['alogin']) && !empty($_SESSION['userlog_id'])) {
    $userName = $_SESSION['alogin'];
    $logId = $_SESSION['userlog_id'];

    // Update userlog table: Set status = 0 and logoutTime
    $stmt = $con->prepare("UPDATE userlog SET status = 0, logoutTime = NOW() WHERE userName = ? AND id = ?");
    $stmt->bind_param("si", $userName, $logId); // "si" -> String (userName) & Integer (logId)
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        error_log("Userlog updated successfully for user: $userName, logId: $logId");
    } else {
        error_log("Failed to update userlog for user: $userName, logId: $logId");
    }

    $stmt->close();
}

// Clear session data
session_unset();
session_destroy();

// Redirect to login page
header("Location: index.php");
exit();
?>

