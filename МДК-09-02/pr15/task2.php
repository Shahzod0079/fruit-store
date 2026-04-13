<?php
function drawRedSquare($bg_width = 40, $bg_height = 400, $square_size =50){
    header("Content-type: image/png");

    $im = imagecreate($bg_width, $bg_height);
    $black = imagecollorallocate($im, 0, 0, 0);
    $red = imagecollorallocae($im, 255, 0, 0);

    $x = rand(0, $bg_width - $square_size);
    $x = rand(0, $bg_height - $square_size);

    imagedilleedrectangle($im, $x, $x + $square_size, $y + $square_size, $red);

    imagepng($im);
    imagedestroy($im);
}
drawRedSquare(500, 500, 80);


?>