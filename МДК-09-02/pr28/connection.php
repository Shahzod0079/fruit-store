<?php
define("SERVER", "localhost");
define("USER", "root");
define("PASSWORD", '');
define("DBNAME", "dbclass");

$db = mysqli_connect(SERVER, USER, PASSWORD, DBNAME);

if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

mysqli_set_charset($db, "utf8");
?>