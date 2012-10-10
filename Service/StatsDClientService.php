<?php

namespace Liuggio\StatsDClientBundle\Service;

use Liuggio\StatsDClientBundle\Model\StatsDataInterface;
use Liuggio\StatsDClientBundle\Exception;

class StatsDClientService
{
    const MAX_UDP_SIZE_STR = 548; //512 - IPv4 header

    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;

    /**
     * @var boolean
     */
    private $failSilently;


    public function __construct($host, $port, $fail_silently = true)
    {
        $this->host = $host;
        $this->port = $port;
        $this->failSilently = $fail_silently;
    }

    /**
     * This function return an array of reduced string
     *
     * @param $result
     * @param $item
     * @return mixed
     */
    function doReduce($result, $item)
    {
        $oldLastItem = array_pop($result);
        $sizeResult = strlen($oldLastItem);

        if ($item instanceOf StatsDataInterface) {
            $message = $item->getMessage();
        } elseif (is_string($item)) {
            $message = $item;
        } else {
            // ignore this item
            if (!$this->getFailSilently()) {
                throw new Exception(sprintf("Error on Data sent, expected a string or StatsDataInterface"));
            }
            if (null !== $oldLastItem) {
                array_push($result, $oldLastItem);
            }
            return $result;
        }

        $totalSize = $sizeResult + strlen($message) + 1; //the comma is the 1
        if (self::MAX_UDP_SIZE_STR < $totalSize) {
            //going to build another one
            array_push($result, $message);
            array_push($result, $oldLastItem);
        } else {
            //going to modifying the existing
            $comma = '';
            if ($sizeResult > 0) {
                $comma = ',';
            }
            $oldLastItem = sprintf("%s%s%s", $oldLastItem, $comma, $message);
            array_push($result, $oldLastItem);
        }
        return $result;
    }

    /**
     * this function reduce the amount of data that should be send with the same message
     * @param $statsData
     */
    public function reduceCount($statsData)
    {
        if (is_array($statsData)) {
            $statsData = array_reduce($statsData, "self::doReduce", array());
        }
        return $statsData;
    }

    /**
     * Send data over udp Data is a well formmatted string for statsd, or a StatsDataInterface, or an array of string or
     * an array of StatsDataInterfaces
     *
     * @param mixed $statsData could be array, a string or a StatsDataInterface
     * @param boolean $reduceDataCount
     * @return int
     *
     * @throws \Liuggio\StatsDClientBundle\Exception
     */
    public function send($statsData, $reduceDataCount = true)
    {
        $sentDataCounter = 0;
        if ($reduceDataCount) {
            $statsData = $this->reduceCount($statsData);
        }

        if (!is_array($statsData)) {
            $statsData = array($statsData);
        }

        // Wrap this in a try/catch - failures in any of this should be silently ignored
        try {
            $host = $this->getHost();
            $port = $this->getPort();

            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            if (!$socket) {
                throw new \Exception("Could not open statd connection to $host:$port");
            }
            foreach ($statsData as $statsDataObject) {
                $message = null;

                if ($statsDataObject instanceOf StatsDataInterface) {
                    // the array is an array of StatsDataInterface
                    $message = $statsDataObject->getMessage();
                } elseif (is_string($statsDataObject)) {
                    // the array is an array of string
                    $message = $statsDataObject;
                } else {
                    throw new Exception("Statsd Object is not an instanceOf of StatsDataInterface neither of a String");
                }

                if (null !== $message && strlen($message) > 0) {
                    $sendData = socket_sendto($socket, $message, strlen($message), 0, $host, $port);
                    if (strlen($message) !== $sendData) {
                        throw new Exception(sprintf("Error on Data sent, expected %d instead of %d", strlen($message), $sendData));
                    }
                    $sentDataCounter++;
                }
            }
            socket_close($socket);
        } catch (\Exception $e) {
            if (!$this->getFailSilently()) {
                throw $e;
            }
        }
        return $sentDataCounter;
    }


    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param boolean $fail_silently
     */
    public function setFailSilently($fail_silently)
    {
        $this->failSilently = $fail_silently;
    }

    /**
     * @return boolean
     */
    public function getFailSilently()
    {
        return $this->failSilently;
    }
}
