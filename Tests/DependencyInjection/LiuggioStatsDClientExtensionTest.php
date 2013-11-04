<?php

namespace Liuggio\StatsDClientBundle\Tests\DependencyInjection;

use Liuggio\StatsDClientBundle\DependencyInjection\Compiler\DataCollectorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Liuggio\StatsDClientBundle\DependencyInjection\LiuggioStatsDClientExtension;
use Symfony\Component\DependencyInjection\Reference;

class LiuggioStatsDClientExtensionTest extends \PHPUnit_Framework_TestCase
{

    public function testLoad()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.debug', false);
        $loader = new LiuggioStatsDClientExtension();
        $config = $this->getConfig();
        $loader->load(array($config), $container);
        $compilerPass = new DataCollectorCompilerPass();
        $compilerPass->process($container);

        //testing parameter
        $this->assertEquals('localhost', $container->getParameter('liuggio_stats_d_client.connection.host'));
        $this->assertEquals('100', $container->getParameter('liuggio_stats_d_client.connection.port'));
        $this->assertEquals(true, $container->getParameter('liuggio_stats_d_client.connection.fail_silently'));
        $this->assertEquals(
            array(
                'tv.vision.{query_table}.query' => new Reference('liuggio_stats_d_client.collector.doctrine'),
                'tv.{request_route}.{query_table}.query' => new Reference('liuggio_stats_d_client.collector.doctrine'),
                'tv.time' => new Reference('liuggio_stats_d_client.collector.time'),
            ),
            $container
                ->getDefinition('liuggio_stats_d_client.data_collector')
                ->getArgument(0)
        );
    }

    protected function getConfig()
    {
        return array(
            'connection' => array(
                'host' => 'localhost',
                'port' => 100,
                'fail_silently' => true
            ),
            'metrics_enabled' => true,
            'metrics' => array(
                'tv.vision.{query_table}.query' => 'doctrine',
                'tv.{request_route}.{query_table}.query' => 'doctrine',
                'tv.time' => 'time',
            ),
            'monolog' => array(
                'prefix' => 'log',
                'formatter' => array(),
                'level' => 'warning'
            )
        );
    }

}
