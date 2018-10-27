<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Liuggio\StatsDClientBundle\StatsCollector\VisitorStatsCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorStatsCollectorTest extends StatsCollectorBase
{
    public function testCollect()
    {
        $c = new VisitorStatsCollector('prefix', $this->mockStatsDFactory('prefix'));
        $c->collect(new Request(), new Response(), null);
    }
}
