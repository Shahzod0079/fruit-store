<?php
require_once "login.php";
session_start();

$user_id = 1;

$query = "SELECT Cart.id as cart_id, Cart.quantity, Product.* 
          FROM Cart 
          JOIN Product ON Cart.product_id = Product.id 
          WHERE Cart.user_id = $user_id";
$result = mysqli_query($db_server, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
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
            <h2>Корзина</h2>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="cart-table">
                    <tr>
                        <th>Товары</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                        <th></th>
                    </tr>
                    <?php 
                    $total = 0;
                    while ($row = mysqli_fetch_assoc($result)):
                        $sum = $row['price'] * $row['quantity'];
                        $total += $sum;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= number_format($row['price'], 0, '', ' ') ?> ₽</td>
                        <td><?= $row['quantity'] ?></td>
                        <td><?= number_format($sum, 0, '', ' ') ?> ₽</td>
                        <td><a href="remove_from_cart.php?id=<?= $row['cart_id'] ?>" style="color:#f97316; text-decoration:none;" onclick="return confirm('Удалить?')">❌</a></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                <div class="total">Итого: <?= number_format($total, 0, '', ' ') ?> ₽</div>
                <form method="post" action="order.php">
                    <button type="submit" name="checkout" class="btn">Заказать</button>
                </form>
            <?php else: ?>
                <p>Корзина пуста</p>
                <a href="catalog.php" class="btn">Перейти в каталог</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <p>Сайт разработан Тошматовым Ш.Ш., 2020</p>
    </div>
</body>
</html>
<?php mysqli_close($db_server); ?>