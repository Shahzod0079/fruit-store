<?php
session_start();

// Подключение к БД
$host = '127.0.0.1';
$port = '3307';
$dbname = 'fruit_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ошибка: " . $e->getMessage());
}

// Инициализация корзины
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Добавление товара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $product_id = (int)$_POST['product_id'];
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }
    }
    header('Location: cart.php');
    exit;
}

// Удаление товара
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header('Location: cart.php');
    exit;
}

// Очистка корзины
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header('Location: cart.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Корзина</title>
     <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>🛒 Корзина</h1>

<?php if (empty($_SESSION['cart'])): ?>
    <div class="empty-cart">
        <p style="font-size: 48px; margin-bottom: 20px;">🛒</p>
        <h2 style="margin-bottom: 10px;">Корзина пуста</h2>
        <p style="color: #666; margin-bottom: 30px;">Добавьте свежих фруктов и овощей</p>
        <a href="index.php" class="btn-continue" style="display: inline-block; padding: 15px 40px;">В каталог</a>
    </div>
<?php else: ?>
    <div class="cart-header">
        <a href="index.php" style="color: #2e7d32; text-decoration: none;">← Назад</a>
        <a href="?clear=1" class="btn-clear" onclick="return confirm('Очистить корзину?')">Очистить всё</a>
    </div>

    <?php 
    $total = 0;
    foreach ($_SESSION['cart'] as $id => $item): 
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
    <div class="cart-item">
        <div class="cart-item-info">
            <h3><?= htmlspecialchars($item['name']) ?></h3>
            <div class="cart-item-price"><?= number_format($item['price'], 2, '.', ' ') ?> ₽/кг</div>
        </div>
        <div class="cart-item-controls">
            <span class="cart-item-quantity"><?= $item['quantity'] ?> кг</span>
            <a href="?remove=<?= $id ?>" class="btn-remove" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">×</a>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="cart-total">
        Итого: <?= number_format($total, 2, '.', ' ') ?> ₽
    </div>

    <a href="checkout.php" class="btn-checkout">📝 Оформить заказ</a>
    <a href="index.php" class="btn-continue">🍎 Продолжить покупки</a>
<?php endif; ?>

</div>

</body>
</html>