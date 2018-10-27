<?php

namespace Liuggio\StatsDClientBundle\Tests\DependencyInjection;

use Liuggio\StatsDClientBundle\DependencyInjection\LiuggioStatsDClientExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LiuggioStatsDClientExtensionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \Liuggio\StatsDClientBundle\LiuggioStatsDClientBundle
     * @covers \Liuggio\StatsDClientBundle\DependencyInjection\LiuggioStatsDClientExtension::load
     * @covers \Liuggio\StatsDClientBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.debug', false);
        $loader = new LiuggioStatsDClientExtension();
        $config = $this->getConfig();
        $loader->load([$config], $container);
        //testing parameter
        $this->assertEquals('localhost', $container->getParameter('liuggio_stats_d_client.connection.host'));
        $this->assertEquals('100', $container->getParameter('liuggio_stats_d_client.connection.port'));
        $this->assertTrue($container->getParameter('liuggio_stats_d_client.connection.fail_silently'));
        $this->assertTrue($container->getParameter('liuggio_stats_d_client.enable_collector'));
        $this->assertEquals(['liuggio_stats_d_client.collector.dbal' => 'tv.vision.query'], $container->getParameter('liuggio_stats_d_client.collectors'));

        //we test that the kernel_event is attached to the service if collector is enabled
        $a = $container->getDefinition('liuggio_stats_d_client.collector.listener');
        $this->assertNotNull($a);
        $this->assertEquals($a->hasTag('kernel.event_subscriber'), $container->getParameter('liuggio_stats_d_client.enable_collector'));
    }

    protected function getConfig()
    {
        return [
            'enable_collector' => true,
            'connection' => [
                'host' => 'localhost',
                'port' => 100,
                'fail_silently' => true,
            ],
            'collectors' => ['liuggio_stats_d_client.collector.dbal' => 'tv.vision.query'],
            'monolog' => [
                'enable' => true,
                'prefix' => 'log',
                'formatter' => [],
                'level' => 'warning', ],
        ];
    }
}
