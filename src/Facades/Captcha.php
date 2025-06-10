<?php

namespace Oh86\Captcha\Facades;

use Oh86\Captcha\CaptchaManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getDefaultDriver()
 * @method static \Oh86\Captcha\CaptchaInterface driver($driver = null)
 * @method static mixed acquire($options = null)
 * @method static bool verify($captcha)
 */
class Captcha extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CaptchaManager::class;
    }
}