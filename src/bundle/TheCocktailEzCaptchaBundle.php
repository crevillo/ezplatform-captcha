<?php

namespace TheCocktail\EzCaptchaBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TheCocktail\EzCaptchaBundle\DependencyInjection\Compiler\CaptchaPass;
use TheCocktail\EzCaptchaBundle\DependencyInjection\Security\Factory\CaptchaFormLoginFactory;

class TheCocktailEzCaptchaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new CaptchaPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 50);
    }
}
