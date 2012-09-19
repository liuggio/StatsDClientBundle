<?php

namespace Liuggio\StatsDClientBundle\Entity;

use  Liuggio\StatsDClientBundle\Model\StatsDataInterface;

/**
 *
 */
class StatsData implements StatsDataInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var integer
     */
    private $value;

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getMessage()
    {
        return sprintf('%s:%s', $this->getKey(), $this->getValue());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getMessage();
    }
}
