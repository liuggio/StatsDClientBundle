<?php

namespace Liuggio\StatsDClientBundle\Service;

use Liuggio\StatsdClient\Entity\StatsdDataInterface;
use Liuggio\StatsdClient\Factory\StatsdDataFactoryInterface;
use Liuggio\StatsdClient\StatsdClient;
use Liuggio\StatsdClient\Entity\StatsdData;

/**
 * Simplifies access to StatsD client and factory, buffers all data.
 */
class StatsDService implements StatsdDataFactoryInterface
{
    /**
     * @var \Liuggio\StatsdClient\StatsdClient
     */
    protected $client;

    /**
     * @var \Liuggio\StatsdClient\Factory\StatsdDataFactoryInterface
     */
    protected $factory;

    /**
     * @var StatsdData[]
     */
    protected $buffer = array();

    /**
     * @param StatsdClient               $client
     * @param StatsdDataFactoryInterface $factory
     */
    public function __construct(StatsdClient $client, StatsdDataFactoryInterface $factory)
    {
        $this->client = $client;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function timing($key, $time)
    {
        array_push($this->buffer, $this->factory->timing($key, $time));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function gauge($key, $value)
    {
        array_push($this->buffer, $this->factory->gauge($key, $value));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        array_push($this->buffer, $this->factory->set($key, $value));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function increment($key)
    {
        array_push($this->buffer, $this->factory->increment($key));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function decrement($key)
    {
        array_push($this->buffer, $this->factory->decrement($key));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function updateCount($key, $delta)
    {
        array_push($this->buffer, $this->factory->updateCount($key, $delta));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function produceStatsdData($key, $value = 1, $metric = StatsdDataInterface::STATSD_METRIC_COUNT)
    {
        throw new \BadFunctionCallException('produceStatsdData is not implemented');
    }

    /**
     * Send all buffered data to statsd.
     *
     * @return $this
     */
    public function flush()
    {
        $this->client->send($this->buffer);
        $this->buffer = array();

        return $this;
    }
}
