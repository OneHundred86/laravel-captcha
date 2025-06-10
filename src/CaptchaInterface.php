<?php

namespace Oh86\Captcha;

interface CaptchaInterface
{
    /**
     * 获取验证码
     * @param array|null $options
     * @return mixed
     */
    public function acquire($options = null);

    /**
     * 验证验证码
     * @param mixed $captcha
     * @return bool
     */
    public function verify($captcha): bool;
}