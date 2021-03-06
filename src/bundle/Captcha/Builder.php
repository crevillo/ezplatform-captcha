<?php declare(strict_types=1);

namespace Crevillo\EzCaptchaBundle\Captcha;

use Gregwar\Captcha\CaptchaBuilderInterface;

class Builder
{
    /**
     * @var
     */
    private $captchaBuilder;

    /**
     * @var array
     */
    private $options;

    public function __construct(CaptchaBuilderInterface $captchaBuilder, array $options = [])
    {
        $this->captchaBuilder = $captchaBuilder;
        $this->options = $options;
    }

    /**
     * @return \Gregwar\Captcha\CaptchaBuilder
     */
    public function build()
    {
        return $this->captchaBuilder->build(
            $this->options['width'] ?? 300,
            $this->options['height'] ?? 75,
            $this->options['font'] ?? __DIR__ . '/../../../../../gregwar/captcha/src/Gregwar/Captcha/Font/captcha0.ttf'
        );
    }
}
