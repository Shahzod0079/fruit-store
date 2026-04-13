<?php
    //Задание 16
    echo '<h2>Задание 16</h2>';
$number = 0;

if($number > 0){
    echo "Число положительное";
} elseif($number < 0){
    echo "Число отрицательное";
}else{
    echo "ЧИсло равно нулю";
}

    //Задание 17
    echo '<h2>Задание 17</h2>';
    $score = 100;

    if($score < 0 || $score > 100){
        echo "Некоректный ввод";
    }elseif($score >= 90){
        echo "Хорошо";
    }elseif($score >= 75){
        echo "Хорошо";
    }elseif($score >= 50){
        echo "Удовлетворительно";
    }else{
        echo "Неудовлетворительо";
    }

    //Задание 18
    echo '<h2>Задание 18</h2>';
    $age = 23;

    if($age < 0 ){
        echo "Некоректный возраст";
    }elseif($age <= 2){
        echo "Младенец";
    }elseif($age <= 12){
        echo "Ребенок";
    }elseif($age <= 17){
        echo "Подросток";
    }elseif($age <= 64){
        echo "Взрослый";
    }
    else{
        echo "Некорректный возраст";
    }
    //Задание 19
    echo '<h2>Задание 1</h2>';
    $age1 = 150;
    if($age1 > 150){
        echo "Некорректный возраст";
    }
    elseif($age1 >= 18){
        echo "Совершеннелетняя";
    }elseif($age1 < 18){
        echo "Несовершеннелетняя";
    }
?>