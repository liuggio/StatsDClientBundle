<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Liuggio\StatsDClientBundle\StatsCollector\StatsCollector;

use Liuggio\StatsDClientBundle\StatsCollector\VisitorStatsCollector;
use Liuggio\StatsDClientBundle\Model\StatsDataInterface;

class VisitorStatsCollectorTest extends WebTestCase
{
    public function mockStatsDFactory($compare)
    {
        $phpunit = $this;
        $statsDFactory = $this->getMockBuilder('\Liuggio\StatsdClient\Factory\StatsdDataFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('increment'))
            ->getMock();

        $dataMock = $this->getMock('\Liuggio\StatsdClient\Entity\StatsdDataInterface');

        $statsDFactory->expects($this->any())
            ->method('increment')
            ->will($this->returnCallback(function ($input) use ($phpunit, $compare, $dataMock) {
                $phpunit->assertEquals($compare, $input);
            return $dataMock;
        }));
        return $statsDFactory;
    }

    public function testCollect()
    {
        $c = new VisitorStatsCollector('prefix', $this->mockStatsDFactory('prefix'));
        $c->collect(new Request(), new Response(), null);
    }
}
