<?php
session_start();

// --- Обработка кнопок ---
$message = '';

// Задача 1 и 4: Установка cookie
if (isset($_POST['save_name'])) {
    $username = $_POST['username'];
    if (empty($username)) {
        $username = "Иван Петров"; // Стандартное имя для задачи 1
    }
    setcookie('username', $username, time() + 3600);
    $_SESSION['message'] = "Cookie установлен: $username";
    header('Location: index.php');
    exit;
}

// Задача 8: Удаление cookie
if (isset($_POST['delete_cookie'])) {
    setcookie('username', '', time() - 3600);
    $_SESSION['message'] = "Cookie удален";
    header('Location: index.php');
    exit;
}

// Задача 6: Проверка при входе
if (!isset($_COOKIE['username']) && !isset($_POST['save_name']) && !isset($_GET['action'])) {
    header('Location: index.php?action=enter');
    exit;
}

// Сообщения
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ПР 12 - Cookie</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h1, h2, h3 {
            color: #333;
        }
        .btn {
            margin: 5px;
            padding: 10px 15px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn:hover {
            background: #45a049;
        }
        .btn-red {
            background: #f44336;
        }
        .btn-red:hover {
            background: #da190b;
        }
        .btn-blue {
            background: #2196F3;
        }
        .btn-blue:hover {
            background: #0b7dda;
        }
        input[type="text"] {
            padding: 8px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 5px 0;
        }
        .result {
            background: #f1f1f1;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin: 10px 0;
        }
        .info {
            background: #e7f3fe;
            padding: 15px;
            border: 1px solid #b8daff;
            border-radius: 5px;
            margin: 10px 0;
        }
        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <h1>Практическая работа 12</h1>
    <h2>Работа с Cookie в PHP</h2>
    
    <!-- Сообщение -->
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <!-- Информация о текущем cookie -->
    <div class="info">
        <h3>Текущий cookie 'username':</h3>
        <?php if (isset($_COOKIE['username'])): ?>
            <p><b>Значение:</b> <?php echo htmlspecialchars($_COOKIE['username']); ?></p>
            <p><b>Срок действия:</b> ~1 час</p>
        <?php else: ?>
            <p><b>Cookie не установлен</b></p>
        <?php endif; ?>
    </div>
    
    <hr>
    
    <?php if ($_GET['action'] ?? '' == 'enter'): ?>
        <!-- Страница ввода имени (задачи 4,5,7) -->
        <h3>Введите ваше имя:</h3>
        <form method="post">
            <input type="text" name="username" placeholder="Например: Иван Петров" required>
            <button type="submit" name="save_name" class="btn btn-blue">Сохранить имя</button>
        </form>
        <br>
        <a href="index.php"><button class="btn">← Назад</button></a>
        
    <?php else: ?>
        <!-- Главная страница с кнопками -->
        
        <h3>Задачи 1-3 (обязательные):</h3>
        <form method="post" style="display: inline;">
            <input type="hidden" name="username" value="Петров Иван Иванович"> <!-- ЗАМЕНИТЬ НА СВОЁ ФИО -->
            <button type="submit" name="save_name" class="btn">1. Установить cookie (ФИО)</button>
        </form>
        
        <form method="get" style="display: inline;">
            <button type="submit" name="action" value="show" class="btn">2. Показать значение</button>
        </form>
        
        <form method="get" style="display: inline;">
            <button type="submit" name="action" value="check" class="btn">3. Проверить существование</button>
        </form>
        
        <?php
        if (($_GET['action'] ?? '') == 'show') {
            echo "<div class='result'>";
            if (isset($_COOKIE['username'])) {
                echo "Значение cookie: <b>" . $_COOKIE['username'] . "</b>";
            } else {
                echo "Cookie 'username' не найден";
            }
            echo "</div>";
        }
        if (($_GET['action'] ?? '') == 'check') {
            echo "<div class='result'>";
            if (isset($_COOKIE['username'])) {
                echo "Статус: <b style='color:green;'>Cookie СУЩЕСТВУЕТ</b>";
            } else {
                echo "Статус: <b style='color:red;'>Cookie ОТСУТСТВУЕТ</b>";
            }
            echo "</div>";
        }
        ?>
        
        <hr>
        
        <h3>Задачи 4-5 (оценка 3):</h3>
        <form method="post">
            <input type="text" name="username" placeholder="Введите ваше имя">
            <button type="submit" name="save_name" class="btn btn-blue">4. Установить из формы</button>
        </form>
        <?php if (isset($_COOKIE['username'])): ?>
            <div class="result">
                5. Текущее значение: <b><?php echo $_COOKIE['username']; ?></b>
            </div>
        <?php endif; ?>
        
        <hr>
        
        <h3>Задачи 6-7 (оценка 4):</h3>
        <p>6. Проверка: если нет cookie - автоматически кидает на страницу ввода</p>
        <p>7. Время посещения: <b><?php echo date('d.m.Y H:i:s'); ?></b></p>
        <a href="index.php?action=enter"><button class="btn btn-blue">Ввести имя (как первый раз)</button></a>
        
        <hr>
        
        <h3>Задача 8 (оценка 5):</h3>
        <form method="post" style="display: inline;">
            <button type="submit" name="delete_cookie" class="btn btn-red">Удалить cookie</button>
        </form>
        <a href="index.php?action=enter"><button class="btn btn-blue">Изменить имя</button></a>
        
        <hr>
    <?php endif; ?>

</body>
</html>