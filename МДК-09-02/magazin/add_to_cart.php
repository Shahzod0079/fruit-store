<?php
require_once "login.php";
session_start();

$user_id = 1;
$product_id = (int)$_GET['id'];
$quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

$check = mysqli_query($db_server, "SELECT * FROM Cart WHERE product_id = $product_id AND user_id = $user_id");

if (mysqli_num_rows($check) > 0) {
    mysqli_query($db_server, "UPDATE Cart SET quantity = quantity + $quantity WHERE product_id = $product_id AND user_id = $user_id");
} else {
    mysqli_query($db_server, "INSERT INTO Cart (product_id, user_id, quantity) VALUES ($product_id, $user_id, $quantity)");
}

header("Location: catalog.php");
exit;
?>