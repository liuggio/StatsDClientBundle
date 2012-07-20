<?php

namespace Liuggio\StatsDClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Bridge\Doctrine\DependencyInjection\AbstractDoctrineExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class LiuggioStatsDClientExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['connection'] as $k => $v) {
            $container->setParameter($this->getAlias() . '.connection.' . $k, $v);
        }

        $container->setParameter($this->getAlias() . '.enable_collector', $config['enable_collector']);
        $container->setParameter($this->getAlias() . '.collectors', $config['collectors']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('collectors.yml');

        if ($config['enable_collector'] && count($config['collectors'])) {

            // Define the Listener
            $definition = new Definition('%liuggio_stats_d_client.collector.listener.class%',
                array(new Reference('liuggio_stats_d_client.collector.service'))
            );
            $definition->addTag('kernel.event_subscriber');
            $container->setDefinition('liuggio_stats_d_client.collector.listener', $definition);
        }
    }
}
