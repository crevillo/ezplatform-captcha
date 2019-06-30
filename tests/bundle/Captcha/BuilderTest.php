<?php

declare(strict_types=1);

namespace Crevillo\EzPlatformCaptcha\Tests\Bundle\Captcha;

use Crevillo\EzCaptchaBundle\Captcha\Builder;
use Gregwar\Captcha\CaptchaBuilder;

class BuilderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider buildDataProvider
     */
    public function testBuild($options)
    {
        $captchaBuilder = $this->createMock(CaptchaBuilder::class);

        $builder = new Builder(
            $captchaBuilder,
            $options
        );

        $width = array_key_exists('width', $options) ? $options['width'] : 300;
        $height = array_key_exists('height', $options) ? $options['height'] : 75;

        $captchaBuilder->expects($this->once())
            ->method('build')
            ->with($width, $height);

        $builder->build();
    }

    public function buildDataProvider()
    {
        return [
            [['width' => 300, 'height' => 200]],
            [['width' => 300]],
            [['height' => 300]],
        ];
    }
}
