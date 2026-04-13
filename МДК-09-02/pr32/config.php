<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'service_requests';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>