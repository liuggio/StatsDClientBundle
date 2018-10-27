<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Liuggio\StatsDClientBundle\StatsCollector\ExceptionStatsCollector;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionStatsCollectorTest extends StatsCollectorBase
{
    public function testCollect()
    {
        $e = new \Exception('foo', 500);
        $c = new ExceptionStatsCollector('prefix', $this->mockStatsDFactory('prefix.500'));
        $flattened = FlattenException::create($e);
        $trace = $flattened->getTrace();

        $c->collect(new Request(), new Response(), $e);
    }
}
