<?php

include 'connection.php';
include 'DBclass.php';

$db = new  DBclass(SERVER, USER, PASSWORD, DBNAME);

if(isset($_POST['insert_user'])){
    if ($db->openConnection()){

        $name = $_POST['name'] ?? 'default_name';

        $escapedName = $db->escapeString($name);

        $sql = "INSERT INTO users (name) VALUES ('" . $escapedName  . "')";

        $result = $db->query($sql);

        if($result ){
            $lastInsertId = $db->getLastInsertId();
             echo "Запись успешно добавлена. ID новой записи: " . ($lastInsertId !== null ? $lastInsertId : "Не удалось получить ID");

        }else {
            echo " Ошибка при добавлении записи: " . $db->getLastError();
        }
    }else {
        echo "Ошибка при подключение к базе данных: " . $db->getLastError();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Добавить записи</h3>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Введите имя">
        <input type="submit" name="insert_user" placeholder="Добавить">

    </form>
</body>
</html>