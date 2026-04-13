<?php
// header("Content-Type: Image/Безымянный.png");

// $im = imagecraete(200, 100);
// $bg_color = imagecolorallocate($im,0,0,0);
// $txt_color = imagecolorallocate($im,255,255,255);
// imageString ($im,5,50,50, "Text....", $txt_color);

// imagepng($im);
// imagedestory($im);

// header("Content-Type: image/jpeg");

// $image = imagecreate(200, 100);

// $background_color = imagecolorallocate($image, 0, 0, 0);    
// $text_color = imagecolorallocate($image, 255, 255, 255);      
// imagestring($image, 5, 50, 50, "Text...", $text_color);

// imagejpeg($image, '1a.jpg', 75);
// imagejpeg($image, null, 75);
// imagedestroy($image);

header("Content-Type: image/png");

$im = imagecreatefromjpeg("vesna.jpg");
$txt_color = imagecolorallocate($im, 255, 0, 0);
$shadow = imagecolorallocate($im, 0, 255, 0);

$font = "arial.ttf";

imagettftext($im, 32, -30, 54, 54, $shadow, $font, "Text...");
imagettftext($im, 32, -30, 50, 50, $txt_color, $font, "Text...");

imagepng($im, '2a.png', 9);
imagepng($im, null, 9);
imagedestroy($im);
?>