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
    private $debug;

    public function __construct($debug)
    {
        $this->debug = $debug;
    }
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('liuggio_stats_d_client');

        $rootNode
            ->children()
                ->arrayNode('connection')
                    ->children()
                        ->scalarNode('debug')->defaultValue($this->debug)->end()
                        ->scalarNode('port')->defaultValue(8125)->end()
                        ->scalarNode('host')->defaultValue('localhost')->end()
                        ->scalarNode('reduce_packet')->defaultValue(true)->end()
                        ->scalarNode('protocol')->defaultValue('udp')->end()
                        ->scalarNode('fail_silently')->defaultValue(true)->end()
                    ->end()
                ->end()
                ->scalarNode('metrics_enabled')->defaultFalse()->end()
                ->arrayNode('metrics')
                    ->prototype('scalar')->end()
                    ->useAttributeAsKey('name')
                ->end()
                ->arrayNode('monolog')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('prefix')->defaultValue('log')->end()
                        ->scalarNode('level')->defaultValue('warning')->end()
                        ->arrayNode('formatter')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('format')->defaultValue(null)->end()
                                ->booleanNode('context_logging')->defaultValue(false)->end()
                                ->booleanNode('extra_logging')->defaultValue(false)->end()
                                ->scalarNode('words')->defaultValue(2)->end()
                            ->end()
                        ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
