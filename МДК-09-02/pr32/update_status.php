<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$request_id = $_POST['request_id'] ?? 0;
$status = $_POST['status'] ?? '';

if ($request_id && $status) {
    $stmt = $conn->prepare("UPDATE requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $request_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: admin.php");
exit;
?>