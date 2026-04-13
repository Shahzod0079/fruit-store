<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$sql = "SELECT id, title, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
$success_message = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);

$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - ITProger</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Админ-панель ITProger</h1>
        </div>
    </div>

    <div class="nav-menu">
        <div class="container">
            <ul>
                <li><a href="index.php">На сайт</a></li>
                <li><a href="admin.php" class="active">Статьи</a></li>
                <li><a href="post_create.php">Добавить статью</a></li>
                <li><a href="logout.php">Выход (<?= ($_SESSION['username']) ?>)</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?= ($success_message) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-error">
                <?= ($error_message) ?>
            </div>
        <?php endif; ?>
        
        <h2>Все статьи</h2>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= ($row['title']) ?></td>
                        <td class="actions">
                            <a href="post_edit.php?id=<?= $row['id'] ?>" class="btn">Редактировать</a>
                            <a href="post_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger" 
                               onclick="return confirm('Вы уверены, что хотите удалить эту статью?')">
                                Удалить
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Статей нет</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="container">
            <p>© 2026 ITProger Блог. Все права защищены.</p>
        </div>
    </div>
</body>
</html>