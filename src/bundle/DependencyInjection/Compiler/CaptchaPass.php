<?php

declare(strict_types=1);

namespace Crevillo\EzCaptchaBundle\DependencyInjection\Compiler;

use EzSystems\EzPlatformUser\Form\Type\UserPasswordForgotType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Crevillo\EzCaptchaBundle\Form\Extension\UserPasswordForgotTypeExtension;
use Crevillo\EzCaptchaBundle\MVC\Symfony\Controller\SecurityController;
use Crevillo\EzCaptchaBundle\Security\Http\Firewall\CaptchaAuthenticationListener;

class CaptchaPass implements CompilerPassInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if ($enabledForLoginForm = $container->getParameter('ez_captcha.login_form')) {
            $this->configureLoginCaptcha($container);
        }

        if ($enabledForForgotPasswordForm = $container->getParameter('ez_captcha.forgot_password_form')) {
            $this->configureForgotPasswordCaptcha($container);
        }
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function configureLoginCaptcha(ContainerBuilder $container): void
    {
        $securityControllerDefinition = $container->findDefinition('ezpublish.security.controller');
        $securityControllerDefinition->setClass(SecurityController::class);
        $securityControllerDefinition->addArgument(new Reference('request_stack'));
        $securityControllerDefinition->addArgument(new Reference('Crevillo\EzCaptchaBundle\Captcha\Builder'));

        $securityAuthenticationListenerFormDefinition = $container->findDefinition(
            'security.authentication.listener.form'
        );
        $securityAuthenticationListenerFormDefinition->setClass(
            CaptchaAuthenticationListener::class
        );

        $container->setParameter('ezsettings.default.security.login_template', '@ezdesign/Security/login-with-captcha.html.twig');
        $container->setParameter('ezsettings.admin.security.login_template', '@ezdesign/Security/login-with-captcha.html.twig');
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function configureForgotPasswordCaptcha(ContainerBuilder $container): void
    {
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
