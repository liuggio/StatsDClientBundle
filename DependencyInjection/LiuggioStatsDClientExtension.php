<?php

namespace Liuggio\StatsDClientBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link https://symfony.com/doc/current/bundles/extension.html}
 */
class LiuggioStatsDClientExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration($container->getParameter('kernel.debug'));
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter($this->getAlias().'.connection.reduce_packet', $config['connection']['reduce_packet']);
        $container->setParameter($this->getAlias().'.connection.fail_silently', $config['connection']['fail_silently']);
        $container->setParameter($this->getAlias().'.enable_collector', $config['enable_collector']);
        $container->setParameter($this->getAlias().'.collectors', $config['collectors']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($config['enable_collector']) {
            $loader->load('collectors.yml');

            if (\count($config['collectors'])) {
                // Define the Listener
                $definition = new Definition('Liuggio\StatsDClientBundle\Listener\StatsDCollectorListener',
                    [new Reference('liuggio_stats_d_client.collector.service')]
                );
                $definition->addTag('kernel.event_subscriber');
                $container->setDefinition('liuggio_stats_d_client.collector.listener', $definition);
            }
        }
        // monolog
        if (!empty($config['monolog']) && $config['monolog']['enable']) {
            $this->loadMonologHandler($config, $container);
        }

        // Define the sender
        $senderService = new Definition($config['connection']['class']);
        $senderService->setArguments($config['connection']['arguments']);
        $container->setDefinition('liuggio_stats_d_client.sender.service', $senderService);
    }

    private function convertLevelToConstant($level)
    {
        return \is_int($level) ? $level : \constant('Monolog\Logger::'.\strtoupper($level));
    }

    /**
     * Loads the Monolog configuration.
     *
     * @param array            $config    A configuration array
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function loadMonologHandler(array $config, ContainerBuilder $container)
    {
        $def2 = new Definition($config['monolog']['formatter']['class'], [
                $config['monolog']['formatter']['format'],
                $config['monolog']['formatter']['context_logging'],
                $config['monolog']['formatter']['extra_logging'],
                $config['monolog']['formatter']['words'],
            ]
        );
        $container->setDefinition('monolog.formatter.statsd', $def2);

        $def = new Definition('Liuggio\StatsdClient\Monolog\Handler\StatsDHandler', [
            new Reference('liuggio_stats_d_client.service'),
            new Reference('liuggio_stats_d_client.factory'),
            $config['monolog']['prefix'],
            $this->convertLevelToConstant($config['monolog']['level']),
        ]);
        $def->setPublic(false);
        $def->addMethodCall('setFormatter', [new Reference('monolog.formatter.statsd')]);

        $container->setDefinition('monolog.handler.statsd', $def);
    }
}
