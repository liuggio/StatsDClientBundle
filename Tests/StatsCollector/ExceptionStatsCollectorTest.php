<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Liuggio\StatsDClientBundle\StatsCollector\ExceptionStatsCollector;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\ErrorHandler\Exception\FlattenException as ErrorFlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionStatsCollectorTest extends StatsCollectorBase
{
    public function testCollect()
    {
        $e = new \Exception('foo', 500);
        $c = new ExceptionStatsCollector('prefix', $this->mockStatsDFactory('prefix.500'));
        // Symfony >= 4.4 behaviour
        if(class_exists(ErrorFlattenException::class)) {
            $flattened = ErrorFlattenException::create($e);
        } else {
            $flattened = FlattenException::create($e);
        }
        $trace = $flattened->getTrace();

        $c->collect(new Request(), new Response(), $e);
    }
}
