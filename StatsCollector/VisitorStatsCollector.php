<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorStatsCollector extends StatsCollector
{
    /**
     * Collects data for the given Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An exception instance if the request threw one
     *
     * @return Boolean
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $statData = $this->getStatsdDataFactory()->increment($this->getStatsDataKey());
        $this->addStatsData($statData);
        return true;
    }


}
