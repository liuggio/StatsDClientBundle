<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

class ExceptionStatsCollector extends StatsCollector
{
    private static $counter = 0;

    public function getName()
    {
        return 'ExceptionCollector';
    }



    /**
     * Collects data for the given Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An exception instance if the request threw one
     *
     * @return boolean
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if (null === $exception) {
            return true;
        }
        // check the number times of execution.
        // eg. with `render` in twig happens that this func is called more times.


        $key = sprintf('%s.exception', $this->getStatsDataKey());
        $statData = $this->getStatsDataFactory()->increment($key);
        $this->addStatsData($statData);

        self::$counter++;
        return true;
    }



}
