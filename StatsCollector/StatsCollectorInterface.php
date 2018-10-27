<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface StatsCollectorInterface
{
    /**
     * this function return an array of StatData Entity.
     *
     * @abstract
     */
    public function getStatsData();

    /**
     * Collects data for the given Response.
     *
     * @abstract
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An exception instance if the request threw one
     *
     * @return bool
     */
    public function collect(Request $request, Response $response, \Exception $exception = null);
}
