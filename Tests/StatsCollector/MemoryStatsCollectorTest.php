<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use Liuggio\StatsDClientBundle\StatsCollector\StatsCollector;

use Liuggio\StatsDClientBundle\StatsCollector\MemoryStatsCollector;
use Liuggio\StatsDClientBundle\Model\StatsDataInterface;

class MemoryStatsCollectorTest extends WebTestCase
{
    public function mockStatsDFactory($compare)
    {
        $phpunit = $this;
        $statsDFactory = $this->getMockBuilder('Liuggio\StatsDClientBundle\Service\StatsDataFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('createStatsDataGauge'))
            ->getMock();

        $dataMock = $this->getMock('Liuggio\StatsDClientBundle\Model\StatsDataInterface');

        $statsDFactory->expects($this->any())
            ->method('createStatsDataGauge')
            ->will($this->returnCallback(function ($input, $value) use ($phpunit, $compare, $dataMock) {
                $phpunit->assertInternalType('integer',$value);
                $phpunit->assertEquals($compare, $input);
            return $dataMock;
        }));
        return $statsDFactory;
    }

    public function testCollect()
    {
        $c = new MemoryStatsCollector('prefix', $this->mockStatsDFactory('prefix'));

        $c->collect(new Request(), new Response(), null);
    }
}
