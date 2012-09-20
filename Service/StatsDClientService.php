<?php

namespace Liuggio\StatsDClientBundle\Service;

use Liuggio\StatsDClientBundle\Model\StatsDataInterface;

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

    function doReduce($result, $item)
    {
        $oldLastItem = array_pop($result);
        $sizeResult = strlen($oldLastItem);
        $message = $item->getMessage();
        $totalSize = $sizeResult + strlen($message) + 1; //the comma is the 1

        if (self::MAX_UDP_SIZE_STR < $totalSize) {
            //going to build another one
            array_push($result, $message);
            array_push($result, $oldLastItem);
        } else {
            //going to modifying the existing
            $comma= '';
            if ($sizeResult > 0) {
                $comma= ',';
            }
            $oldLastItem = sprintf("%s%s%s", $oldLastItem, $comma, $message);
            array_push($result, $oldLastItem);
        }
        return $result;
    }

    /**
     * this function reduce the amount of data that should be send with the same message
     * @param $StatsData
     */
    public function reduceCount($StatsData)
    {
        if (is_array($StatsData)) {
            $StatsData = array_reduce($StatsData, "self::doReduce", array());
        }
        return $StatsData;
    }

    /**
     * send data over udp
     *
     * @param array $StatsData
     * @return int the number of StatsData Sent
     *
     * @throws \Liuggio\StatsDClientBundle\Exception
     */
    public function send($StatsData, $reduceDataCount = true)
    {

        if (!is_array($StatsData)) {
            $StatsData = array($StatsData);
        }
        $sentDataCounter = 0;

        // Wrap this in a try/catch - failures in any of this should be silently ignored
        try {
            $host = $this->getHost();
            $port = $this->getPort();

            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            if (!$socket) {
                throw new \Exception("Could not open statd connection to $host:$port");
            }
            foreach ($StatsData as $StatsDataEntity) {
                if ($StatsDataEntity instanceOf StatsDataInterface) {
                    // the array is an array of StatsDataInterface
                    $message = $StatsDataEntity->getMessage();
                    $sendData = true;
                } elseif (is_string($StatsDataEntity)) {
                    // the array is an array of string
                    $message = $StatsDataEntity;
                    $sendData = true;
                }

                if ($sendData) {
                    $sendData = socket_sendto($socket, $message, strlen($message), 0, $host, $port);
                    if (strlen($message) !== $sendData) {
                        throw new \Exception(sprintf("Error on Data sent, expected %d instead of %d",strlen($message),$sendData ));
                    }
                    $sentDataCounter++;
                } else {
                    throw new \Exception("Statsd Object is not an instanceOf of StatsDataInterface or String");
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
        $this->failSilently  = $fail_silently;
    }

    /**
     * @return boolean
     */
    public function getFailSilently()
    {
        return $this->failSilently;
    }
}
