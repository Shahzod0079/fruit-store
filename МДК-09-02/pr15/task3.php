<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function addTextToPhoto($photo_path, $text, $x = 50, $y = 50) {
        header("Content-Type: image/png");
        
        $im = imagecreatefromjpeg($photo_path);
        $text_color = imagecolorallocate($im, 255, 255, 255);
        $font = "arial.ttf";
        
        imagettftext($im, 24, 0, $x, $y, $text_color, $font, $text);
        
        imagepng($im);
        imagedestroy($im);
    }
    
    $text = $_POST['text'] ?? "Надпись";
    $x = $_POST['x'] ?? 50;
    $y = $_POST['y'] ?? 50;
    addTextToPhoto("Задачи/vesna.jpg", $text, $x, $y);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Задача 17</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="text" placeholder="Текст" value="Надпись">
        <input type="number" name="x" placeholder="X координата" value="50">
        <input type="number" name="y" placeholder="Y координата" value="50">
        <button type="submit">Применить</button>
    </form>
    <img src="task3.php" alt="Изображение">
</body>
</html>