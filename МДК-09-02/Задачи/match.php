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
    echo '<h2> Задание 1</h2>';
    $day = 1;
    $dayName = 'Вторник';

    $dayName = match ($day) {
        1 => "Понедельник" ,
        2 => "Вторник",
        3 => "Среда" ,
        4 => "Четверг",
        5 => 'Пятница' ,
        6 => "Суббота",
        7 => "Всокресенье",
        default => "Неверный день"
    };
    echo $dayName;

    //Задача 2 
    echo '<h2> Задание 2</h2>';
    $month = 1;
    
    $season = match($month){
        12, 1, 2 => "Зима",
        3, 4, 5 => "Весна",
        6, 7, 8 => "Лето",
        9, 10, 11 => "Осень",
        default => "Неверный месяц"
    };
        echo $season;

    //Задача 3 
    echo '<h2> Задание 3</h2>';
    $grade = 1;
    $grade1 = "Удовлтворительно";

    $grade1 = match ($grade) {
        2 => "Неудовтелворительно", 
        3 => "Удовлетворительно", 
        4 => "Хорошо", 
        5 => "Отлично",
        default => "Неверная оценка"
    };
    echo $grade1;

    //Задача 4 
    echo '<h2> Задание 4</h2>';
    $drink = "water";
    $type_drink = "Горячая напитка";
    $type_drink = match ($drink) {
        'coffee', 'tea' => "Горячая напитка",
        'juice', 'water' => "Холодная напитка", 
        default => "Незивестная напитка"
    };
    echo $type_drink;

    //Задача 5 
    echo '<h2> Задание 5</h2>';
    $a = 10;
    $b = 5;
    $operation = '/';

    $result = $a +$b;

    $result = match ($operation) {
        '+' => $result,
        '-' => $result,
        '*'=> $result,
        '/' => $b != 0 ? $a /$b: "Ошибка: деление на ноль",
            default => "Неверная операция"
            }; 
            echo "Результат: $result";

    ?>
</body>
</html>