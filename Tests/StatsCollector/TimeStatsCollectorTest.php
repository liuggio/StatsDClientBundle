<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Liuggio\StatsDClientBundle\StatsCollector\TimeStatsCollector;

class TimeStatsCollectorTest extends StatsCollectorBase
{
    public function testCollect()
    {
        $c = new TimeStatsCollector('prefix', $this->mockStatsDFactory('prefix', 'timing'));

        $c->collect(new Request(), new Response(), null);
    }
}
