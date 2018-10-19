<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

use Liuggio\StatsDClientBundle\StatsCollector\UserStatsCollector;

class UserStatsCollectorTest extends StatsCollectorBase
{
    /**
     * @dataProvider provider
     */
    public function testCollect($isLogged, $dataKey)
    {
        $checker = $this->getMockBuilder(AuthorizationCheckerInterface::class)
            ->setMethods(['isGranted'])
            ->getMock()
        ;
        $checker->expects($this->any())
            ->method('isGranted')
            ->will($this->returnValue($isLogged))
        ;

        $c = new UserStatsCollector('prefix', $this->mockStatsDFactory('prefix.' . $dataKey));
        $c->setSecurityContext($checker);
        $c->collect(new Request(), new Response(), null);
    }

    public function provider()
    {
        return array(
            array(true, 'logged'),
            array(false, 'anonymous'));
    }
}
