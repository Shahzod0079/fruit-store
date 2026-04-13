<?php

include 'connection.php';
include 'DBclass.php';

$db = new  DBclass(SERVER, USER, PASSWORD, DBNAME);

if(isset($_POST['delete'])){
    if ($db->openConnection()){
        $idToDelete = $_GET['delete'] ?? null;

        if($idToDelete  === null){
            echo "Не указан ID записи для удлаения";
            exit;
        }

        $escapedId = $db->escapeString($idToDelete);

        $sql = "DELETE FROM users WHERE id='" . $escapId . "'";
        $result = $db->query($sql);
        
        if ($result){
            $affected_rows = $db_>getAffectRows();
            if($affected_rows > 0){
                echo "<script>
                alert('Запись с ID" . $escapedId . "Успешно удалена');
                window,location.href = 'inedex.php';
                </script>";
                exit;
            }  else{
                echo "Запись с ID " . $escapedId . "не найдена или уже была удалена";

            }
        } else{
            echo "Ошибка при удалении записи: " . $db->getLastError();
        }
    } else {
        echo "Ошибка подключения к базе данных:" . $db_>getLastError();
    }
}


?>