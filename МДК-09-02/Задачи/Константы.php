<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //Задача 1
    echo '<h2>Задача 1</h2>';
    const PI = 3.14159;
    $radius =5;
    
    $area = PI * $radius * $radius;
    echo "Площадь круга: $area";

    //Задача 2
    echo '<h2>Задача 2</h2>';
    const  SPEED_OF_LIGHT = 299792458;
    $seconds = 10;

    $distance = SPEED_OF_LIGHT * $seconds;
    echo "Свет проходит $distance метров за 10 секунд";

    //Задача 3
    echo '<h2>Задача 3</h2>';
    const SITE_NAME = "Мой первый сайт";
    const SITE_URL = "localshot";
    const CREATOR = "Шахзод";

    echo "сайт " . SITE_NAME . "доступен по адресу" . SITE_URL . "Автор:" . CREATOR;

    //Задача 4
    echo '<h2>Задача 4</h2>';
    const TAX_RATE = 0.2;
    $price = 1000;

    $price1 = $price * TAX_RATE;
    $price2 = $price + $price1;
     echo "цена без налога: $price, Налог: $price1, Итого: $price2";
    //Задача 5
    echo '<h2>Задача 5</h2>';
        echo "Этот файл находится в папке: " . __DIR__ . "<br>";
        echo "Полный путь к файлу: " . __FILE__ . "<br>";
        echo "Текущая строка: " . __LINE__ . "<br>";
        echo "Версия PHP: " . PHP_VERSION . "<br>";
    ?>
</body>
</html>