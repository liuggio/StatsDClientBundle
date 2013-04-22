<?php

namespace Liuggio\StatsDClientBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Liuggio\StatsDClientBundle\DependencyInjection\LiuggioStatsDClientExtension;

class LiuggioStatsDClientExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Liuggio\StatsDClientBundle\LiuggioStatsDClientBundle
     * @covers Liuggio\StatsDClientBundle\DependencyInjection\LiuggioStatsDClientExtension::load
     * @covers Liuggio\StatsDClientBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.debug', false);
        $loader = new LiuggioStatsDClientExtension();
        $config = $this->getConfig();
        $loader->load(array($config), $container);
        //testing parameter
        $this->assertEquals('localhost', $container->getParameter('liuggio_stats_d_client.connection.host'));
        $this->assertEquals('100', $container->getParameter('liuggio_stats_d_client.connection.port'));
        $this->assertEquals(true, $container->getParameter('liuggio_stats_d_client.connection.fail_silently'));
        $this->assertEquals(true, $container->getParameter('liuggio_stats_d_client.enable_collector'));
        $this->assertEquals(array('liuggio_stats_d_client.collector.dbal' => 'tv.vision.query'), $container->getParameter('liuggio_stats_d_client.collectors'));

        //we test that the kernel_event is attached to the service if collector is enabled
        $a = $container->getDefinition('liuggio_stats_d_client.collector.listener');
        $this->assertNotNull($a);
        $this->assertEquals($a->hasTag('kernel.event_subscriber'), $container->getParameter('liuggio_stats_d_client.enable_collector'));
    }

    protected function getConfig()
    {
        return array(
            'enable_collector' => true,
            'connection' => array(
                'host' => 'localhost',
                'port' => 100,
                'fail_silently' => true
            ),
            'collectors' => array('liuggio_stats_d_client.collector.dbal' => 'tv.vision.query'),
            'monolog' => array(
                'enable' => true,
                'prefix' => 'log',
                'formatter' => array(),
                'level' => 'warning')
        );
    }

}
