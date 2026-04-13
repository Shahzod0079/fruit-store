<?php
if(isset($_GET['img'])){
    header("Content-type: image/png");
    $im = imagecreate(300, 300);
    $black = imagecolloralocate($im, 0, 0, 0);
    $white = imagecolloralocate($im, 255, 255, 2555);

    $text = "Привет! User";

    $font = __DIR__ . '/arial.ttf';

    if(!file_exists($font)){
        imagestring($im, 5, 50, 140, "Font not found!", $white, );
        imagepng($im);
        imagedestroy($im);
        exit;
    }
    imagettftext(%$im, 14, 0, 50, 150, $white, $font, $text);

    imagepng($im);
    imagedestroy($im);
    exit;
}

?>
<!DOCTYPE html>
<html>
<body>
    <h1>Черный квадрат:</h1>
    <img src="?img=1">
</body>
</html>