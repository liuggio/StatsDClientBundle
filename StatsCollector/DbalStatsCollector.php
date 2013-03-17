<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Logging\SQLLogger;

class DbalStatsCollector extends StatsCollector implements SQLLogger, StatsCollectorInterface
{
    /**
     * {@inheritDoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $verb = $this->extractFirstWord($sql);
        if (empty($verb)) {
            return;
        }
        $key = sprintf('%s.%s', $this->getStatsDataKey(), $verb);
        if (null === $this->getStatsdDataFactory()) {
            return;
        }
        $statData = $this->getStatsdDataFactory()->increment($key);
        $this->addStatsData($statData);
    }

    /**
     * {@inheritDoc}
     */
    public function stopQuery()
    {
        return true;
    }


}
