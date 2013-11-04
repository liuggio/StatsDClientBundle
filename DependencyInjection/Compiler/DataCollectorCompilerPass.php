<?php

namespace Liuggio\StatsDClientBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class DataCollectorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->getParameter('liuggio_stats_d_client.metrics_enabled')) {
            return;
        }

        $dataCollectorDefinition = $container->getDefinition('liuggio_stats_d_client.data_collector');

        $collectorsIds = array();
        foreach ($container->findTaggedServiceIds('liuggio_stats_d_client.collector') as $id => $attributes) {
            $alias = isset($attributes[0]['alias']) ? $attributes[0]['alias'] : null;
            if (null === $alias) {
                throw new \RuntimeException(
                    sprintf('Service %s liuggio_stats_d_client.data_collector tag should have an alias attribute', $id)
                );
            }

            $collectorsIds[$alias] = $id;
            $container->getDefinition($id)->setAbstract(true);
        }

        $collectorsReferences = array();
        $metrics = $container->getParameter('liuggio_stats_d_client.metrics');
        foreach ($metrics as $metric => $collectorAlias) {
            if (!isset($collectorsIds[$collectorAlias])) {
                throw new \RuntimeException(
                    sprintf('Collector %s does not exist. (Metric "%s")', $collectorAlias, $metric)
                );
            }

            $collectorId = $collectorsIds[$collectorAlias];
            $container->getDefinition($collectorId)->setAbstract(false);
            $collectorsReferences[$metric] = new Reference($collectorId);
        }
        $dataCollectorDefinition->replaceArgument(0, $collectorsReferences);

        $providerReferences = array();
        foreach ($container->findTaggedServiceIds('liuggio_stats_d_client.provider') as $id => $attributes) {
            $providerReferences[] = new Reference($id);
        }
        $dataCollectorDefinition->replaceArgument(1, $providerReferences);

        // handle collectors that requires specific setup
        if ($container->hasDefinition('doctrine.dbal.logger.chain')
            && !$container->getDefinition('liuggio_stats_d_client.collector.doctrine')->isAbstract()
        ) {
            $container
                ->getDefinition('doctrine.dbal.logger.chain')
                ->addMethodCall('addLogger', array(new Reference('liuggio_stats_d_client.collector.doctrine')))
            ;
        }
        if (!$container->getDefinition('liuggio_stats_d_client.collector.solarium')->isAbstract()) {
            foreach ($container->getDefinitions() as $definitionId => $definition) {
                if (!preg_match('/^solarium.client.[^.]+$/', $definitionId)) {
                    continue;
                }

                $definition
                    ->addMethodCall(
                        'registerPlugin',
                        array(
                            'liuggio_stats_d_client',
                            new Reference('liuggio_stats_d_client.collector.solarium')
                        )
                    )
                ;
            }
        }
    }
}
