<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Liuggio\StatsDClientBundle\StatsCollector\ExceptionStatsCollector;
use Liuggio\StatsDClientBundle\StatsCollector\StatsCollector;

use Symfony\Component\HttpKernel\DataCollector\ExceptionDataCollector;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Liuggio\StatsDClientBundle\Model\StatsDataInterface;

class ExceptionStatsCollectorTest extends WebTestCase
{
    public function mockStatsDFactory($compare)
    {
        $phpunit = $this;
        $statsDFactory = $this->getMockBuilder('Liuggio\StatsDClientBundle\Service\StatsDataFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('createStatsDataIncrement'))
            ->getMock();

        $dataMock = $this->getMock('Liuggio\StatsDClientBundle\Model\StatsDataInterface');

        $statsDFactory->expects($this->any())
            ->method('createStatsDataIncrement')
            ->will($this->returnCallback(function ($input) use ($phpunit, $compare, $dataMock) {
            $phpunit->assertEquals($compare, $input);
            return $dataMock;
        }));
        return $statsDFactory;
    }

    public function testCollect()
    {
        $e = new \Exception('foo', 500);
        $c = new ExceptionStatsCollector('prefix', $this->mockStatsDFactory('prefix.exception'));
        $flattened = FlattenException::create($e);
        $trace = $flattened->getTrace();

        $c->collect(new Request(), new Response(), $e);
    }
}
