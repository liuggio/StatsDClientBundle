<?php

namespace Liuggio\StatsDClientBundle\Model;

interface StatsDataInterface
{
    /**
     * @abstract
     * @return string
     */
    function getKey();

    /**
     * @abstract
     * @return mixed
     */
    function getValue();

    /**
     * @abstract
     * @return string
     */
    function getMessage();

    /**
     * @abstract
     * @return string
     */
    function getValueArray();

    /**
     * @abstract
     * @return string
     */
    function __toString();
}
