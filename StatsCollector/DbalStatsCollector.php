<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Logging\SQLLogger;

class DbalStatsCollector extends StatsCollector implements SQLLogger, StatsCollectorInterface
{
    /**
     * try to extract the sql verbs.
     * @param $sql
     * @return mixed
     */
    public function extractVerbsFromSql($sql)
    {
        $string = strtolower(strstr(trim($sql), ' ', true));
        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {

        $verb = $this->extractVerbsFromSql($sql);
        if (null === $verb) {
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
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        return true;
    }


}
