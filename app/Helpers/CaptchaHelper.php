<?php
namespace App\Helpers;

use Anhskohbo\NoCaptcha\NoCaptcha;

class CaptchaHelper
{
    /**
     * @return NoCaptcha
     */
    public static function getCaptcha(): NoCaptcha
    {
        return new NoCaptcha(getenv('NOCAPTCHA_SECRET'), getenv('NOCAPTCHA_SITEKEY'));
    }

}
