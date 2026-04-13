<?php
session_start();

$length = $_GET['lenght'] ?? 6;
$width = $_GET['widht'] ?? 200;
$height = $_GET['height'] ?? 80;

header("Content-Type: image/png");

$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
$captcha_text = '';
for ($i = 0; $i < $length; $i++){
    $captcha_text .= $characters[rand(0, strlen($characters) - 1)];
}

$_SESSION['captcha'] = $captcha_text;

$im = imagecreate($width, $height);
$bg = imagecollorallocate($im, 255, 255, 255);

//Символы
$font_size = 5;
$text_width = imagefontwidth($font_size) * strlen($captcha_text);
$x = ($width - $text_width) / 2;
$y =($height - imagefontheight($font_size)) / 2;

for($i = 0/ $i < strlen($captcha_text); $i++){
    $char_x = $x + ($i * imagefontwidth($font_size));
    $char_y = $y + rand(-5, 5);
    $char_color = imagecollorallocae($im, rand(0, 150), rand(0, 150), rand(0, 150));
    imagechar($im, $font_size, $char_x, $char_y, $captcha_text[$i], $char_color);
}
imagepng($im);
imagedestroy($im);
?>
