<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Liuggio\StatsDClientBundle\StatsCollector\DbalStatsCollector;

class DbalStatsCollectorTest extends StatsCollectorBase
{
    public function testCollect()
    {
        $c = new DbalStatsCollector('prefix', $this->mockStatsDFactory('prefix.select', 'increment'));
        $c->startQuery('select * from liuggio where me in (Rome)');
    }
}
