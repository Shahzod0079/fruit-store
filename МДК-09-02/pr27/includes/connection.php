<?php

define("DB_SERVER", "localhost");
define("DB_USER", "tryhackme");
define("DB_PASS", "try7hack!lol");  
define("DB_NAME", "userlistdb");

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
mysqli_set_charset($db, "utf8");