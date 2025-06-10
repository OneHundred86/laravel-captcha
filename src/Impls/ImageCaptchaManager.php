<?php

namespace Oh86\Captcha\Impls;

use Illuminate\Support\Manager;
use Oh86\Captcha\CaptchaInterface;

class ImageCaptchaManager extends Manager implements CaptchaInterface
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


    /**
     * @return array{sensitive:bool, key:string, img:string}
     */
    public function acquire()
    {
        return $this->driver()->acquire();
    }

    /**
     * @param array{key:string, value:string} $captcha
     * @return bool
     */
    public function verify($captcha): bool
    {
        return $this->driver()->verify($captcha);
    }
}