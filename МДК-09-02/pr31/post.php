<?php
include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$post_id = (int)$_GET['id'];
$sql = "SELECT id, title, content, created_at FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit;
}

$post = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=($post['title']) ?> - ITProger</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>ITProger Блог</h1>
        </div>
    </div>

    <div class="nav-menu">
        <div class="container">
            <ul>
                <li><a href="index.php">На главную</a></li>
                <li><a href="login.php">Вход для админа</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="single-post">
            <h1><?= ($post['title']) ?></h1>
            <div class="content">
                <?= nl2br(($post['content'])) ?>
            </div>
            
            <div style="margin-top: 30px;">
                <a href="index.php" class="btn">Все статьи</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>© 2026 ITProger Блог. Все права защищены.</p>
        </div>
    </div>
</body>
</html>