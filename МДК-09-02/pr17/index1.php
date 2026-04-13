<?php
// Этап 1 - Подключение к MySQL
require_once "login.php";
$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database)
or die (mysqli_connect_error());
mysqli_set_charset($db_server, "utf8");

//Этапы 2 и 3 – Создание и выполнение запроса
$query = "SELECT * FROM classics";
$result = mysqli_query($db_server, $query);
if (!$result) die ("Сбой при доступе к базе данных: ". mysql_error($db_server));

//Этапы 4 - 5 – Извлечение результатов и вывод их на веб-страницу
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<p>" . $row["author"] . "</p>";
    echo "<p>" . $row["title"] . "</p>";
    echo "<p>" . $row["category"] . "</p>";
    echo "<p>" . $row["year"] . "</p>";
    echo "<p>" . $row["isbn"] . "</p>";
}
} else {
    echo "<p>В настоящее время таблица пуста</p>";
}
//Этап 6 – Отключение
mysqli_close($db_server);

?>