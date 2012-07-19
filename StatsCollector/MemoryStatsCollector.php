<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MemoryStatsCollector extends StatsCollector
{
    private static $counter = 0;

    public function getName() {
        return 'MemoryCollector';
    }
    /*
    * calculate the peak used by php
    * @return int
    */
    private function getMemoryUsage()
    {
        return memory_get_peak_usage();
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
        // check the number times of execution.
        // eg. with `render` in twig happens that this func is called more times.
        if (self::$counter != 0){
            return false;
        }

        $statData = $this->getStatsDataFactory()->createStatsDataGauge($this->getStatsDataKey(), $this->getMemoryUsage());
        $this->addStatsData($statData);

        self::$counter++;
        return true;
    }


}
