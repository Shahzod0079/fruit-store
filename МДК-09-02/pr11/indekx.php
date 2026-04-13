<!DOCTYPE html>
<html>
<head>
    <title>ПР 11 - Работа с файлами</title>
    <meta charset="utf-8">
    <style>
        body{
            font-family: Arial;
            padding: 20px;

        }
        .btn{
            margin: 5px;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn:hover{
            background: #45a049;
        }
        .reset{
            background: #f44336;
        }
        .reset:hover{
            background: #f44336;
        }
        .resilt{
            background: #f1f1f1;
            padding: 15px;
            margin-top: 30px;
            
        }

    </style>
</head>
<body>

<h1>Практическая работа 11</h1>
<h2>Функции по работе с файлами и каталогами</h2>

<form method="post">
    <!--  1-7 -->
    <button type="submit" name="task1" class="btn">Задание 2</button>
    <button type="submit" name="task2" class="btn">Задание 2</button>
    <button type="submit" name="task3" class="btn">Задание 3</button>
    <button type="submit" name="task4" class="btn">Задание 4</button>
    <button type="submit" name="task5" class="btn">Задание 5</button>
    <button type="submit" name="task6" class="btn">Задание 6</button>
    <button type="submit" name="task7" class="btn">Задание 7</button>
    
    <br><br>
    
    <!--  8-11 -->
    <button type="submit" name="task8" class="btn">Задание 8</button>
    <button type="submit" name="task9" class="btn">Задание 9</button>
    <button type="submit" name="task10" class="btn">Задание 10</button>
    <button type="submit" name="task11" class="btn">Задание 11</button>
    
    <br><br>

    <button type="submit" name="reset" class="btn reset">Сбросить всё</button>
</form>

<div class="result">
    <h3>Результат:</h3>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $students = ['Тошматов', 'Иванов', 'Сидоров', 'Марков', 'Коробкин'];
        
        // Задание 1
        if (isset($_POST['task1'])) {
            $file = 'march.txt';
            $content = 'Весна пришла!';
            if (file_put_contents($file, $content)) {
                echo "Задача 1: Файл '$file' создан. Содержимое: '$content'<br>";
            } else {
                echo "Задача 1: Ошибка<br>";
            }
        }
        
        // Задание 2
        if (isset($_POST['task2'])) {
            $old = 'march.txt';
            $new = '8.txt';
            if (file_exists($old)) {
                if (rename($old, $new)) {
                    echo "Задача 2: Файл '$old' переименован в '$new'<br>";
                } else {
                    echo "Задача 2: Ошибка<br>";
                }
            } else {
                echo "Задача 2: Файл '$old' не найден<br>";
            }
        }
        
        // Задание 3
        if (isset($_POST['task3'])) {
            $folder = 'old';
            $file = '8.txt';
            $dest = $folder . '/' . $file;
            
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            
            if (file_exists($file)) {
                if (rename($file, $dest)) {
                    echo "Задача 3: Папка '$folder' создана. Файл '$file' перемещен<br>";
                } else {
                    echo "Задача 3: Ошибка<br>";
                }
            } else {
                echo "Задача 3: Файл '$file' не найден<br>";
            }
        }
        
        // Задание 4
        if (isset($_POST['task4'])) {
            $source = 'old/8.txt';
            $dest = 'old/double.txt';
            
            if (file_exists($source)) {
                if (copy($source, $dest)) {
                    echo "Задача 4: Создана копия 'double.txt'<br>";
                } else {
                    echo "Задача 4: Ошибка<br>";
                }
            } else {
                echo "Задача 4: Файл '$source' не найден<br>";
            }
        }
        
        // Задание 5
        if (isset($_POST['task5'])) {
            $file = 'old/double.txt';
            
            if (file_exists($file)) {
                $bytes = filesize($file);
                echo "Задача 5: Размер файла:<br>";
                echo "- в байтах: $bytes байт<br>";
                echo "- в килобайтах: " . round($bytes / 1024, 2) . " КБ<br>";
                echo "- в мегабайтах: " . round($bytes / (1024 * 1024), 5) . " МБ<br>";
                echo "- в гигабайтах: " . round($bytes / (1024 * 1024 * 1024), 10) . " ГБ<br>";
            } else {
                echo "Задача 5: Файл не найден<br>";
            }
        }
        
        // Задание 6
        if (isset($_POST['task6'])) {
            $file = 'old/double.txt';
            
            if (file_exists($file)) {
                if (unlink($file)) {
                    echo "Задача 6: Файл 'double.txt' удален<br>";
                } else {
                    echo "Задача 6: Ошибка<br>";
                }
            } else {
                echo "Задача 6: Файл не найден<br>";
            }
        }
        
        // Задание 7
        if (isset($_POST['task7'])) {
            $file1 = 'old/double.txt';
            $file2 = 'old/8.txt';
            
            echo "Задача 7: Проверка файлов:<br>";
            echo "double.txt: " . (file_exists($file1) ? "СУЩЕСТВУЕТ" : "НЕ СУЩЕСТВУЕТ") . "<br>";
            echo "8.txt: " . (file_exists($file2) ? "СУЩЕСТВУЕТ" : "НЕ СУЩЕСТВУЕТ") . "<br>";
        }
        
        // Задание 8
        if (isset($_POST['task8'])) {
            $folder = 'demo_1';
            
            if (!is_dir($folder)) {
                if (mkdir($folder)) {
                    echo "Задача 8: Папка 'demo_1' создана<br>";
                } else {
                    echo "Задача 8: Ошибка<br>";
                }
            } else {
                echo "Задача 8: Папка уже существует<br>";
            }
        }
        
        // Задание 9
        if (isset($_POST['task9'])) {
            $old = 'demo_1';
            $new = 'test_2';
            
            if (is_dir($old)) {
                if (rename($old, $new)) {
                    echo "Задача 9: Папка переименована в 'test_2'<br>";
                } else {
                    echo "Задача 9: Ошибка<br>";
                }
            } else {
                echo "Задача 9: Папка 'demo_1' не найдена<br>";
            }
        }
        
        // Задание 10
        if (isset($_POST['task10'])) {
            $folder = 'test_2';
            
            if (is_dir($folder)) {
                $files = scandir($folder);
                $files = array_diff($files, ['.', '..']);
                
                if (empty($files)) {
                    if (rmdir($folder)) {
                        echo "Задача 10: Папка 'test_2' удалена<br>";
                    } else {
                        echo "Задача 10: Ошибка удаления<br>";
                    }
                } else {
                    echo "Задача 10: Папка не пуста. Удаление невозможно<br>";
                }
            } else {
                echo "Задача 10: Папка не найдена<br>";
            }
        }
        
        // Задание 11
        if (isset($_POST['task11'])) {
            $baseDir = 'test_2';
            
            if (!is_dir($baseDir)) {
                mkdir($baseDir);
                echo "Создана папка 'test_2'<br>";
            }
            
            echo "Задача 11: Создание папок студентов:<br>";
            foreach ($students as $student) {
                $path = $baseDir . '/' . $student;
                if (!is_dir($path)) {
                    if (mkdir($path)) {
                        echo "- Папка '$student' создана<br>";
                    } else {
                        echo "- Ошибка создания '$student'<br>";
                    }
                } else {
                    echo "- Папка '$student' уже существует<br>";
                }
            }
        }
        
        // Сброс
        if (isset($_POST['reset'])) {
            // Удаляем файлы
            if (file_exists('march.txt')) unlink('march.txt');
            if (file_exists('8.txt')) unlink('8.txt');
            
            // Удаляем файлы в папке old
            if (is_dir('old')) {
                if (file_exists('old/8.txt')) unlink('old/8.txt');
                if (file_exists('old/double.txt')) unlink('old/double.txt');
                rmdir('old');
            }
            
            // Удаляем папки студентов
            if (is_dir('test_2')) {
                foreach ($students as $student) {
                    $path = 'test_2/' . $student;
                    if (is_dir($path)) rmdir($path);
                }
                rmdir('test_2');
            }
            
            if (is_dir('demo_1')) rmdir('demo_1');
            
            echo "Сброс выполнен. Все файлы и папки удалены<br>";
        }
    }
    ?>
</div>

</body>
</html>