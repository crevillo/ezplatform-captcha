<?php

declare(strict_types=1);

namespace Crevillo\EzPlatformCaptcha\Tests\Bundle\DependencyInjection\Compiler;

use Crevillo\EzCaptchaBundle\DependencyInjection\Compiler\CaptchaPass;
use Crevillo\EzCaptchaBundle\Form\Extension\UserPasswordForgotTypeExtension;
use eZ\Publish\Core\MVC\Symfony\Controller\SecurityController;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Security\Http\Firewall\UsernamePasswordFormAuthenticationListener;

class CaptchaPassForForgotPasswordTest extends AbstractCompilerPassTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->setParameter('ez_captcha.login_form', false);
        $this->setParameter('ez_captcha.forgot_password_form', true);
        $this->setDefinition(
            'ezpublish.security.controller',
            new Definition(SecurityController::class)
        );

        $this->setDefinition(
            'security.authentication.listener.form',
            new Definition(UsernamePasswordFormAuthenticationListener::class)
        );

        $this->setDefinition(
            'request_stack',
            new Definition()
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CaptchaPass());
    }

    public function testLoginFormWontBeChanged()
    {
        $this->compile();
        $this->assertContainerBuilderHasService('ezpublish.security.controller', SecurityController::class);
        $this->assertContainerBuilderHasService('security.authentication.listener.form', UsernamePasswordFormAuthenticationListener::class);
    }

    public function testForgotPasswordFormIsNotChanged()
    {
        $this->compile();
        $this->assertContainerBuilderHasService(
            UserPasswordForgotTypeExtension::class
        );

        $this->assertContainerBuilderHasParameter(
            'ezsettings.default.user_forgot_password.templates.form',
            '@ezdesign/forgot_password/index-with-captcha.html.twig'
        );

        $this->assertContainerBuilderHasParameter(
            'ezsettings.default.user_forgot_password.templates.form',
            '@ezdesign/forgot_password/index-with-captcha.html.twig'
        );
    }
}
