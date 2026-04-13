<?php
// index.php - Исправленная главная страница
require_once 'config.php';

// Обработка регистрации
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = "Заполните все поля!";
    } else {
        $users = loadUsers();
        
        if (isset($users[$username])) {
            $error = "Пользователь с таким логином уже существует!";
        } else {
            $users[$username] = [
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ];
            saveUsers($users);
            $_SESSION['user'] = $username;
            addVisitor($username);
            header('Location: video.php');
            exit();
        }
    }
}

// Обработка авторизации
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    $users = loadUsers();
    
    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        $_SESSION['user'] = $username;
        addVisitor($username);
        header('Location: video.php');
        exit();
    } else {
        $error = "Неверный логин или пароль!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход / Регистрация</title>
    <style>
        /* Стили из предыдущей версии */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 90%;
            max-width: 400px;
            padding: 40px;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .tab-buttons {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .tab-button {
            flex: 1;
            padding: 15px;
            border: none;
            background: none;
            font-size: 16px;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .tab-button.active {
            color: #667eea;
            border-bottom: 2px solid #667eea;
        }
        
        .form {
            display: none;
        }
        
        .form.active {
            display: block;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        
        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        button[type="submit"]:hover {
            transform: translateY(-2px);
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            animation: shake 0.5s;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .visitors-stats {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: center;
        }
        
        .visitors-stats h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .visitors-count {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Добро пожаловать!</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="tab-buttons">
            <button class="tab-button active" onclick="showTab('login')">Вход</button>
            <button class="tab-button" onclick="showTab('register')">Регистрация</button>
        </div>
        
        <div id="login-form" class="form active">
            <form method="POST">
                <div class="input-group">
                    <label>Логин</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label>Пароль</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="login">Войти</button>
            </form>
        </div>
        
        <div id="register-form" class="form">
            <form method="POST">
                <div class="input-group">
                    <label>Логин</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label>Пароль</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="register">Зарегистрироваться</button>
            </form>
        </div>
        
        <div class="visitors-stats">
            <h3>Статистика посещений</h3>
            <?php
            $visitors = loadVisitors();
            if (empty($visitors)) {
                echo '<p style="color: #666;">Никто еще не переходил на видео</p>';
            } else {
                echo '<p class="visitors-count">' . count($visitors) . ' ' . 
                     (count($visitors) == 1 ? 'пользователь' : 
                     (count($visitors) < 5 ? 'пользователя' : 'пользователей')) . 
                     '</p>';
            }
            ?>
        </div>
    </div>
    
    <script>
        function showTab(tab) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const buttons = document.querySelectorAll('.tab-button');
            
            if (tab === 'login') {
                loginForm.classList.add('active');
                registerForm.classList.remove('active');
                buttons[0].classList.add('active');
                buttons[1].classList.remove('active');
            } else {
                registerForm.classList.add('active');
                loginForm.classList.remove('active');
                buttons[1].classList.add('active');
                buttons[0].classList.remove('active');
            }
        }
    </script>
</body>
</html>