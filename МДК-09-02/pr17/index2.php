<?php
// Подключение к MySQL
require_once "login1.php";
$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database)
or die (mysqli_connect_error());
mysqli_set_charset($db_server, "utf8");

// таблицы Students
echo "<h2>Таблица Students</h2>";
$query = "SELECT * FROM Students";
$result = mysqli_query($db_server, $query);
if (!$result) die ("Ошибка: ". mysqli_error($db_server));

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<p>" . $row["StudentID"] . " | " . $row["GroupName"] . " | " . 
             $row["DisciplineID"] . " | " . $row["Grade"] . " | " . $row["ControlType"] . "</p>";
    }
} else {
    echo "<p>Таблица пуста</p>";
}

// таблицы Disciplines
echo "<h2>Таблица Disciplines</h2>";
$query = "SELECT * FROM Disciplines";
$result = mysqli_query($db_server, $query);
if (!$result) die ("Ошибка: ". mysqli_error($db_server));

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<p>" . $row["DisciplineID"] . " | " . $row["Title"] . " | " . $row["Hours"] . "</p>";
    }
} else {
    echo "<p>Таблица пуста</p>";
}

// Отключение
mysqli_close($db_server);

?>