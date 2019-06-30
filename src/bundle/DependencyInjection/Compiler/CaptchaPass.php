<?php

namespace TheCocktail\EzCaptchaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use TheCocktail\EzCaptchaBundle\MVC\Symfony\Controller\SecurityController;
use TheCocktail\EzCaptchaBundle\Security\Http\Firewall\CaptchaAuthenticationListener;

class CaptchaPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($loginFormEnabled = $container->getParameter('ez_captcha.login_form')) {

            $securityControllerDefinition = $container->findDefinition('ezpublish.security.controller');
            $securityControllerDefinition->setClass(SecurityController::class);
            $securityControllerDefinition->addArgument(new Reference('request_stack'));
            $securityControllerDefinition->addArgument(new Reference('TheCocktail\EzCaptchaBundle\Captcha\Builder'));

            $securityAuthenticationListenerFormDefinition = $container->findDefinition(
                'security.authentication.listener.form'
            );
            $securityAuthenticationListenerFormDefinition->setClass(
                CaptchaAuthenticationListener::class
            );

            $container->setParameter('ezsettings.default.security.login_template', '@ezdesign/Security/login-with-captcha.html.twig');
            $container->setParameter('ezsettings.admin.security.login_template', '@ezdesign/Security/login-with-captcha.html.twig');

        }
    }
}
