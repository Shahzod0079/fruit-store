<?php
session_start();

$order_id = $_SESSION['last_order_id'] ?? null;

if (!$order_id) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Заказ оформлен</title>
     <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<div class="success-card">
    <div class="success-icon">✅</div>
    <h1>Заказ оформлен!</h1>
    
    <div class="order-number">
        Номер заказа: <span>#<?= $order_id ?></span>
    </div>
    
    <div class="pickup-info">
        <h3>📍 Самовывоз</h3>
        <p><strong>Адрес:</strong> ул. Примерная, д. 123</p>
        <p><strong>Время работы:</strong> ежедневно с 9:00 до 21:00</p>
        <p><strong>Оплата:</strong> наличными или картой при получении</p>
        <p style="margin-top: 15px; color: #666; font-size: 14px;">Мы позвоним вам за 30 минут до готовности заказа</p>
    </div>
    
    <p style="color: #666; margin-top: 20px;">
        Спасибо за заказ! Ждём вас.
    </p>
    
    <a href="index.php" class="btn-home">🍎 Вернуться в каталог</a>
</div>

</body>
</div>
</html>