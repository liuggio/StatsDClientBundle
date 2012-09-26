<?php

namespace Liuggio\StatsDClientBundle\Tests\StatsCollector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Liuggio\StatsDClientBundle\StatsCollector\StatsCollector;

use Liuggio\StatsDClientBundle\StatsCollector\UserStatsCollector;
use Liuggio\StatsDClientBundle\Model\StatsDataInterface;

class UserStatsCollectorTest extends WebTestCase
{
    public function mockStatsDFactory($compare)
    {
        $phpunit = $this;
        $statsDFactory = $this->getMockBuilder('Liuggio\StatsDClientBundle\Service\StatsDataFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('createStatsDataIncrement'))
            ->getMock();

        $dataMock = $this->getMock('Liuggio\StatsDClientBundle\Model\StatsDataInterface');

        $statsDFactory->expects($this->any())
            ->method('createStatsDataIncrement')
            ->will($this->returnCallback(function ($input) use ($phpunit, $compare, $dataMock) {
                $phpunit->assertEquals($compare, $input);
            return $dataMock;
        }));
        return $statsDFactory;
    }


    public function mockSecurityContext($return)
    {
        $phpunit = $this;
        $statsDFactory = $this->getMockBuilder('Symfony\Component\Security\Core\SecurityContextInterface')
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
        $c = new UserStatsCollector('prefix', $this->mockStatsDFactory('prefix.'.$dataKey));
        $c->setSecurityContext($this->mockSecurityContext($isLogged));
        $c->collect(new Request(), new Response(), null);
    }

    public function provider() {
        return array(
            array(true, 'logged'),
            array(false, 'anonymous'));
    }
}
