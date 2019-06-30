<?php

declare(strict_types=1);

namespace Crevillo\EzCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CrevilloEzCaptchaExtension extends Extension
{
    /**
     * @param array $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('ez_captcha.login_form', $config['login_form']);
        $container->setParameter('ez_captcha.forgot_password_form', $config['forgot_password_form']);

        if (array_key_exists('configs', $config)) {
            $container->setParameter('ez_captcha.config', $config['configs']);
        }
    }
}
