<?php

namespace TheCocktail\EzCaptchaBundle\DependencyInjection\Compiler;

use EzSystems\EzPlatformUser\Form\Type\UserPasswordForgotType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use TheCocktail\EzCaptchaBundle\Form\Extension\UserPasswordForgotTypeExtension;
use TheCocktail\EzCaptchaBundle\MVC\Symfony\Controller\SecurityController;
use TheCocktail\EzCaptchaBundle\Security\Http\Firewall\CaptchaAuthenticationListener;

class CaptchaPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($enabledForLoginForm = $container->getParameter('ez_captcha.login_form')) {
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

        if ($enabledForForgotPasswordForm = $container->getParameter('ez_captcha.forgot_password_form')) {
            $definition = new Definition(
                UserPasswordForgotTypeExtension::class
            );
            $definition->addTag('form.type_extension', ['extended_type' => UserPasswordForgotType::class, 'extended-type' => UserPasswordForgotType::class]);

            $container->setDefinition(
                UserPasswordForgotTypeExtension::class,
                $definition
            );

            $container->setParameter(
                'ezsettings.default.user_forgot_password.templates.form',
                '@ezdesign/forgot_password/index-with-captcha.html.twig'
            );

            $container->setParameter(
                'ezsettings.admin_group.user_forgot_password.templates.form',
                '@ezdesign/Security/forgot_password/index-with-captcha.html.twig'
            );
        }
    }
}
