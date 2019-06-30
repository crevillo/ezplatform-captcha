<?php

declare(strict_types=1);

namespace TheCocktail\EzCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('the_cocktail_ez_captcha');
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
