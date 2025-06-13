<?php

return [
    'default' => env('CAPTCHA_DEFAULT_DRIVER', 'normalImage'),

    'normalImage' => [
        'characters' => ['2', '3', '4', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'm', 'n', 'p', 'q', 'r', 't', 'u', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'X', 'Y', 'Z'],
        'length' => 4,          // 验证码长度
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'expire' => 600,        // 过期时间，单位为秒
        'sensitive' => false,   // 是否区分大小写
        'encrypt' => false,
        'lines' => 1,           // 干扰线数量
    ],

    'mathImage' => [
        'length' => 9,  // 数学式子长度，此处固定为9
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
        'expire' => 600,
    ],
];
