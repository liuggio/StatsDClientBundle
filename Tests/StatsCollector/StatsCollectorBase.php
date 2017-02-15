<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Liuggio\StatsdClient\Entity\StatsdDataInterface;
use Liuggio\StatsdClient\Factory\StatsdDataFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class StatsCollectorBase extends WebTestCase
{
    public function mockStatsDFactory($compare, $method = 'increment')
    {
        $statsDFactory = $this->getMockBuilder(StatsdDataFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(array($method))
            ->getMock();

        $dataMock = $this->createMock(StatsdDataInterface::class);

        $statsDFactory->expects($this->any())
            ->method($method)
            ->with($compare)
            ->will($this->returnValue($dataMock));

        return $statsDFactory;
    }
}
