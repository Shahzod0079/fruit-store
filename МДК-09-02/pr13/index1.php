<?php
session_start();

$message = '';

// Обработка формы входа
if (isset($_POST['save_name'])) {
    $username = trim($_POST['username']);
    if (!empty($username)) {
        $_SESSION['username'] = $username;
        header('Location: welcome.php');
        exit;
    } else {
        $message = "Введите имя!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ПР 13 - Сессии (Блок 1)</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial; max-width: 600px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
        h1, h2 { color: #333; }
        .btn { margin: 5px; padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 5px; }
        .btn:hover { background: #45a049; }
        input { padding: 8px; width: 250px; border: 1px solid #ccc; border-radius: 4px; }
        .message { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { background: #f1f1f1; padding: 15px; border: 1px solid #ccc; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>

    <h1>Практическая работа 13</h1>
    <h2>Блок 1: Работа с сессией (ввод имени)</h2>
    
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <div class="info">
        <h3>Введите ваше имя:</h3>
        <form method="post">
            <input type="text" name="username" placeholder="Например: Иван" required>
            <button type="submit" name="save_name" class="btn">Сохранить</button>
        </form>
    </div>
    
    <p><a href="index2.php">→ Перейти к Блоку 2 (авторизация)</a></p>
    <p><a href="welcome.php">→ Перейти на страницу приветствия</a></p>

</body>
</html>