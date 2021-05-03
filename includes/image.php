<?php
session_start();

$random_alpha = md5(rand());

$captcha_code = substr($random_alpha, 0 , 6);

$_SESSION['captch_code'] = $captcha_code;

header('Content-Type: image/png');

$image = imagecreatetruecolor(200,38);

$image_bg = imagecolorallocate($image , 231 , 100 , 18);

$text_color = imagecolorallocate($image , 255 , 255 ,255);

imagefilledrectangle($image,0,0,200,38,$image_bg);

$font = dirname(__FILE__) . '/fontcaptchacode.ttf';

imagettftext($image, 20, 0, 60, 28, $text_color, $font, $captcha_code);

imagepng($image);

imagedestroy($image);




 ?>
