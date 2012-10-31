<?php

namespace Liuggio\StatsDClientBundle\Tests\Service;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Liuggio\StatsdClient\Factory\StatsdDataFactory;;
use Liuggio\StatsDClientBundle\Service\StatsDService;
use Liuggio\StatsDClientBundle\Entity\StatsData;

class StatsdDataFactoryTest extends WebTestCase
{
    private $statsdDataFactory;

    public function setUp()
    {
        $this->statsdDataFactory = new StatsdDataFactory('\Liuggio\StatsdClient\Entity\StatsdData');
    }
//
//    public function testCreateStatsData()
//    {
//        $key = 'key';
//        $value='val';
//
//        $obj = $this->statsdDataFactory->createStatsData($key, $value);
//        $this->assertEquals($key, $obj->getKey());
//        $this->assertEquals($value, $obj->getValue());
//    }
//
//    public function testCreateStatsDataTiming()
//    {
//        $key = 'key';
//        $value = microtime();
//        $valueFloat = (string) floatval($value);
//
//        $obj = $this->statsdDataFactory->timing($key, $value);
//        $this->assertEquals($key, $obj->getKey());
//        $this->assertContains($valueFloat, $obj->getValue());
//        $this->assertContains('|ms', $obj->getValue());
//    }
//
////    public function testCreateStatsDataUpdate()
////    {
////        $key = 'key';
////        $value = -1;
////        $stringValue = (string) intval($value);
////
////        $obj = $this->statsdDataFactory->createStatsDataUpdate($key, $value);
////        $this->assertEquals($key, $obj->getKey());
////        $this->assertContains($stringValue, $obj->getValue());
////        $this->assertContains('|c', $obj->getValue());
////    }
//
//    public function testCreateStatsDataGauge()
//    {
//        $key = 'key';
//        $value = 1000;
//        $stringValue = intval($value);
//
//        $obj = $this->statsdDataFactory->gauge($key, $value);
//        $this->assertEquals($key, $obj->getKey());
//        $this->assertContains($stringValue, $obj->getValue());
//        $this->assertContains('|g', $obj->getValue());
//    }
//
//    public function testCreateStatsDataDecrement()
//    {
//        $key = 'key';
//        $value = -1;
//        $stringValue = (string) intval($value);
//
//        $obj = $this->statsdDataFactory->decrement($key);
//        $this->assertEquals($key, $obj->getKey());
//        $this->assertContains($stringValue, $obj->getValue());
//        $this->assertContains('|c', $obj->getValue());
//    }
//
//    public function testCreateStatsDataIncrement()
//    {
//        $key = 'key';
//        $value = 1;
//        $stringValue = (string) intval($value);
//
//        $obj = $this->statsdDataFactory->increment($key);
//        $this->assertEquals($key, $obj->getKey());
//        $this->assertContains($stringValue, $obj->getValue());
//        $this->assertContains('|c', $obj->getValue());
//    }


}
