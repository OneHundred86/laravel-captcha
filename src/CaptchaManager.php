<?php

namespace Oh86\Captcha;

use Oh86\Captcha\Impls\ImageCaptchaManager;
use Illuminate\Support\Manager;

class CaptchaManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config->get('captcha.default');
    }

    public function createImageDriver()
    {
        return new ImageCaptchaManager($this->container);
    }
}