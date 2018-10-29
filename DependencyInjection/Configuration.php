<?php

namespace Liuggio\StatsDClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link https://symfony.com/doc/current/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    private $debug;

    public function __construct($debug)
    {
        $this->debug = $debug;
    }

    /**
     * {@inheritdoc}
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
                    ->scalarNode('class')->defaultValue('Liuggio\StatsdClient\Sender\SocketSender')->end()
                    ->arrayNode('arguments')
                        ->scalarPrototype()->defaultValue(['localhost', 8126, 'udp'])->end()
                    ->end()
                    ->scalarNode('reduce_packet')->defaultValue(true)->end()
                    ->scalarNode('fail_silently')->defaultValue(true)->end()
                ->end()
            ->end()
            ->arrayNode('collectors')->canBeUnset()
                ->prototype('scalar')->end()
                ->useAttributeAsKey('name')
            ->end()
            ->arrayNode('monolog')->canBeUnset()
                ->children()
                    ->scalarNode('enable')->defaultValue(false)->end()
                    ->scalarNode('prefix')->defaultValue('log')->end()
                    ->scalarNode('level')->defaultValue('warning')->end()
                    ->arrayNode('formatter')
                        ->children()
                            ->scalarNode('class')->defaultValue('Liuggio\StatsdClient\Monolog\Formatter\StatsDFormatter')->end()
                            ->scalarNode('format')->defaultValue(null)->end()
                            ->booleanNode('context_logging')->defaultValue(false)->end()
                            ->booleanNode('extra_logging')->defaultValue(false)->end()
                            ->scalarNode('words')->defaultValue(2)->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
          ->end();

        return $treeBuilder;
    }
}
