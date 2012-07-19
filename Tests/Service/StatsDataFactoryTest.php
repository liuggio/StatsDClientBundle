<?php

namespace Liuggio\StatsDClientBundle\Tests\Service;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Liuggio\StatsDClientBundle\Service\StatsDataFactory;
use Liuggio\StatsDClientBundle\Service\StatsDService;
use Liuggio\StatsDClientBundle\Entity\StatsData;

class StatsDataFactoryTest extends WebTestCase
{
    private $statsDataFactory;

    public function setUp()
    {
        $this->statsDataFactory = new StatsDataFactory('\Liuggio\StatsDClientBundle\Entity\StatsData');
    }

    public function testCreateStatsData()
    {
        $key = 'key';
        $value='val';

        $obj = $this->statsDataFactory->createStatsData($key, $value);
        $this->assertEquals($key, $obj->getKey());
        $this->assertEquals($value, $obj->getValue());
    }

    public function testCreateStatsDataTiming()
    {
        $key = 'key';
        $value = microtime();
        $valueFloat = (string) floatval($value);

        $obj = $this->statsDataFactory->createStatsDataTiming($key, $value);
        $this->assertEquals($key, $obj->getKey());
        $this->assertContains($valueFloat, $obj->getValue());
        $this->assertContains('|ms', $obj->getValue());
    }

    public function testCreateStatsDataUpdate()
    {
        $key = 'key';
        $value = -1;
        $stringValue = (string) intval($value);

        $obj = $this->statsDataFactory->createStatsDataUpdate($key, $value);
        $this->assertEquals($key, $obj->getKey());
        $this->assertContains($stringValue, $obj->getValue());
        $this->assertContains('|c', $obj->getValue());
    }

    public function testCreateStatsDataGauge()
    {
        $key = 'key';
        $value = 1000;
        $stringValue = (string) intval($value);

        $obj = $this->statsDataFactory->createStatsDataGauge($key, $value);
        $this->assertEquals($key, $obj->getKey());
        $this->assertContains($stringValue, $obj->getValue());
        $this->assertContains('|g', $obj->getValue());
    }

    public function testCreateStatsDataDecrement()
    {
        $key = 'key';
        $value = -1;
        $stringValue = (string) intval($value);

        $obj = $this->statsDataFactory->createStatsDataDecrement($key);
        $this->assertEquals($key, $obj->getKey());
        $this->assertContains($stringValue, $obj->getValue());
        $this->assertContains('|c', $obj->getValue());
    }

    public function testCreateStatsDataIncrement()
    {
        $key = 'key';
        $value = 1;
        $stringValue = (string) intval($value);

        $obj = $this->statsDataFactory->createStatsDataIncrement($key);
        $this->assertEquals($key, $obj->getKey());
        $this->assertContains($stringValue, $obj->getValue());
        $this->assertContains('|c', $obj->getValue());
    }

}
