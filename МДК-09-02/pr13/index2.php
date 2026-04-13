<?php
session_start();

$login_error = '';
$password_error = '';

// Заданные логин и пароль
$valid_login = 'admin';
$valid_password = 'admin';

// Обработка формы авторизации
if (isset($_POST['login'])) {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $login_valid = ($login == $valid_login);
    $password_valid = ($password == $valid_password);
    
    if ($login_valid && $password_valid) {
        // Всё верно - сохраняем в сессию и перенаправляем
        $_SESSION['username'] = $login;
        $_SESSION['auth'] = true;
        header('Location: welcome.php');
        exit;
    } else {
        if (!$login_valid) {
            $login_error = "Неверный логин";
        }
        if (!$password_valid) {
            $password_error = "Неверный пароль";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ПР 13 - Авторизация</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial; max-width: 500px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
        h1, h2 { color: #333; }
        .btn { margin: 10px 0; padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 5px; width: 100%; }
        .btn:hover { background: #45a049; }
        input { padding: 8px; width: 100%; border: 1px solid #ccc; border-radius: 4px; margin: 5px 0 10px 0; box-sizing: border-box; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 5px 0; border: 1px solid #f5c6cb; }
        .info { background: #f1f1f1; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        label { font-weight: bold; }
    </style>
</head>
<body>

    <h1>Практическая работа 13</h1>
    <h2>Блок 2: Авторизация</h2>
    
    <div class="info">
        <form method="post">
            <label>Логин:</label>
            <input type="text" name="login" placeholder="admin" required>
            <?php if ($login_error): ?>
                <div class="error"><?php echo $login_error; ?></div>
            <?php endif; ?>
            
            <label>Пароль:</label>
            <input type="password" name="password" placeholder="admin" required>
            <?php if ($password_error): ?>
                <div class="error"><?php echo $password_error; ?></div>
            <?php endif; ?>
            
            <button type="submit" class="btn">Войти</button>
        </form>
        
        <p><small>Подсказка: логин и пароль - admin</small></p>
    </div>
    
    <p><a href="index1.php">← К вводу имени</a></p>
    <p><a href="welcome.php">→ На страницу приветствия</a></p>

</body>
</html>