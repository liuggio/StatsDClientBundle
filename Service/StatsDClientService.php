<?php

namespace Liuggio\StatsDClientBundle\Service;

use Liuggio\StatsDClientBundle\Model\StatsDataInterface;

class StatsDClientService
{
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
     * this function reduce the amount of data that should be send
     * @param $StatsData
     */
    public function reduceCount($StatsData)
    {
        //@todo StatsData should have 3 fields:
        //    key-value-type
        // in here a foreach that if is the type of count, it add the content and pop the value.
    }

    /**
     * send data over udp
     *
     * @param array $StatsData
     * @return int the number of StatsData Sent
     *
     * @throws \Liuggio\StatsDClientBundle\Exception
     */
    public function send($StatsData)
    {

        if (!is_array($StatsData)) {
            $StatsData = array($StatsData);
        }
        $sentDataCounter = 0;
        //reduce dataCount
        $this->reduceCount($StatsData);
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
                    $message = $StatsDataEntity->getMessage();
                    socket_sendto($socket, $message, strlen($message), 0, $host, $port);
                    $sentDataCounter++;
                } else {
                    throw new \Exception("Statsd Object is not an instanceOf of StatsDataInterface ");
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
        $this->fail_silently = $fail_silently;
    }

    /**
     * @return boolean
     */
    public function getFailSilently()
    {
        return $this->fail_silently;
    }
}
