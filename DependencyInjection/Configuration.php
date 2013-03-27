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
            ->booleanNode('enable_collector')->defaultFalse()->end()
            ->arrayNode('connection')
                ->children()
                    ->scalarNode("class")->defaultValue('Liuggio\StatsdClient\Sender\SocketSender')->end()
                    ->scalarNode("debug_class")->defaultValue('Liuggio\StatsdClient\Sender\SysLogSender')->end()
                    ->scalarNode("debug")->defaultValue($this->debug)->end()
                    ->scalarNode("port")->defaultValue(8125)->end()
                    ->scalarNode("host")->defaultValue("localhost")->end()
                    ->scalarNode("reduce_packet")->defaultValue(true)->end()
                    ->scalarNode("protocol")->defaultValue("udp")->end()
                    ->scalarNode("fail_silently")->defaultValue(true)->end()
                ->end()
            ->end()
            ->arrayNode('collectors')->canBeUnset()
                ->prototype('scalar')->end()
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
