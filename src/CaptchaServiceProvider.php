<?php

namespace Oh86\Captcha;

use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CaptchaManager::class, function ($app) {
            return new CaptchaManager($app);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/captcha.php' => config_path('captcha.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../config/captcha.php', 'captcha');
    }
}