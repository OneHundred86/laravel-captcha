<?php

namespace Oh86\Captcha\Services;

use Mews\Captcha\Captcha;
use Illuminate\Contracts\Container\Container as Application;

class ImageCaptcha extends Captcha
{
    public function __construct(Application $app, array $config)
    {
        parent::__construct(
            $app->get('Illuminate\Filesystem\Filesystem'),
            $app->get('Illuminate\Contracts\Config\Repository'),
            $app->get('Intervention\Image\ImageManager'),
            $app->get('Illuminate\Session\Store'),
            $app->get('Illuminate\Hashing\BcryptHasher'),
            $app->get('Illuminate\Support\Str')
        );

        // 配置
        foreach ($config as $key => $val) {
            $this->{$key} = $val;
        }
    }

    /**
     * do nothing
     * @override
     */
    protected function configure($config)
    {
        return;
    }
}