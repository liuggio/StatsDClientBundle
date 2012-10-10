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
     * @param string $key The metric to in log timing info for.
     * @param float $time The elapsed time (ms) to log
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
     * @param string|array $key The metric(s) to increment.
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
     * @param string|array $key The metric(s) to decrement.
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
     * @param string|array $key The metric(s) to update. Should be either a string or array of metrics.
     * @param int $delta The amount to increment/decrement each metric by, 1 by default.
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
     * @param string|array $key The metric(s) to update. Should be either a string or array of metrics.
     * @param int $value The amount to increment/decrement each metric by, 1 by default.
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
     * @param string|array $key The metric(s) to create data for.
     * @param int $value The value of the metric.
     * @return \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     */
    public function createStatsData($key = null, $value = null)
    {
        $StatsData = $this->getEntityClass();
        $StatsData = new $StatsData();

        if (null !== $key) {
            $StatsData->setKey($key);
        }

        if (null !== $value) {
            $StatsData->setValue($value);
        }
        return $StatsData;
    }

    /**
     * @param $stats_data
     * @param null $sampleValue
     * @return \Liuggio\StatsDClientBundle\Model\StatsDataInterface
     */
    public function addSampling(StatsDataInterface $stats_data, $sampleValue = null)
    {

        if (null === $sampleValue) {
            return $stats_data;
        }
        $newValue = sprintf('%s|@%.2f', $stats_data->getValue(), $sampleValue);
        $stats_data->setValue($newValue);
        return $stats_data;
    }
}
