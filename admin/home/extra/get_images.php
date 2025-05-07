<?php
session_start();
include('../../../config/config.php');
header('Content-Type: text/html; charset=UTF-8');

// Input validation
if (!isset($_POST['compId']) || !is_numeric($_POST['compId'])) {
    echo '<option value="">Invalid Image Type</option>';
    exit;
}

$compId = intval($_POST['compId']);

try {
    $stmt = $pdo->prepare("SELECT id, compInputName FROM compwiseimg WHERE compId = :compId AND STATUS = 'A'");
    $stmt->execute([':compId' => $compId]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$results) {
        echo '<option value="">No Image Place found</option>';
        exit;
    }

    foreach ($results as $row) {
        echo "<option value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>" .
             htmlspecialchars($row['compInputName'], ENT_QUOTES, 'UTF-8') .
             "</option>";
    }

} catch (PDOException $e) {
    echo '<option value="">Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</option>';
    exit;
}
?>
