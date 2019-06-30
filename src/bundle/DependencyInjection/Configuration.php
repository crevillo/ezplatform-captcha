<?php

declare(strict_types=1);

namespace Crevillo\EzCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return Symfony\Component\Config\Definition\Builder\TreeBuilder;
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('crevillo_ez_captcha');
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('login_form')->defaultFalse()->end()
                ->booleanNode('forgot_password_form')->defaultFalse()->end()
                ->arrayNode('configs')
                    ->children()
                        ->scalarNode('width')->defaultValue(300)->end()
                        ->scalarNode('height')->defaultValue(75)->end()
                    ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
