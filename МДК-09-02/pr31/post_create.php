<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    if (empty($title) || empty($content)) {
        $error_message = "Заполните все поля!";
    } else {
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        
        if ($stmt->execute()) {
        } else {
            $error_message = "Ошибка при сохранении: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить статью - ITProger</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Добавить статью</h1>
        </div>
    </div>

    <div class="nav-menu">
        <div class="container">
            <ul>
                <li><a href="admin.php">Назад в админку</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <?php if ($error_message): ?>
                <div class="alert alert-error"><?= ($error_message) ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Заголовок статьи:</label>
                    <input type="text" id="title" name="title" 
                           value="<?= ($_POST['title'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Содержимое статьи:</label>
                    <textarea id="content" name="content" required><?= ($_POST['content'] ?? '') ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-success">Опубликовать</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>© 2026 ITProger Блог.</p>
        </div>
    </div>
</body>
</html>