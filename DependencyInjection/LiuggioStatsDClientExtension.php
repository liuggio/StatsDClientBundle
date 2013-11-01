<?php

namespace Liuggio\StatsDClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class LiuggioStatsDClientExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration($container->getParameter('kernel.debug'));
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['connection'] as $k => $v) {
            $container->setParameter('liuggio_stats_d_client.connection.' . $k, $v);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        foreach (array('statsd.yml', 'collectors.yml', 'providers.yml', 'monolog.yml', 'event_listeners.yml') as $file) {
            $loader->load($file);
        }

        $container->setParameter('liuggio_stats_d_client.metrics_enabled', $config['metrics_enabled']);
        $container->setParameter('liuggio_stats_d_client.metrics', $config['metrics']);

        $this->configureMonologHandler($config, $container);

        // set the debug sender
        if ($config['connection']['debug']) {
            $container->setAlias('liuggio_stats_d_client.sender', 'liuggio_stats_d_client.sender.debug');
        }
    }

    /**
     * Loads the Monolog configuration.
     *
     * @param array            $config    A configuration array
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    private function configureMonologHandler(array $config, ContainerBuilder $container)
    {
        foreach ($config['monolog']['formatter'] as $key => $value) {
            $container->setParameter('liuggio_stats_d_client.monolog.formatter.' . $key, $value);
        }

        $container->setParameter('liuggio_stats_d_client.factory.prefix', $config['monolog']['prefix']);
        $container->setParameter(
            'liuggio_stats_d_client.factory.level',
            $this->convertLevelToConstant($config['monolog']['level'])
        );

        if ($config['monolog']['enabled']) {
            $container
                ->getDefinition('liuggio_stats_d_client.monolog.handler')
                ->setAbstract(false)
            ;
        }
    }

    private function convertLevelToConstant($level)
    {
        return is_int($level) ? $level : constant('Monolog\Logger::' . strtoupper($level));
    }
}
