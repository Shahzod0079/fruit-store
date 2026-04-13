<?php
require_once "login.php";
$result = mysqli_query($db_server, "SELECT * FROM Product");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Каталог</title>
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
            <div class="products">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($row['photo']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <div class="price"><?= number_format($row['price'], 0, '', ' ') ?> ₽</div>
                    
                    
                    <div class="counter">
                        <button class="counter-btn" onclick="changeQuantity(<?= $row['id'] ?>, -1)">−</button>
                        <input type="number" id="qty_<?= $row['id'] ?>" class="counter-input" value="1" min="1" readonly>
                        <button class="counter-btn" onclick="changeQuantity(<?= $row['id'] ?>, 1)">+</button>
                    </div>
                    
                    <a href="javascript:void(0)" onclick="addToCart(<?= $row['id'] ?>)" class="btn add-to-cart">В корзину</a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Сайт разработан Тошматовым Ш.Ш., 2020</p>
    </div>

    <script>
        function changeQuantity(id, delta) {
            let input = document.getElementById('qty_' + id);
            let newVal = parseInt(input.value) + delta;
            if (newVal >= 1) {
                input.value = newVal;
            }
        }

        function addToCart(productId) {
            let quantity = document.getElementById('qty_' + productId).value;
            window.location.href = 'add_to_cart.php?id=' + productId + '&quantity=' + quantity;
        }
    </script>
</body>
</html>
<?php mysqli_close($db_server); ?>