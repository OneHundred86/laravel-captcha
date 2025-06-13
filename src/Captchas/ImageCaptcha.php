<?php

namespace Oh86\Captcha\Captchas;

use Oh86\Captcha\CaptchaInterface;
use Oh86\Captcha\Services\ImageCaptcha as Captcha;
use Illuminate\Contracts\Container\Container as Application;

class ImageCaptcha implements CaptchaInterface
{
    private Captcha $captcha;

    public function __construct(Application $app, array $config)
    {
        $this->captcha = new Captcha($app, $config);
    }

    /**
     * @return array{sensitive:bool, key:string, img:string}
     */
    public function acquire($options = null): array
    {
        return $this->captcha->create('', true);
    }

    /**
     * @param array{key:string, value:string} $captcha
     * @return bool
     */
    public function verify($captcha): bool
    {
        return $this->captcha->check_api($captcha['value'], $captcha['key'], '');
    }
}