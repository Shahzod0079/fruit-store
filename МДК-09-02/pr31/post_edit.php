<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$post_id = (int)$_GET['id'];
$error_message = '';

$stmt = $conn->prepare("SELECT id, title, content FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin.php");
    exit;
}

$post = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    if (empty($title) || empty($content)) {
        $error_message = "Заполните все поля!";
    } else {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $post_id);
        
        if ($stmt->execute()) {
        } else {
            $error_message = "Ошибка при обновлении: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать статью - ITProger</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Редактировать статью</h1>
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
                           value="<?= ($post['title']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="content">Содержимое статьи:</label>
                    <textarea id="content" name="content" required><?= ($post['content']) ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-success">Сохранить изменения</button>
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