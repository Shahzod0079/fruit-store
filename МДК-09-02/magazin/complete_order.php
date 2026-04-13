<?php
require_once "login.php";
session_start();

$order_id = (int)$_GET['id'];
mysqli_query($db_server, "UPDATE orders SET completeOrder = 1 WHERE id = $order_id");
header("Location: orders.php");
exit;
?>