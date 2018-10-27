<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Doctrine\DBAL\Logging\SQLLogger;

class DbalStatsCollector extends StatsCollector implements SQLLogger, StatsCollectorInterface
{
    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $verb = $this->extractFirstWord($sql);
        if (empty($verb)) {
            return;
        }
        $key = \sprintf('%s.%s', $this->getStatsDataKey(), $verb);
        if (null === $this->getStatsdDataFactory()) {
            return;
        }
        $statData = $this->getStatsdDataFactory()->increment($key);
        $this->addStatsData($statData);
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        return true;
    }
}
