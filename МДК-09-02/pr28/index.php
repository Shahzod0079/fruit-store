<?php 

include 'connection.php';
include 'DBclass.php';

$db = new DBclass(SERVER, USER, PASSWORD, DBNAME);
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $deleteSql = "DELETE FROM users WHERE id = $id";
    if ($db->query($deleteSql)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if ($db->openConnection()){
    $sql = "SELECT * FROM users";
    $result = $db->query($sql);

    if ($result){
        while($row = $result->fetch_assoc()){
            echo "ID: " . $row["id"] . ", Имя: " . $row["name"] . " <a href='?delete=" . $row['id'] . "'>Удалить</a>" . "<br>";
        }
        $result->free();

    } else{
        echo "Ошибка при выполнении запроса: " . $db->getLastError();
    }
} else{
    echo "Ошибка подключения к базе данных: " . $db->getLastError();
}
?>