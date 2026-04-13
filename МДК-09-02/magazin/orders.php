<?php
require_once "login.php";
session_start();

$user_id = 1;
$result = mysqli_query($db_server, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Мои заказы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>Интернет-магазин PhoneStore</h1>
    </div>
    <div class="nav">
        <a href="index.php">Главная</a>
        <a href="catalog.php">Каталог</a>
        <a href="orders.php">Заказы</a>
        <a href="cart.php">Корзина</a>
    </div>

    <div class="content">
        <div class="container">
            <h2>Мои заказы</h2>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="order">
                    <div class="order-header">Номер заказа: №<?= $row['id'] ?></div>
                    <div class="order-content">
                        <p><strong>Сумма:</strong> <?= number_format($row['total'], 0, '', ' ') ?> ₽</p>
                        <p><strong>Статус:</strong> <?= $row['completeOrder'] ? '✅ Завершен' : '⏳ В обработке' ?></p>
                        <?php if (!$row['completeOrder']): ?>
                            <a href="complete_order.php?id=<?= $row['id'] ?>" class="btn" onclick="return confirm('Завершить заказ?')">Завершить заказ</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>У вас пока нет заказов</p>
                <a href="catalog.php" class="btn">Перейти в каталог</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <p>Сайт разработан Тошматовым Ш.Ш., 2026</p>
    </div>
</body>
</html>
<?php mysqli_close($db_server); ?>