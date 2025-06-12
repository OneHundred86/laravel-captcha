<?php

namespace Oh86\Captcha\Impls;

use Oh86\Captcha\CaptchaInterface;
use Oh86\Captcha\Services\ImageCaptcha as Captcha;
use Illuminate\Contracts\Container\Container as Application;

class ImageCaptcha implements CaptchaInterface
{
    private Captcha $captcha;
    private string $type;

    public function __construct(Application $app, string $type)
    {
        $this->captcha = new Captcha(
            $app->get('Illuminate\Filesystem\Filesystem'),
            $app->get('Illuminate\Contracts\Config\Repository'),
            $app->get('Intervention\Image\ImageManager'),
            $app->get('Illuminate\Session\Store'),
            $app->get('Illuminate\Hashing\BcryptHasher'),
            $app->get('Illuminate\Support\Str')
        );

        $this->type = $type;
    }

    /**
     * @return array{sensitive:bool, key:string, img:string}
     */
    public function acquire($options = null): array
    {
        return $this->captcha->create($this->type, true);
    }

    /**
     * @param array{key:string, value:string} $captcha
     * @return bool
     */
    public function verify($captcha): bool
    {
        return $this->captcha->check_api($captcha['value'], $captcha['key'], $this->type);
    }
}