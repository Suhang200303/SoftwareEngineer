<?php
session_start();

// 生成随机的验证码字符串
$captchaString = substr(md5(mt_rand()), 0, 5);

// 将验证码字符串保存到会话中
$_SESSION['captcha'] = $captchaString;

// 创建一个带有验证码的图像
$captchaImage = imagecreate(100, 30);
$backgroundColor = imagecolorallocate($captchaImage, 255, 255, 255);
$textColor = imagecolorallocate($captchaImage, 0, 0, 0);

// 发送图像的Content-Type标头
header('Content-type: image/png');

// 添加随机的像素噪声
/*for ($i = 0; $i < 1000; $i++) {
    imagesetpixel($captchaImage, rand(0, 100), rand(0, 30), $textColor);
}*/

// 添加彩色验证码字符
for ($i = 0; $i < strlen($captchaString); $i++) {
    $charColor = imagecolorallocate($captchaImage, rand(0, 255), rand(0, 255), rand(0, 255));
    imagestring($captchaImage, 5, 5 + ($i * 20), 5, $captchaString[$i], $charColor);
}

// 将图像作为PNG输出
imagepng($captchaImage);

// 释放图像内存
imagedestroy($captchaImage);
?>
