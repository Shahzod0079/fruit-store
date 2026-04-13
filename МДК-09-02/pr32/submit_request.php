<?php
include 'config.php';

$services_id = $_POST['services_id'] ?? '';
$fio = $_POST['fio'] ?? '';
$phone = $_POST['phone'] ?? '';

if ($services_id && $fio && $phone) {
    $stmt = $conn->prepare("INSERT INTO requests (fio, phone, services_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $fio, $phone, $services_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit;
?>