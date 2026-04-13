<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //Задание 1
    echo '<h2>Задание 1</h2>';
    function privet(){
        echo 'Привет, эту функцию написал Тошматов Шахзод';

    }
    if(function_exists('privet')){
        privet();
    }
    //Задание 2
    echo '<h2>Задание 2</h2>';
    function student($surname, $name, $group){
        echo '<p>Студент '.$surname.' '.$name.' учится в группе '.$group.'</p>';
    }
    if(function_exists('student'))
        student('Тошматов', 'Шахзод', 'ИСВ-23-2');
    //Задание 3
     echo '<h2>Задание 3</h2>';
     function group($students, $name, $start_year, $end_year){
        echo 'Наименование: ' .$name;
        echo '<br>';
        echo 'Год начала обучения: ' .$start_year;
        echo '<br>';
        echo 'Год окончания: ' .$end_year;
        echo '<br>';
        echo 'Студенты:';
        echo '<br>';
        foreach($students as $student){
            echo 'Студент: '.$student;
            echo '<br>';
        }
    }
        $students = ['Тошматов Шахзод', 'Коробкин Владислав', 'Никита Заводчиков', 'Марков Антон'];
        if(function_exists('group')){
        group($students, 'ИСВ-23-2', 2023, 2027);
     }
     //Задание 5
          echo '<h2>Задание 5</h2>';
        function getTable($rows, $cols){
            $table = '<table border="1">';

            for($tr=1; $tr<=$rows; $tr++){
                $table .='<tr>';
                for($td=1; $td<=$cols; $td++){
                    if($tr===1 or $td===1){
                        $table .= '<th style="color:white;background-color:green;">'.$tr*$td.'</th>';
                    }else{
                        $table .='<td>'.$tr*$td.'</td>';
                    }
                }
            }
            $table .='</table>';
            echo $table;
        }
        getTable(5,5);  
      //Задание 6
      echo '<h2>Задание 6</h2>';
      function menu ($menu){
        echo '<ul>';
        foreach($menu as $name => $link){
            echo '<li><a href="' . $link . '">' . $name . '</a></li>';

        }
        echo '</ul>';
      }
      $menu =[
        'Главная' => 'index.php',
        'O нас' => 'index.php',
        'Контакты' => 'index.php',
        'Новости' => 'index.php'
      ];
      menu($menu);
      //Задание 7
      echo '<h2>Задание 7</h2>';
      function random_integer(){
        echo rand(45,234);
      }
        random_integer();
    //Задание 8
    echo '<h2>Задание 8</h2>';
    function random_float(){
        echo mt_rand(45000,234000)/100;
    }
    random_float();
    //Задание 9
    echo '<h2>Задание 9</h2>';
    function op($num1, $num2, $operator){
        if($operator == '+'){
            $result = $num1 + $num2;
        } else if($operator == '-'){
            $result = $num1 = $num2;
        } else if($operator == '*'){
            $result = $num1 * $num2;
        } else if ($operator == '/'){
            $result = $num1 / $num2;
        }
        else echo 'Неверный оператор';
        echo $result;
    }
    op(5,5, '*');
    echo '<br>';
    op(5,5, '+');
    echo '<br>';
    op(5,5, '/');
    echo '<br>';
    op(5,5, '-');

    ?>
</body>
</html>