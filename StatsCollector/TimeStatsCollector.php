<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Liuggio\StatsdClient\Factory\StatsdDataFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TimeStatsCollector extends StatsCollector
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
        $startTime = $request->server->get('REQUEST_TIME_FLOAT', $request->server->get('REQUEST_TIME'));

        $time = microtime(true) - $startTime;
        $time = round($time * 1000);

        $statData = $this->getStatsdDataFactory()->timing($this->getStatsDataKey(), $time);
        $this->addStatsData($statData);

        return true;
    }


}
