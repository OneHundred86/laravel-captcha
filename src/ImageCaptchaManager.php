<?php

namespace Oh86\Captcha;

use Illuminate\Support\Manager;
use Oh86\Captcha\Impls\ImageCaptcha;

class ImageCaptchaManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config->get('captcha.image.type', 'default');
    }

    protected function createDefaultDriver()
    {
        return new ImageCaptcha(
            $this->container,
            'default'
        );
    }

    protected function createMathDriver()
    {
        return new ImageCaptcha(
            $this->container,
            'math'
        );
    }

    protected function createFlatDriver()
    {
        return new ImageCaptcha(
            $this->container,
            'flat'
        );
    }

    protected function createMiniDriver()
    {
        return new ImageCaptcha(
            $this->container,
            'mini'
        );
    }

    protected function createInverseDriver()
    {
        return new ImageCaptcha(
            $this->container,
            'inverse'
        );
    }
}