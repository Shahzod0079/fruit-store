<?php
include 'config.php';
$sql = "SELECT id, title, content, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITProger - Главная</title>
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
                <li><a href="index.php">Главная</a></li>
                <li><a href="login.php">Вход для админа</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <h2>Последние статьи</h2>
        
        <div class="posts-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post-card">
                    <h2><?= ($row['title']) ?></h2>
                    
                    <?php
                    $content_preview = mb_substr($row['content'], 0, 150);
                    if (mb_strlen($row['content']) > 150) {
                        $content_preview .= '...';
                    }
                    ?>
                    <p class="preview"><?= nl2br(($content_preview)) ?></p>
                    <a href="post.php?id=<?= $row['id'] ?>" class="btn">Читать полностью</a>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Статей пока нет.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>© 2026 ITProger Блог. Все права защищены.</p>
        </div>
    </div>
</body>
</html>