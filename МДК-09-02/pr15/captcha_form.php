<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Капча</title>
</head>
<body>
    <form method="GET">
        <label>Длина: <input type="number" name="length" min="4" max="10" value="<?= $_GET['length'] ?? 6 ?>"></label><br>
        <label>Ширина: <input type="number" name="width" min="100" max="400" value="<?= $_GET['width'] ?? 200 ?>"></label><br>
        <label>Высота: <input type="number" name="height" min="50" max="200" value="<?= $_GET['height'] ?? 80 ?>"></label><br>
        <button type="submit">Обновить капчу</button>
    </form>

    <img src="captcha.php?length=<?= $_GET['length'] ?? 6 ?>&width=<?= $_GET['width'] ?? 200 ?>&height=<?= $_GET['height'] ?? 80 ?>&r=<?= rand() ?>" 
         alt="CAPTCHA">
    
    <p>Код из капчи: <?= $_SESSION['captcha'] ?? 'не сгенерирован' ?></p>
</body>
</html>