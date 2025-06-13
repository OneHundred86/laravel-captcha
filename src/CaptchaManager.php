<?php

namespace Oh86\Captcha;

use Illuminate\Support\Manager;
use Oh86\Captcha\Captchas\ImageCaptcha;

class CaptchaManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config->get('captcha.default');
    }

    public function createNormalImageDriver()
    {
        $config = $this->config->get('captcha.normalImage');
        return new ImageCaptcha($this->container, $config);
    }

    public function createMathImageDriver()
    {
        $config = $this->config->get('captcha.mathImage');
        return new ImageCaptcha($this->container, $config);
    }
}