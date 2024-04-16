<?php
    session_start();
    // 随机生成验证码
    $random_code = '';
    for($i = 0; $i < 6; $i++) {
        $random_code .= rand(0, 9);
    }
    // 存储验证码
    $_SESSION['captcha'] = $random_code;

    
    // 创建验证码图片
    $im = imagecreatetruecolor(100, 50);
    imageantialias($im, true);
    $background_color = imagecolorallocate($im, 24, 55, 135); // 背景色
    $text_color = imagecolorallocate($im, 0, 120, 255); // 文字颜色
    $graphic_color = imagecolorallocate($im, 206, 164, 64); // 图形颜色
    imagefilledrectangle($im, 0, 0, 100, 50, $background_color);
    // 添加随机线
    for ($i = 0; $i < 5; $i++) {
        imageline($im, 0, rand()%50, 100, rand()%50, $graphic_color);
    }
    // 添加验证码字符
    for ($i = 0, $x = 5; $i < 6; $i++) {
        imagestringup($im, 5, $x, rand(20, 30), $random_code[$i], $text_color);
        $x += rand(12, 16);
    }

    header('Content-Type: image/png');
    imagepng($im);
    imagedestroy($im);
?>