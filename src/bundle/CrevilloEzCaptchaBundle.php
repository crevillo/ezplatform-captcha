<?php

namespace Crevillo\EzCaptchaBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Crevillo\EzCaptchaBundle\DependencyInjection\Compiler\CaptchaPass;
use Crevillo\EzCaptchaBundle\DependencyInjection\Security\Factory\CaptchaFormLoginFactory;

class CrevilloEzCaptchaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new CaptchaPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 50);
    }
}
