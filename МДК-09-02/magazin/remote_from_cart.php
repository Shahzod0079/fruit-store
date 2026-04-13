<?php
require_once "login.php";
session_start();

$cart_id= (int)$_GET['id'];

mysqli_query($db_server, "DELETE FROM Cart WHERE id = $cart_id");

header("Location: cart.php");


?>