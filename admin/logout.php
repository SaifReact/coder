<?php
session_start();
include("../config/config.php");

if (!isset($pdo)) {
    die("Database connection failed in logout function");
}

if (!empty($_SESSION['alogin']) && !empty($_SESSION['userlog_id'])) {
    $userName = $_SESSION['alogin'];
    $logId = $_SESSION['userlog_id'];

    try {
        $stmt = $pdo->prepare("UPDATE userlog SET status = 0, logoutTime = NOW() WHERE userName = :userName AND id = :logId");
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':logId', $logId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            error_log("Userlog updated successfully for user: $userName, logId: $logId");
        } else {
            error_log("No rows updated for user: $userName, logId: $logId");
        }
    } catch (PDOException $e) {
        error_log("PDO Exception: " . $e->getMessage());
    }
}

session_unset();
session_destroy();

header("Location: index.php");
exit();
