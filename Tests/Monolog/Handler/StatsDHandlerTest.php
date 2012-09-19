<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Liuggio\StatsDClientBundle\Tests\Monolog\Handler;

use Liuggio\StatsDClientBundle\Tests\Monolog\TestCase;
use Monolog\Logger;
use Monolog\Handler\TestHandler;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Liuggio\StatsDClientBundle\Monolog\Handler\StatsDHandler;


class StatsDEntity
{
    private $message;

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function __construct($message) {
        $this->setMessage($message);
    }
}

class StatsDHandlerTest extends TestCase
{
    protected  $buffer;

    public function setUp() {

        $this->buffer= array(
            new StatsDEntity('.test.info.2012-09-19-160214-testinfo-personal-ca-'),
            new StatsDEntity('.test.info'),
            new StatsDEntity('.test.info.context.c.a'));

    }

    public function mockStatsDService() {

        $phpunit = $this;
        $statsd = $this->getMock("\StdClass", array('send'));
        $statsd->expects($this->once())
            ->method('send');


        return $statsd;
    }

    public function mockStatsDFactory() {


        $phpunit = $this;
        $statsDFactory = $this->getMock("\StdClass", array('createStatsDataIncrement'));
        $statsDFactory->expects($this->any())
            ->method('createStatsDataIncrement')
            ->will($this->returnCallback(function ($input) use ($phpunit) {

            return new StatsDEntity($input);
        }));

        return $statsDFactory;

    }
    /**
     * @covers Liuggio\StatsDClientBundle\Monolog\Handler\StatsDHandler::__construct
     * @covers Liuggio\StatsDClientBundle\Monolog\Handler\StatsDHandler::__handle
     * @covers Liuggio\StatsDClientBundle\Monolog\Handler\StatsDHandler::write
     */
    public function testHandleBuffers()
    {
        $handler = new StatsDHandler(Logger::INFO);
        $handler->setStatsDService($this->mockStatsDService());
        $handler->setStatsDFactory($this->mockStatsDFactory());
        $handler->setContextLogging(false);

        $handler->handle($this->getRecord(Logger::INFO, 'personal', array('c'=>'a')));

        $outputBuffer = $handler->getBuffer();

        $this->assertStringStartsWith('.test.info.',  $this->buffer[0]->getMessage());
        $this->assertStringEndsWith('-testinfo-personal-ca-',  $this->buffer[0]->getMessage());

        $this->assertEquals($outputBuffer[1],
            $this->buffer[1]
        );

        $this->assertArrayNotHasKey(2, $outputBuffer);
    }

    /**
     * @covers Liuggio\StatsDClientBundle\Monolog\Handler\StatsDHandler::__construct
     * @covers Liuggio\StatsDClientBundle\Monolog\Handler\StatsDHandler::__handle
     * @covers Liuggio\StatsDClientBundle\Monolog\Handler\StatsDHandler::write
     */
    public function testHandleBuffersWithContext()
    {
        $handler = new StatsDHandler(Logger::INFO);
        $handler->setStatsDService($this->mockStatsDService());
        $handler->setStatsDFactory($this->mockStatsDFactory());
        $handler->setContextLogging(true);

        $handler->handle($this->getRecord(Logger::INFO, 'personal', array('c'=>'a')));

        $outputBuffer = $handler->getBuffer();

        $this->assertStringStartsWith('.test.info.',  $this->buffer[0]->getMessage());
        $this->assertStringEndsWith('-testinfo-personal-ca-',  $this->buffer[0]->getMessage());

        $this->assertEquals($outputBuffer[1],
            $this->buffer[1]
        );
        $this->assertEquals($outputBuffer[2],
            $this->buffer[2]
        );

    }
}
