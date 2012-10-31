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

        $rootNode
          ->children()
            ->booleanNode('enable_collector')->defaultFalse()->end()
            ->arrayNode('connection')
                ->children()
                    ->scalarNode("port")->defaultValue(8125)->end()
                    ->scalarNode("host")->defaultValue("localhost")->end()
                    ->scalarNode("fail_silently")->defaultValue(true)->end()
                ->end()
            ->end()
            ->arrayNode('collectors')->canBeUnset()
                ->prototype('scalar')->end()
                ->isRequired()
                ->useAttributeAsKey('name')
            ->end()
            ->arrayNode('monolog')->canBeUnset()
                ->children()
                    ->scalarNode('enable')->defaultValue(false)->end()
                    ->scalarNode('prefix')->defaultValue("log")->end()
                    ->scalarNode('formatter')->defaultValue("monolog.formatter.shortline")->end()
                    ->scalarNode('level')->defaultValue("warning")->end()
                    ->scalarNode('context_logging')->defaultValue(false)->end()
                ->end()
            ->end()
          ->end();

        return $treeBuilder;
    }
}
