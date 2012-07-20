<?php

namespace Liuggio\StatsDClientBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Liuggio\StatsDClientBundle\DependencyInjection\LiuggioStatsDClientExtension;

class LiuggioStatsDClientExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Liuggio\StatsDClientBundle\LiuggioStatsDClientBundle
     * @covers Liuggio\StatsDClientBundle\LiuggioStatsDClientExtension::load
     * @covers Liuggio\StatsDClientBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $loader = new LiuggioStatsDClientExtension();
        $config = $this->getConfig();
        $loader->load(array($config), $container);
        $this->markTestSkipped('-');
        //$this->assertEquals(array('web', 'tablet', 'mobile'), $container->getParameter(''));
        //$this->assertEquals('tablet', $container->getParameter(''));
    }

    protected function getConfig()
    {
        return array(
            'enable_collector' => true,
            'connection' => array('host'=>'localhost', 'port'=>100, 'fail_silently'=>true),
            'collectors' => array(),
        );
    }

}
