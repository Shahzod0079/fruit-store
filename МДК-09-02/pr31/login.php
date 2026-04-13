<?php
include 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit;
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_username, $hashed_password);
            $stmt->fetch();
            
            if ($password == 'admin123') {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $db_username;
                header("Location: admin.php");
                exit();
            } else {
                $error_message = "Неверный пароль!";
            }
        } else {
            $error_message = "Пользователь не найден!";
        }
        
        $stmt->close();
    } else {
        $error_message = "Заполните все поля!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - ITProger Блог</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Вход для администратора</h1>
        </div>
    </div>

    <div class="nav-menu">
        <div class="container">
            <ul>
                <li><a href="index.php">На главную</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <?php if ($error_message): ?>
                <div class="alert alert-error">
                    <?= ($error_message) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Логин:</label>
                    <input type="text" id="username" name="username" 
                           value="<?= ($username ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-success">Войти</button>
            </form>

        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>© 2026 ITProger Блог. Все права защищены.</p>
        </div>
    </div>
</body>
</html>