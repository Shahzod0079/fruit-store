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
    echo '<h2>Задание 1</h2>';

    $name = 'Шахзод';
    $age = '18';

    echo "Меня зовут $name, мне $age лет";

    //Задание 2
    echo '<h2>Задание 2</h2>';
    $a = 15;
    $b = 7;
    $sum = $a  + $b;
    $dif = $a-$b;

    echo "Сумма:" . $sum .", Разность: " . $dif;

    //Задание 3
    echo '<h2>Задание 3</h2>';
    $lenght = 5;
    $widht = 7;

    $area = $lenght * $widht;
    echo "Площадь прямугольника равна: " . $area;

    //Задание 4
    echo '<h2>Задание 4</h2>';
    $x = 5;
    $y = 10;
    $temp = $x;
    $x = $y;
    $y = $temp;

    echo "x = " . $temp = $x,  "у = " . $temp = $y;

    //Задание 5
    echo '<h2>Задание 5</h2>';
    $inches = 12;

    $cm =  $inches - 2.54;

    echo "$inches дюмов =  . $cm сантиметров";

    //Задание 6
    echo '<h2>Задание 6</h2>';
    $celsius = 25;

    $fahrenheit = ($celsius * 9/5) + 32;

    echo "$celsius = $fahrenheit ";
    
    //Задание 7
    echo '<h2>Задание 7</h2>';
    $num1 = 8;
    $num2 = 12;
    $num3 = 5;

   $average = ($num1 +$num2 + $num3)/3;

   echo "Среднее число: $average ";

        //Задание 8
    echo '<h2>Задание 8</h2>';
    $price = 150;
    $quantity = 3;
    $discount = 10;

    $total =  $price + $quantity;
    $discount_amount = $total * $discount/100;

    $final_price = $total - $discount_amount;

    echo "Итого к оплате  . $final_price";

    //Задание 9
    echo '<h2>Задание 9</h2>';
    $distance = 350;
    $speed = 70;
    
    $result = $distance / $speed;
    echo "Время в пути . $result";

    //Задание 10
    echo '<h2>Задание 10</h2>';
    $side = 7;
    
    $P = 4 * $side;
    $S = $side * $side;
    echo "Периметр: $P, Площадь: $S ";

    //Задание 11
    echo '<h2>Задание 11</h2>';
    $total_sandies = 45;
    $children  = 7;

    $candies_per_child = (int) ($total_sandies / $children);
    $leftover = $total_sandies % $children;
    echo "Каждому ребенку $candies_per_child конфет, остаентся $leftover ";

    //Задание 12
    echo '<h2>Задание 12</h2>';
    $rubles = 1000;
    $rate = 0.012;
    
    $result = $rubles * $rate;

    echo "1000 рублей = $result долларов";

    //Задание 13
    echo '<h2>Задание 13</h2>';
    $age_years = 20;

    $result = $age_years * 365;

    echo "20 лет это примерно $result дней ";

    //Задание 14
    echo '<h2>Задание 14</h2>';
    $weight = 70;
    $height = 1.75;

    $index = $weight/($height * $height);
    echo "Ваш ИМТ: $index";

    //Задание 15
    echo '<h2>Задание 15</h2>';
    $number = 200;
    $precent = 15;

    $result = ($number * $precent) / 100;
    echo "15% от 200 $result";
    


?>
</body>
</html>