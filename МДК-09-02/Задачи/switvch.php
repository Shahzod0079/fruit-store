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

$day = 4;

switch($day){
    case 1:
        echo "Понедельник";
    break;
    case 2:
        echo "Вторник";
    break;
    case 3:
        echo "Среда";
     break;
    case 4:
        echo "Четверг";
     break;
    case 5:
        echo "Пятница";
     break;
    case 6:
        echo "Суббота";
     break;
    case 7:
        echo "Всокресенье";
     break;
    default:
        echo "Неизвестный день";
}
//Задача 2
echo '<h2> Задание 2</h2>';
$month = 7;

switch($month){
    case 12: case 1: case 2:
        echo "Зима";
        break;
    case 3: case 4: case 5:
        echo "Весна";
    break;
    case 6: case 7: case 8:
        echo "Лето";
    break;
    case 9: case 10: case 10:
        echo "Осень";
    break;
    default:
        echo "Неверный месяц";
}
//Задача 3
echo '<h2> Задание 3</h2>';
$a = 10;
$b =  4;

$operation = '/';

switch($operation){
    case '+':
        $result = $a + $b;
        echo "$a +$b = $result";
    break;
    case '-':
        $result = $a - $b;
        echo "$a - $b = $result";
    break;
    case '*':
        $result = $a * $b;
        echo "$a * $b = $result";
    break;
    case '/':
        if($b == 0){
            echo "Ошибка: деление на наоль";
        } else {
                $result = $a / $b;
                echo "$a / $b = $result";
        }
    break;
    default;
        echo "Неверное число";
}
//Задача 4
echo '<h2> Задание 4</h2>';
$grade = 3;
switch($grade){
    case 5:
        echo "Отлично";
    break;
    case 4:
        echo "Хорошо";
    break;
    case 3:
        echo "Удовлетвеорительно";
    break;
    case 2:
        echo "Неудовлетворительно";
    break;
    default;
        echo "Неизвестная оценка";
}
//Задача 5
echo '<h2> Задание 5</h2>';
$drink = 'water';

switch($drink){
    case 'cofee':
        echo "Горячий напиток";
    break;
    case 'tea':
        echo "Горячий напиток";
    break;
    case 'juise':
        echo "Холодный напиток";
    break;
    case 'water':
        echo "Холодный напиток";
    break;
    default:
        echo "Неизвестный напиток";
}

    

?>
</body>
</html>