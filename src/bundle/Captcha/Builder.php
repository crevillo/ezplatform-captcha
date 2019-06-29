<?php

namespace TheCocktail\EzCaptchaBundle\Captcha;

use Gregwar\Captcha\CaptchaBuilder;

class Builder
{
    private $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function build()
    {
        return (new CaptchaBuilder())->build(
            $this->options['width'],
            $this->options['height']
        );
    }
}
