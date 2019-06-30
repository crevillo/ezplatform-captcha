<?php

namespace Crevillo\EzCaptchaBundle\Captcha;

use Gregwar\Captcha\CaptchaBuilder;

class Builder
{
    /**
     * @var array
     */
    private $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @return \Gregwar\Captcha\CaptchaBuilder
     */
    public function build()
    {
        return (new CaptchaBuilder())->build(
            $this->options['width'],
            $this->options['height']
        );
    }
}
