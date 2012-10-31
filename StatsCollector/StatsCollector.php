<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Liuggio\StatsdClient\Factory\StatsdDataFactory;
use Liuggio\StatsdClient\Factory\StatsdDataFactoryInterface;
use Liuggio\StatsdClient\Entity\StatsdDataInterface;

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
     * @var \Liuggio\StatsdClient\Factory\StatsdDataFactoryInterface
     */
    protected $StatsdDataFactory;
    /**
     * @var boolean
     */
    protected $onlyOnMasterResponse;



    public function __construct($stat_key = __CLASS__, StatsdDataFactoryInterface $stats_data_factory = null, $only_on_master_response = false)
    {
        $this->setStatsDataKey($stat_key);
        $this->StatsdDataFactory = $stats_data_factory;
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
    public function addStatsData(StatsdDataInterface $statsData)
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
     * @param \Liuggio\StatsdClient\Factory\StatsdDataFactoryInterface $StatsdDataFactory
     */
    public function setStatsdDataFactory(StatsdDataFactoryInterface $StatsdDataFactory)
    {
        $this->StatsdDataFactory = $StatsdDataFactory;
    }

    /**
     * @return \Liuggio\StatsdClient\Factory\StatsdDataFactory
     */
    public function getStatsdDataFactory()
    {
        return $this->StatsdDataFactory;
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
