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
     * @var \Liuggio\StatsDClientBundle\Service\StatsDataFactory
     */
    protected $statsDataFactory;
    /**
     * @var boolean
     */
    protected $onlyOnMasterResponse;



    public function __construct($stat_key = __CLASS__, StatsDataFactory $stats_data_factory = null, $only_on_master_response = false)
    {
        $this->setStatsDataKey($stat_key);
        $this->statsDataFactory = $stats_data_factory;
        $this->setOnlyOnMasterResponse($only_on_master_response);
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
     * @param \Liuggio\StatsDClientBundle\Model\StatsDataInterface $statsData
     * @return mixed
     */
    public function addStatsData(\Liuggio\StatsDClientBundle\Model\StatsDataInterface $statsData)
    {
        $this->statsData[] = $statsData;
    }

    /**
     * @param string $key
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
     * @param \Liuggio\StatsDClientBundle\Service\StatsDataFactory $statsDataFactory
     */
    public function setStatsDataFactory(StatsDataFactory $statsDataFactory)
    {
        $this->statsDataFactory = $statsDataFactory;
    }

    /**
     * @return \Liuggio\StatsDClientBundle\Service\StatsDataFactory
     */
    public function getStatsDataFactory()
    {
        return $this->statsDataFactory;
    }
    /**
     * @param boolean $onlyOnMasterResponse
     */
    public function setOnlyOnMasterResponse($onlyOnMasterResponse)
    {
        $this->onlyOnMasterResponse = $onlyOnMasterResponse;
    }

    /**
     * @return boolean
     */
    public function getOnlyOnMasterResponse()
    {
        return $this->onlyOnMasterResponse;
    }
}
