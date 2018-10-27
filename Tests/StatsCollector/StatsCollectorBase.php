<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StatsCollectorBase extends WebTestCase
{
    protected function mockStatsDFactory($compare, $method = 'increment')
    {
        $phpunit = $this;
        $statsDFactory = $this->getMockBuilder('\Liuggio\StatsdClient\Factory\StatsdDataFactory')
            ->disableOriginalConstructor()
            ->setMethods([$method])
            ->getMock();

        $dataMock = $this->createMock('\Liuggio\StatsdClient\Entity\StatsdDataInterface');

        $statsDFactory->expects($this->any())
            ->method($method)
            ->with($compare)
            ->will($this->returnValue($dataMock));

        return $statsDFactory;
    }
}
