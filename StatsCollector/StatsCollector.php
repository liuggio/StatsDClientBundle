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
     * @var Boolean
     */
    protected $onlyOnMasterResponse;


    public function __construct($stat_key = __CLASS__, StatsdDataFactoryInterface $stats_data_factory = null, $only_on_master_response = false)
    {
        $this->setStatsDataKey($stat_key);
        $this->statsdDataFactory = $stats_data_factory;
        $this->setOnlyOnMasterResponse($only_on_master_response);
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
     * @param \Liuggio\StatsdClient\Entity\StatsdDataInterface $statsData
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
        $this->statsdDataFactory = $StatsdDataFactory;
    }

    /**
     * @return \Liuggio\StatsdClient\Factory\StatsdDataFactory
     */
    public function getStatsdDataFactory()
    {
        return $this->statsdDataFactory;
    }

    /**
     * @param Boolean $onlyOnMasterResponse
     */
    public function setOnlyOnMasterResponse($onlyOnMasterResponse)
    {
        $this->onlyOnMasterResponse = $onlyOnMasterResponse;
    }

    /**
     * @return Boolean
     */
    public function getOnlyOnMasterResponse()
    {
        return $this->onlyOnMasterResponse;
    }

    /**
     * Extract the first word, its maximum lenght is limited to $maxLenght chars.
     *
     * @param  string $string
     *
     * @return mixed
     */
    protected function extractFirstWord($string, $maxLength = 25)
    {
        $string = str_replace(array('"', "'"), "", $string);
        $string = trim($string);
        $length = (strlen($string) > $maxLength) ? $maxLength : strlen($string);
        $string = strtolower(strstr(substr(trim($string), 0, $length), ' ', true));

        return $string;
    }
}
