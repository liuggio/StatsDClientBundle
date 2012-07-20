<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorStatsCollector extends StatsCollector
{
    private static $counter = 0;

    public function getName()
    {
        return 'VisitorCollector';
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
        if (self::$counter != 0) {
            return false;
        }
        $statData = $this->getStatsDataFactory()->createStatsDataIncrement($this->getStatsDataKey());
        $this->addStatsData($statData);
        self::$counter++;
        return true;
    }


}
