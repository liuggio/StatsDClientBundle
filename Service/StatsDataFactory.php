<?php

namespace Liuggio\StatsDClientBundle\Service;

use Liuggio\StatsDClientBundle\Entity\StatsData;
use Liuggio\StatsDClientBundle\Model\StatsDataInterface;

class StatsDataFactory
{
    /**
     * @var \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     */
    private $entityClass;

    public function __construct($entity_class)
    {
        $this->setEntityClass($entity_class);
    }

    /**
     * Log timing information
     *
     * @param string $stats The metric to in log timing info for.
     * @param float $time The ellapsed time (ms) to log
     *
     * @return \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     * */
    public function createStatsDataTiming($key, $time)
    {
        $value = sprintf('%f|ms', $time);
        $StatsData = $this->createStatsData($key, $value);
        return $StatsData;
    }


    /**
     * Increments one or more stats counters
     *
     * @param string|array $stats The metric(s) to increment.
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     * @return boolean
     *
     * @return \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     * */
    public function createStatsDataIncrement($key)
    {
        return $this->createStatsDataUpdate($key, 1);
    }


    /**
     * Decrements one or more stats counters.
     *
     * @param string|array $stats The metric(s) to decrement.
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     *
     * @return \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     * */
    public function createStatsDataDecrement($key)
    {
        return $this->createStatsDataUpdate($key, -1);
    }


    /**
     * Updates one or more stats counters by arbitrary amounts.
     *
     * @param string|array $stats The metric(s) to update. Should be either a string or array of metrics.
     * @param int|1 $delta The amount to increment/decrement each metric by.
     *
     * @return \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     * */
    public function createStatsDataUpdate($key, $delta = 1)
    {
        $value = sprintf('%d|c', $delta);
        $StatsData = $this->createStatsData($key, $value);
        return $StatsData;
    }

    /**
     * Gauge
     *
     * @param string|array $stats The metric(s) to update. Should be either a string or array of metrics.
     * @param int|1 $value The amount to increment/decrement each metric by.
     *
     * @return \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     * */
    public function createStatsDataGauge($key, $value)
    {
        $value = sprintf('%d|g', $value);
        $StatsData = $this->createStatsData($key, $value);
        return $StatsData;
    }

    /**
     * @param \Liuggio\StatsDClientBundle\Model\StatsDataInterface $entityClass
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @return \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @return \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     */
    public function createStatsData($key = null, $val = null)
    {
        $StatsData = $this->getEntityClass();
        $StatsData = new $StatsData();

        if (null !== $key) {
            $StatsData->setKey($key);
        }

        if (null !== $val) {
            $StatsData->setValue($val);
        }
        return $StatsData;
    }
}
