<?php 
$item = [
    'id' => $_GET['id'],
    'name' => $_GET['name'],
    'price' => $_GET['price'],
    'category' => $_GET['category'],
    'description' => $_GET['description']
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Товар</title>
</head>
<body>
    <h1><?= $item['name'] ?></h1>
    <p>Категория: <?= $item['category'] ?></p>
    <p>Цена: <?= $item['price'] ?> руб.</p>
    <p><?= $item['description'] ?></p>
</body>
</html>
