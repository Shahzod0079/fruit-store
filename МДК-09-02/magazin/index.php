<?php require_once "login.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
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
            <div class="welcome">
                <h2>Добро пожаловать в PhoneStore</h2>
                <p>Лучшие смартфоны по лучшим ценам!</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Сайт разработан Тошматовым Ш.Ш., 2026</p>
    </div>
</body>
</html>
<?php mysqli_close($db_server); ?>