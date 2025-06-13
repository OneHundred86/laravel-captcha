# 验证码

### 一、配置 `config/captcha.php`

```php
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
```

### 二、使用

#### 1.获取验证码和验证验证码

```php
use Oh86\Captcha\Facades\Captcha;

// 获取
$captcha = Captcha::acquire();
$captcha = Captcha::driver('mathImage')->acquire();

// 验证
Captcha::verify(['key' => $captcha['key'], 'value' => 'abcd']);
Captcha::driver('mathImage')->verify(['key' => $captcha['key'], 'value' => '25']);
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

        $captchaType = $request->captcha_type ?? Captcha::getDefaultDriver();
        $captcha = $request->captcha;

        if ($captchaType == 'normalImage' || $captchaType == 'mathImage'){
            $request->validate([
                'captcha.key' => 'required',
                'captcha.value' => 'required',
            ]);
        } elseif ($captchaType == 'tencentCloud') {
            $request->validate([
                'captcha.ticket' => 'required',
                'captcha.randStr' => 'required',
            ]);

            $captcha = ['userIp' => $request->ip()] + $captcha;
        } else {
            throw new ErrorCodeException(ErrorCode::Error, '验证码类型不支持');
        }
        
        // 本地环境不校验
        if (config('app.env') == 'local') {
            return;
        }

        if (!Captcha::driver($request->captcha_type)->verify($captcha)) {
            throw new ErrorCodeException(ErrorCode::Error, '验证码错误');
        }
    }
}
```