<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MemoryStatsCollector extends StatsCollector
{
    /*
    * calculate the peak used by php
    * @return int
    */
    private function getMemoryUsage()
    {
        return memory_get_peak_usage(true);
    }

    /**
     * Collects data for the given Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An exception instance if the request threw one
     *
     * @return boolean
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $statData = $this->getStatsdDataFactory()->gauge($this->getStatsDataKey(), $this->getMemoryUsage());
        $this->addStatsData($statData);

        return true;
    }


}
