<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Liuggio\StatsDClientBundle\StatsCollector\UserStatsCollector;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserStatsCollectorTest extends StatsCollectorBase
{

    public function mockAuthorizationChecker($return)
    {
        $statsDFactory = $this->getMockBuilder(AuthorizationCheckerInterface::class)
            ->setMethods(array('isGranted'))
            ->getMock();

        $statsDFactory->expects($this->any())
            ->method('isGranted')
            ->will($this->returnValue($return));

        return $statsDFactory;
    }

    /**
     * @dataProvider provider
     */
    public function testCollect($isLogged, $dataKey)
    {
        $c = new UserStatsCollector('prefix', $this->mockStatsDFactory('prefix.' . $dataKey));
        $c->setAuthorizationChecker($this->mockAuthorizationChecker($isLogged));
        $c->collect(new Request(), new Response(), null);
    }

    public function provider()
    {
        return array(
            array(true, 'logged'),
            array(false, 'anonymous'));
    }
}
