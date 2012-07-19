<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Liuggio\StatsDClientBundle\Service\StatsDataFactory;

abstract class StatsCollector implements StatsCollectorInterface
{
    /**
     * @var string
     */
    protected $statsDataKey;
    /**
     * @var array of \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     */
    protected $statsData;
    /**
     * @var Liuggio\StatsDClientBundle\Service\StatsDataFactory
     */
    protected $statsDataFactory;

    public function __construct($stat_key = __CLASS__, StatsDataFactory $stats_data_factory = null) {

        $this->setStatsDataKey($stat_key);
        $this->statsDataFactory = $stats_data_factory;
    }

    public function getName() {
        return 'abstractCollector';
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
        return true;
    }

    /**
     * @return mixed
     */
    public function getStatsData()
    {
        if (null === $this->statsData) {
            return array();
        }
        return $this->statsData;
    }
    /**
     *
     * @return mixed
     */
    public function addStatsData(\Liuggio\StatsDClientBundle\Model\StatsDataInterface $statsData)
    {
        $this->statsData[] = $statsData;
    }

    /**
     *
     * @param string $stat
     */
    public function setStatsDataKey($key)
    {
        $this->statsDataKey = $key;
    }

    /**
     * @return string
     */
    public function getStatsDataKey()
    {
        return $this->statsDataKey;
    }

    /**
     * @param \Liuggio\StatsDClientBundle\StatCollector\Liuggio\StatsDClientBundle\Service\StatsDataFactory $statsDataFactory
     */
    public function setStatsDataFactory(StatsDataFactory $statsDataFactory)
    {
        $this->statsDataFactory = $statsDataFactory;
    }

    /**
     * @return \Liuggio\StatsDClientBundle\StatCollector\Liuggio\StatsDClientBundle\Service\StatsDataFactory
     */
    public function getStatsDataFactory()
    {
        return $this->statsDataFactory;
    }

}
