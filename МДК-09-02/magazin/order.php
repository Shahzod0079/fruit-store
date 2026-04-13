<?php
require_once "login.php";
session_start();

$user_id = 1;

$query = "SELECT Cart.quantity, Product.* 
          FROM Cart 
          JOIN Product ON Cart.product_id = Product.id 
          WHERE Cart.user_id = $user_id";
$result = mysqli_query($db_server, $query);

$total = 0;
$products_list = "";
while ($row = mysqli_fetch_assoc($result)) {
    $sum = $row['price'] * $row['quantity'];
    $total += $sum;
    $products_list .= $row['name'] . " (x" . $row['quantity'] . "), ";
}
$products_list = rtrim($products_list, ", ");

mysqli_query($db_server, "INSERT INTO orders (user_id, total, completeOrder) VALUES ($user_id, $total, 0)");
$order_id = mysqli_insert_id($db_server);
mysqli_query($db_server, "DELETE FROM Cart WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Заказы</title>
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
            <h2>Заказ оформлен</h2>
            <div class="order">
                <div class="order-header">Номер заказа: №<?= $order_id ?></div>
                <div class="order-content">
                    <p><strong>Товары:</strong> <?= htmlspecialchars($products_list) ?></p>
                    <p><strong>Сумма:</strong> <?= number_format($total, 0, '', ' ') ?> ₽</p>
                </div>
            </div>
            <a href="catalog.php" class="btn">Вернуться в каталог</a>
        </div>
    </div>

    <div class="footer">
        <p>Сайт разработан Тошматовым Ш.Ш., 2020</p>
    </div>
</body>
</html>
<?php mysqli_close($db_server); ?>