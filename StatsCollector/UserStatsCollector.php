<?php

namespace Liuggio\StatsDClientBundle\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

class UserStatsCollector extends StatsCollector
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * Collects data for the given Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An exception instance if the request threw one
     *
     * @return Boolean
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {

        if (null === $this->getAuthorizationChecker()) {
            return true;
        }

        $key = sprintf('%s.anonymous', $this->getStatsDataKey());
        try {
            if ($this->getAuthorizationChecker()->isGranted('IS_AUTHENTICATED_FULLY')) {
                $key = sprintf('%s.logged', $this->getStatsDataKey());
            }
        } catch (AuthenticationCredentialsNotFoundException $exception) {
            //do nothing
        }
        $statData = $this->getStatsdDataFactory()->increment($key);
        $this->addStatsData($statData);

        return true;
    }

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @return AuthorizationCheckerInterface
     */
    public function getAuthorizationChecker()
    {
        return $this->authorizationChecker;
    }


}
