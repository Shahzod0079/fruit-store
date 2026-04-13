<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Получаем список заявок с названиями услуг
$sql = "SELECT r.*, s.title as service_title 
        FROM requests r 
        JOIN services s ON r.services_id = s.id 
        ORDER BY r.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - Заявки</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Админ-панель</h1>
            <p>Управление заявками</p>
        </div>
    </div>

    <div class="nav-menu">
        <div class="container">
            <ul>
                <li><a href="index.php">На сайт</a></li>
                <li><a href="admin.php" class="active">Заявки</a></li>
                <li><a href="logout.php">Выход (<?= $_SESSION['username'] ?>)</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <h2>Список заявок</h2>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Услуга</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['fio']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['service_title']) ?></td>
                        <td>
                            <form method="POST" action="update_status.php" style="margin:0">
                                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="Новая" <?= $row['status'] == 'Новая' ? 'selected' : '' ?>>Новая</option>
                                    <option value="В работе" <?= $row['status'] == 'В работе' ? 'selected' : '' ?>>В работе</option>
                                    <option value="Выполнена" <?= $row['status'] == 'Выполнена' ? 'selected' : '' ?>>Выполнена</option>
                                    <option value="Отклонена" <?= $row['status'] == 'Отклонена' ? 'selected' : '' ?>>Отклонена</option>
                                </select>
                            </form>
                        </td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <form method="POST" action="update_status.php" style="margin:0">
                                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="status" value="Отклонена">
                                <button type="submit" class="btn-small btn-danger">Отклонить</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>© 2026 Сервисный центр. Все права защищены.</p>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>