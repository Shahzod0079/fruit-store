<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список дел</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Мой список дел на сегодня</h1>
        
        <?php
        // Загружаем XML файл
        $xml = simplexml_load_file('tasks1.xml');
        
        // Проверяем, успешно ли загружен XML
        if ($xml === false) {
            echo "<p>Ошибка загрузки XML файла</p>";
        } else {
            echo '<div class="task-list">';
            
            // Перебираем все задачи в цикле
            foreach ($xml->task as $task) {
                $id = $task['id'];
                $title = $task->title;
                $date = $task->date;
                $time = $task->time;
                $description = $task->description;
                
                // Выводим карточку задачи
                echo '
                <div class="task-card">
                    <div class="task-title">' . $id . '. ' . htmlspecialchars($title) . '</div>
                    <div class="task-datetime">' . htmlspecialchars($date) . ' | ' . htmlspecialchars($time) . '</div>
                    <div class="task-description">' . htmlspecialchars($description) . '</div>
                </div>
                ';
            }
            
            echo '</div>';
        }
        ?>
        
    </div>
</body>
</html>