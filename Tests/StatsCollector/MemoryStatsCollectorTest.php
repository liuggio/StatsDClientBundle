<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Liuggio\StatsDClientBundle\StatsCollector\MemoryStatsCollector;

class MemoryStatsCollectorTest extends StatsCollectorBase
{

    public function testCollect()
    {
        $c = new MemoryStatsCollector('prefix', $this->mockStatsDFactory('prefix', 'gauge'));

        $c->collect(new Request(), new Response(), null);
    }
}
