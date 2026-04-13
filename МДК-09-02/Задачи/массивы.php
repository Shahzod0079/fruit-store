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
    $friends = ["Шахзод", "Шамил", "Шухрат", "Иван", "Влад"];
    echo "Первый друг: " . $friends [0] . "<br>";
    echo "Второй друг: " . $friends [2] . "<br>";
    echo "Все друзья: " . implode(", ", $friends);

    //Задача 2
    echo '<h2>Задача 2</h2>';

    $movie = [
        "title" => "Начало",
        "year" => "2010",
        "director" => "Гари Потер",
        "rating" => "8"

    ];
    echo "Название: " . $movie["title" ] . "<br>"; 
    echo "Год: " . $movie["year"] . "<br>";
    echo "Режисер" . $movie["director"] . "<br>";
    echo "Рейтинг" . $movie["rating"];

    
    //Задача 3
    echo '<h2>Задача 3</h2>';
    $numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];

    $sum = array_sum($numbers);
    $count = count($numbers);
    $average = $sum/$count;

    echo "Сумма: $sum <br>";
    echo "Количество: $count <br>";
    echo "Среднее арифметическое: $average <br>";

    //Задача 4
    echo '<h2>Задача 4</h2>';
    $rainbow = ["Красный", "Оранжевый", "Желтый", "Зеленый", "Голубой", "Синий", "Фиолетовый"];

    echo "Третий цвет: " . $rainbow[2] . "<br>";
    echo "Последний цвет: " . $rainbow[count($rainbow) - 1] . "<br>";
    echo "Количество цветов: " . count($rainbow);


    //Задача 5
    echo '<h2>Задача 5</h2>';
        $university = [
            [
                "name" => "Анна",
                "age" => 20,
                "grades" => [5, 4, 5]
            ],
            [
                "name" => "Иван",
                "age" => 21,
                "grades" => [4, 3, 5]
            ]
        ];

        echo "Имя: " . $university[1]["name"] . "<br>";
        echo "Возраст: " . $university[1]["age"] . "<br>";
        echo "Оценки: " . implode(", ", $university[1]["grades"]) . "<br>";
        echo "Вторая оценка: " . $university[1]["grades"][1];

    //Задача 6
    echo '<h2>Задача 6</h2>';
    $clothes = ["Футболка", "Джинсы", " кеды", "куртка", "шапка"];
    echo "Второй элемент: " . $clothes[1] . "<br>";
    echo "Последний элемент: " . $clothes[count($clothes) - 1] . "<br>" ;
    array_push($clothes, "Костюм");
    print_r($clothes);
    
    //Задача 7
    echo '<h2>Задача 7</h2>';
    $groceries = [
        "хлеб" => "80",
        "молоко" => "30",
        "яйцо" => "50",
        "сыр" => "60"
    ];
        echo "Цена молока: " . $groceries["молоко"] . " рублей<br>";

        $total = $groceries["хлеб"] + $groceries["молоко"] + $groceries["яйцо"] + $groceries["сыр"];
        echo "Общая стоимость: $total рублей<br>";

        $count = count($groceries);
        echo "Количество продуктов: $count<br>";
    

    ?>
</body>
</html>