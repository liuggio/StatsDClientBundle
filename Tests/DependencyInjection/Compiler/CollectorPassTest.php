<?php

namespace Liuggio\StatsDClientBundle\Tests\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Liuggio\StatsDClientBundle\DependencyInjection\Compiler\CollectorPass;

class CollectorPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Liuggio\StatsDClientBundle\DependencyInjection\Compiler\CollectorPass::process
     */
    public function testProcess()
    {

        $this->markTestSkipped('CollectorPassTest');

        $containerMock = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');

        // @todo
        $this->markTestSkipped('-');

    }
}
