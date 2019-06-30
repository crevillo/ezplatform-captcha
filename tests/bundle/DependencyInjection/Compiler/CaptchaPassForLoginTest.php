<?php

declare(strict_types=1);

namespace Crevillo\EzPlatformCaptcha\Tests\Bundle\DependencyInjection\Compiler;

use Crevillo\EzCaptchaBundle\DependencyInjection\Compiler\CaptchaPass;
use Crevillo\EzCaptchaBundle\Form\Extension\UserPasswordForgotTypeExtension;
use Crevillo\EzCaptchaBundle\MVC\Symfony\Controller\SecurityController;
use Crevillo\EzCaptchaBundle\Security\Http\Firewall\CaptchaAuthenticationListener;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class CaptchaPassForLoginTest extends AbstractCompilerPassTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->setParameter('ez_captcha.login_form', true);
        $this->setParameter('ez_captcha.forgot_password_form', false);
        $this->setDefinition(
            'ezpublish.security.controller',
            new Definition()
        );

        $this->setDefinition(
            'security.authentication.listener.form',
            new Definition()
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

    public function testLoginForm()
    {
        $this->compile();
        $this->assertContainerBuilderHasService('ezpublish.security.controller', SecurityController::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('ezpublish.security.controller', 0, 'request_stack');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('ezpublish.security.controller', 1, 'Crevillo\EzCaptchaBundle\Captcha\Builder');
        $this->assertContainerBuilderHasService('security.authentication.listener.form', CaptchaAuthenticationListener::class);

        $this->assertContainerBuilderHasParameter(
            'ezsettings.default.security.login_template',
            '@ezdesign/Security/login-with-captcha.html.twig'
        );

        $this->assertContainerBuilderHasParameter(
            'ezsettings.admin.security.login_template',
            '@ezdesign/Security/login-with-captcha.html.twig'
        );
    }

    public function testForgotPasswordFormIsNotChanged()
    {
        $this->compile();
        $this->assertContainerBuilderNotHasService(
            UserPasswordForgotTypeExtension::class
        );
    }
}
