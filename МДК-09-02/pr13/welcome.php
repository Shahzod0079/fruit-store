<?php
session_start();

// Обработка очистки сессии
if (isset($_POST['clear_session'])) {
    session_unset();     // Очищаем переменные сессии
    session_destroy();   // Уничтожаем сессию
    header('Location: welcome.php');
    exit;
}

// Проверяем, есть ли имя в сессии
$username = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>ПР 13 - Приветствие</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial; max-width: 600px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .btn { margin: 5px; padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 5px; }
        .btn:hover { background: #45a049; }
        .btn-red { background: #f44336; }
        .btn-red:hover { background: #da190b; }
        .info { background: #d4edda; color: #155724; padding: 20px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0; }
        .warning { background: #fff3cd; color: #856404; padding: 15px; border: 1px solid #ffeeba; border-radius: 5px; }
    </style>
</head>
<body>

    <h1>Страница приветствия</h1>
    
    <?php if ($username): ?>
        <div class="info">
            <h2>👋 Привет, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>Рады тебя видеть на нашем сайте.</p>
        </div>
        
        <form method="post">
            <button type="submit" name="clear_session" class="btn btn-red">4-5. Очистить сессию</button>
        </form>
        
    <?php else: ?>
        <div class="warning">
            <h3>Сессия пуста</h3>
            <p>Имя не сохранено в сессии.</p>
            <a href="index1.php"><button class="btn">Ввести имя</button></a>
        </div>
    <?php endif; ?>
    
    <p><a href="index1.php">← Назад к вводу имени</a></p>
    <p><a href="index2.php">→ К авторизации</a></p>

</body>
</html>