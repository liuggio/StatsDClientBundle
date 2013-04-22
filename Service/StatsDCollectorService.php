<?php

namespace Liuggio\StatsDClientBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Liuggio\StatsDClientBundle\StatsCollector\StatsCollectorInterface;
use Liuggio\StatsdClient\StatsdClientInterface;

/**
 * StatsDCollectorService.
 *
 * @author <liuggio@gmail.com>
 */
class StatsDCollectorService
{
    private $collectors;
    private $statsDClient;

    /**
     * Constructor.
     */
    public function __construct(StatsdClientInterface $stats_d_client)
    {
        $this->collectors = array();
        $this->statsDClient = $stats_d_client;
    }

    /**
     * Collects data for the given Response.
     *
     * @param Boolean     $isMasterRequest
     * @param Request     $request   A Request instance
     * @param Response    $response  A Response instance
     * @param \Exception  $exception An exception instance if the request threw one
     *
     * @return array
     */
    public function collect($isMasterRequest, Request $request, Response $response, \Exception $exception = null)
    {
        $statSData = array();
        foreach ($this->collectors as $collector) {

            if ($collector->getOnlyOnMasterResponse() && !$isMasterRequest) {
                continue;
            }

            $collector->collect($request, $response, $exception);
            $statSData = array_merge($statSData, $collector->getStatsData());
        }
        return $statSData;
    }

    /**
     * Gets the Collectors associated with this profiler.
     *
     * @return array An array of collectors
     */
    public function all()
    {
        return $this->collectors;
    }

    /**
     * Sets the Collectors associated with this profiler.
     *
     * @param array $collectors An array of collectors
     */
    public function set(array $collectors = array())
    {
        $this->collectors = array();
        foreach ($collectors as $collector) {
            $this->add($collector);
        }
    }

    /**
     * Adds a Collector.
     *
     * @param StatsCollectorInterface $collector A StatsCollectorInterface instance
     */
    public function add(StatsCollectorInterface $collector)
    {
        $this->collectors[$collector->getStatsDataKey()] = $collector;
    }

    /**
     * Returns true if a Collector for the given name exists.
     *
     * @param string $name A collector name
     *
     * @return Boolean
     */
    public function has($name)
    {
        return isset($this->collectors[$name]);
    }

    /**
     * Gets a Collector by name.
     *
     * @param string $name A collector name
     *
     * @return StatsCollectorInterface A StatsCollectorInterface instance
     *
     * @throws \InvalidArgumentException if the collector does not exist
     */
    public function get($name)
    {
        if (!isset($this->collectors[$name])) {
            throw new \InvalidArgumentException(sprintf('Collector "%s" does not exist.', $name));
        }

        return $this->collectors[$name];
    }

    /**
     * Send to StatD all the data collected
     *
     * @param mixed $data An array of StatData
     */
    public function send($data)
    {
        return $this->statsDClient->send($data);
    }
}
