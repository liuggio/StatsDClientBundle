<?php

namespace Liuggio\StatsDClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('liuggio_stats_d_client');

        $rootNode->children()
            ->booleanNode('enable_collector')->defaultFalse()->end()
            ->arrayNode('connection')
                ->children()
                    ->scalarNode("port")->defaultValue(8125)->end()
                    ->scalarNode("host")->defaultValue("localhost")->end()
                    ->scalarNode("fail_silently")->defaultValue(true)->end()
                ->end()
            ->end()
            ->arrayNode('collectors')
                ->prototype('scalar')->end()
                ->isRequired()
                ->useAttributeAsKey('name')
            ->end()
        ->end();

        return $treeBuilder;
    }
}
