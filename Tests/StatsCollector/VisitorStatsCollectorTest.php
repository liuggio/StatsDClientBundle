<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Liuggio\StatsDClientBundle\StatsCollector\VisitorStatsCollector;

class VisitorStatsCollectorTest extends StatsCollectorBase
{
    public function testCollect()
    {
        $c = new VisitorStatsCollector('prefix', $this->mockStatsDFactory('prefix'));
        $c->collect(new Request(), new Response(), null);
    }
}
