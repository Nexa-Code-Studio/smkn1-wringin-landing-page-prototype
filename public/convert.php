<?php
$im = imagecreatefrompng(__DIR__.'/images/alternative/icon.png');
imagewebp($im, __DIR__.'/images/webp/icon.webp', 80);
imagedestroy($im);
echo "OK";
?>
