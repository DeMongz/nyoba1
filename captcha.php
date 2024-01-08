<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

function acakCaptcha(){
    $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $pass = array();
    $panjangAlpha = strlen($alphabet) - 2;
    
    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $panjangAlpha);
        $pass[] = $alphabet[$n];
    }
    
    return implode($pass);
}

// Untuk mengacak captcha
$code = acakCaptcha();
$_SESSION["code"] = $code;

// Lebar dan tinggi captcha
$wh = imagecreatetruecolor(173, 50);

// Warna latar belakang biru
$bgc = imagecolorallocate($wh, 22, 86, 165);

// Warna teks abu-abu
$fc = imagecolorallocate($wh, 223, 230, 233);

imagefill($wh, 0, 0, $bgc);

// (image, fontsize, x, y, string, fontcolor)
imagestring($wh, 10, 50, 15, $code, $fc);

// Membuat gambar
header('Content-Type: image/jpeg');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

imagejpeg($wh);
imagedestroy($wh);
?>
