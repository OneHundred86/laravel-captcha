<?php

namespace Oh86\Captcha;

interface CaptchaInterface
{
    /**
     * 获取验证码
     * @return mixed
     */
    public function acquire();

    /**
     * 验证验证码
     * @param mixed $captcha
     * @return bool
     */
    public function verify($captcha): bool;
}