<?php

namespace Liuggio\StatsDClientBundle\Monolog\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Formatter\FormatterInterface;

/**
 * A processing handler for Monolog
 */
class StatsDHandler extends AbstractProcessingHandler
{
    /**
     * @var bool
     */
    protected $contextLogging = false;

    /**
     * @param boolean $contextLogging
     */
    public function setContextLogging($contextLogging)
    {
        $this->contextLogging = $contextLogging;
    }

    /**
     * @return boolean
     */
    public function getContextLogging()
    {
        return $this->contextLogging;
    }

    /**
     * @var array
     */
    protected $buffer = array();

    /**
     * @param array $buffer
     */
    public function setBuffer($buffer)
    {
        $this->buffer = $buffer;
    }

    /**
     * @return array
     */
    public function getBuffer()
    {
        return $this->buffer;
    }

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @var statsDService
     */
    protected $statsDService;

    /**
     * @var statsDFactory
     */
    protected $statsDFactory;

    /**
     * @param  $statsDService
     */
    public function setStatsDService($statsDService)
    {
        $this->statsDService = $statsDService;
    }

    /**
     * @param $statsDFactory
     */
    public function setStatsDFactory($statsDFactory)
    {
        $this->statsDFactory = $statsDFactory;
    }

    /**
     * @param $str
     * @return mixed
     */
    protected function toAscii($str)
    {
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        return $clean;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->statsDService->send($this->buffer);
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {


        $channelKey = sprintf("%s.%s", $this->getPrefix(), $this->toAscii($record['channel']));
        $levelKey = sprintf("%s.%s", $channelKey, $this->toAscii($record['level_name']));

        if ($record['formatted']) {
            $messageKey = sprintf("%s.%s", $levelKey, $this->toAscii($record['formatted']));
            $this->buffer[] = $this->statsDFactory->increment($messageKey);
        }
        $this->buffer[] = $this->statsDFactory->increment($levelKey);

        if ($this->getContextLogging()) {
            foreach ($record['context'] as $key => $parameter) {
                $contextKey = sprintf("%s.context.%s.%s", $levelKey, $this->toAscii($key), $this->toAscii($parameter));
                $this->buffer[] = $this->statsDFactory->increment($contextKey);
            }
        }

    }
}
