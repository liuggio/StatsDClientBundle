<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Liuggio\StatsdClient\Factory\StatsdDataFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TimeStatsCollector extends StatsCollector
{
    /**
     * startTime
     * 
     * @var float
     * @access private
     */
    private $startTime;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct($stat_key = __CLASS__, StatsdDataFactoryInterface $stats_data_factory = null, $only_on_master_response = false)
    {
        parent::__construct($stat_key, $stats_data_factory, $only_on_master_response);

        $this->startTime = microtime(true);
    }

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
        $time = microtime(true) - $this->startTime;
        $time = round($time * 1000);
        $statData = $this->getStatsdDataFactory()->timing($this->getStatsDataKey(), $time);
        $this->addStatsData($statData);

        return true;
    }


}
