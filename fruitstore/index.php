<?php
$host = '127.0.0.1';
$port = '3307'; // Ваш порт
$dbname = 'fruit_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ошибка: " . $e->getMessage());
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY category, name");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>

<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Свежие овощи и фрукты</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h1>🥑 Фрукты & Овощи</h1>

<div class="products-grid">
    <?php foreach($products as $product): ?>
    <div class="product-card">
        <div class="product-image">
            <?php 
            // Показываем эмодзи вместо картинок (потом заменим на реальные фото)
            if($product['category'] == 'fruit') {
                echo '🍎';
            } else {
                echo '🥕';
            }
            ?>
        </div>
        <span class="category-badge <?= $product['category'] ?>">
            <?= $product['category'] == 'fruit' ? 'Фрукт' : 'Овощ' ?>
        </span>
        <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
        <div class="product-price">
            <?= number_format($product['price'], 2, '.', ' ') ?> <small>₽/кг</small>
        </div>
        <form method="post" action="cart.php">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn-buy">🛒 В корзину</button>
        </form>
    </div>
    <?php endforeach; ?>
</div>

<a href="cart.php" class="cart-link">🛒 Перейти в корзину</a>
</div>
</body>
</html>