<?php

namespace Liuggio\StatsDClientBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Liuggio\StatsDClientBundle\Service\StatsDClientService;
use Liuggio\StatsDClientBundle\Entity\StatsData;

class StatsDataTest extends WebTestCase
{
    public function testReduceCount()
    {
        $entity = new StatsData();
        $entity->setKey('key');
        $entity->setValue('value|g');
        $array[] = $entity;
        $this->assertEquals($entity->getValueArray(), array('value','g'));
    }
}
