<?php

namespace Oh86\Captcha;

use Illuminate\Support\Manager;
use Oh86\Captcha\Impls\ImageCaptcha;

class ImageCaptchaManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config->get('captcha.image.default', 'normal');
    }

    protected function createNormalDriver()
    {
        return new ImageCaptcha(
            $this->container,
            'normal'
        );
    }

    protected function createMathDriver()
    {
        return new ImageCaptcha(
            $this->container,
            'math'
        );
    }
}