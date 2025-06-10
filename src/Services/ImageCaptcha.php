<?php

namespace Oh86\Captcha\Services;

use Mews\Captcha\Captcha;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Hashing\BcryptHasher as Hasher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Illuminate\Session\Store as Session;

class ImageCaptcha extends Captcha
{
    private const ConfigKeyPrefix = 'captcha.image.';

    /**
     * Constructor
     *
     * @param Filesystem $files
     * @param Repository $config
     * @param ImageManager $imageManager
     * @param Session $session
     * @param Hasher $hasher
     * @param Str $str
     */
    public function __construct(
        Filesystem $files,
        Repository $config,
        ImageManager $imageManager,
        Session $session,
        Hasher $hasher,
        Str $str
    ) {
        parent::__construct($files, $config, $imageManager, $session, $hasher, $str);

        $this->characters = $config->get(self::ConfigKeyPrefix . 'characters', ['1', '2', '3', '4', '6', '7', '8', '9']);
    }

    /**
     * @override 
     * @param string $config
     * @return void
     */
    protected function configure($config)
    {
        if ($this->config->has(self::ConfigKeyPrefix . $config)) {
            foreach ($this->config->get(self::ConfigKeyPrefix . $config) as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }
}