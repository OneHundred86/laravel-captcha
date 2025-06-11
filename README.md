# 验证码

### 一、配置 `config/captcha.php`

```php
return [
    'default' => env('CAPTCHA_DEFAULT_DRIVER', 'image'),

    'image' => [
        'type' => 'default',    // 默认验证码类型，default|math|flat|mini|inverse
        'characters' => ['2', '3', '4', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'm', 'n', 'p', 'q', 'r', 't', 'u', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'X', 'Y', 'Z'],
        'default' => [
            'length' => 4,          // 验证码长度
            'width' => 120,
            'height' => 36,
            'quality' => 90,
            'expire' => 600,        // 过期时间，单位为秒
            'sensitive' => false,   // 是否区分大小写
            'encrypt' => false,
        ],
        'math' => [
            'length' => 9,
            'width' => 120,
            'height' => 36,
            'quality' => 90,
            'math' => true,
            'expire' => 600,
        ],

        'flat' => [
            'length' => 6,
            'width' => 160,
            'height' => 46,
            'quality' => 90,
            'lines' => 6,
            'bgImage' => false,
            'bgColor' => '#ecf2f4',
            'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
            'contrast' => -5,
            'expire' => 600,
        ],
        'mini' => [
            'length' => 3,
            'width' => 60,
            'height' => 32,
            'expire' => 600,
        ],
        'inverse' => [
            'length' => 5,
            'width' => 120,
            'height' => 36,
            'quality' => 90,
            'sensitive' => true,
            'angle' => 12,
            'sharpen' => 10,
            'blur' => 2,
            'invert' => true,
            'contrast' => -5,
            'expire' => 600,
        ]
    ],
];
```

### 二、使用

#### 1.获取验证码和验证验证码

```php
use Oh86\Captcha\Facades\Captcha;

// 获取
$captcha = Captcha::acquire();
$captcha = Captcha::driver('image')->acquire();
$captcha = Captcha::driver('image')->driver('default')->acquire();
$captcha = Captcha::driver('image')->driver('math')->acquire();

// 验证
Captcha::verify(['key' => $captcha['key'], 'value' => 'abcd']);
Captcha::driver('image')->verify(['key' => $captcha['key'], 'value' => 'abcd']);
Captcha::driver('image')->driver('default')->verify(['key' => $captcha['key'], 'value' => 'abcd']);
Captcha::driver('image')->driver('math')->verify(['key' => $captcha['key'], 'value' => '20']);
```

#### 2.验证验证码

```php
use App\Constants\ErrorCode;
use Illuminate\Http\Request;
use Oh86\Captcha\Facades\Captcha;
use Oh86\Http\Exceptions\ErrorCodeException;

trait CaptchaTrait
{
    /**
     * 校验验证码
     * @param \Illuminate\Http\Request $request
     * @throws \Oh86\Http\Exceptions\ErrorCodeException
     */
    protected function verifyCaptcha(Request $request)
    {
        $request->validate([
            'captcha_type' => 'nullable',
            'captcha' => 'required|array',
        ]);

        // 本地环境不校验
        if (config('app.env') == 'local') {
            return;
        }

        $captchaType = $request->captcha_type ?? Captcha::getDefaultDriver();

        if ($captchaType == 'image'){
            $request->validate([
                'captcha.type' => 'nullable',   // default,math,flat,mini,inverse
                'captcha.key' => 'required',
                'captcha.value' => 'required',
            ]);

            if (!Captcha::driver('image')->driver($request->captcha['type'] ?? null)->verify($request->captcha)) {
                throw new ErrorCodeException(ErrorCode::Error, '验证码错误');
            }
            return;
        } elseif ($captchaType == 'tencentCloud') {
            $request->validate([
                'captcha.ticket' => 'required',
                'captcha.randStr' => 'required',
            ]);

            $captcha = ['userIp' => $request->ip()] + $request->captcha;
        } else {
            throw new ErrorCodeException(ErrorCode::Error, '验证码类型不支持');
        }

        if (!Captcha::driver($request->captcha_type)->verify($captcha)) {
            throw new ErrorCodeException(ErrorCode::Error, '验证码错误');
        }
    }
}
```