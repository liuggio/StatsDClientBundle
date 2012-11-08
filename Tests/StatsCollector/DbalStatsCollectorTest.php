<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Liuggio\StatsDClientBundle\StatsCollector\DbalStatsCollector;
use Liuggio\StatsDClientBundle\StatsCollector\StatsCollector;

use Liuggio\StatsDClientBundle\Model\StatsDataInterface;

class DbalStatsCollectorTest extends WebTestCase
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
        $c = new DbalStatsCollector('prefix', $this->mockStatsDFactory('prefix.select'));
        $c->startQuery('select * from liuggio where me in (Rome)');
    }
}
