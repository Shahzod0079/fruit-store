<?php
session_start();

// Если корзина пуста - возврат в каталог
if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

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

// Обработка оформления заказа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    
    $errors = [];
    if (empty($name)) $errors[] = 'Введите имя';
    if (empty($phone)) $errors[] = 'Введите телефон';
    
    if (empty($errors)) {
        // Сохраняем заказ
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone) VALUES (?, ?)");
        $stmt->execute([$name, $phone]);
        $order_id = $pdo->lastInsertId();
        
        // Сохраняем товары заказа
        $total = 0;
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$order_id, $product_id, $item['quantity'], $item['price']]);
            $total += $item['price'] * $item['quantity'];
        }
        
        // Очищаем корзину
        $_SESSION['cart'] = [];
        $_SESSION['last_order_id'] = $order_id;
        
        header('Location: success.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Оформление заказа</title>
     <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h1>📋 Оформление</h1>

<?php if (!empty($errors)): ?>
    <div class="error">
        <?= implode('<br>', $errors) ?>
    </div>
<?php endif; ?>

<?php
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<div class="order-summary">
    <h3>Ваш заказ:</h3>
    <?php foreach ($_SESSION['cart'] as $item): ?>
    <div class="summary-item">
        <span><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?> кг</span>
        <span><?= number_format($item['price'] * $item['quantity'], 2, '.', ' ') ?> ₽</span>
    </div>
    <?php endforeach; ?>
    <div class="summary-total">
        <span>Итого:</span>
        <span><?= number_format($total, 2, '.', ' ') ?> ₽</span>
    </div>
</div>

<form method="post" class="checkout-form">
    <div class="form-group">
        <label>Ваше имя</label>
        <input type="text" name="name" placeholder="Иван Петров" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
    </div>
    
    <div class="form-group">
        <label>Телефон</label>
        <input type="tel" name="phone" placeholder="+7 (999) 123-45-67" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
    </div>
    
    <button type="submit" class="btn-submit">✅ Подтвердить заказ</button>
</form>

<a href="cart.php" class="btn-back">← Вернуться в корзину</a>
</div>
</body>
</html>