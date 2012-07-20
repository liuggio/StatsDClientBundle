<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

class UserStatsCollector extends StatsCollector
{
    private static $counter = 0;

    public function getName()
    {
        return 'UserCollector';
    }

    /*
    * calculate the peak used by php
    * @return int
    */
    private function getMemoryUsage()
    {
        return memory_get_peak_usage();
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
        // check the number times of execution.
        // eg. with `render` in twig happens that this func is called more times.
        if (self::$counter != 0) {
            return false;
        }
        if (null === $this->getSecurityContext()) {
            return true;
        }

        $key = sprintf('%s.anonymous', $this->getStatsDataKey());
        try {
            if ($this->getSecurityContext()->isGranted('IS_AUTHENTICATED_FULLY')) {
                $key = sprintf('%s.logged', $this->getStatsDataKey());
            }
        } catch (AuthenticationCredentialsNotFoundException $exception) {
            //do nothing
        }
        $statData = $this->getStatsDataFactory()->createStatsDataIncrement($key);
        $this->addStatsData($statData);

        self::$counter++;
        return true;
    }

    public function setSecurityContext($security_context)
    {
        $this->security_context = $security_context;
    }

    public function getSecurityContext()
    {
        return $this->security_context;
    }


}
