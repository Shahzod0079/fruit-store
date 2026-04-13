<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$post_id = (int)$_GET['id'];
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);

if ($stmt->execute()) {
} else {
    $_SESSION['error_message'] = "Ошибка при удалении: " . $conn->error;
}

$stmt->close();
$conn->close();

header("Location: admin.php");
exit;
?>