<?php

namespace Liuggio\StatsDClientBundle\Tests\Monolog\Formatter;

use Liuggio\StatsDClientBundle\Monolog\Formatter\ShortLineFormatter;
use Monolog\Logger;

/**
 * @covers Monolog\Formatter\LineFormatter
 */
class LineFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testDefFormatWithString()
    {
        $formatter = new ShortLineFormatter(ShortLineFormatter::SIMPLE_FORMAT);
        $message = $formatter->format(array(
            'level_name' => 'WARNING',
            'channel' => 'log',
            'context' => array(),
            'message' => 'foo',
            'datetime' => new \DateTime,
            'extra' => array(),
        ));
        $this->assertEquals('log.WARNING.foo', $message);
    }

    public function testDefFormatWithArrayContext()
    {
        $formatter = new ShortLineFormatter();
        $message = $formatter->format(array(
            'level_name' => 'ERROR',
            'channel' => 'meh',
            'message' => 'foo',
            'datetime' => new \DateTime,
            'extra' => array(),
            'context' => array(
                'foo' => 'bar',
                'baz' => 'qux',
            )
        ));
        $this->assertEquals('meh.ERROR.foo', $message);
    }

    public function testDefLongFormat()
    {
        $formatter = new ShortLineFormatter();
        $message = $formatter->format(array(
            'level_name' => 'DEBUG',
            'channel' => 'doctrine',
            'message' => 'INSERT INTO viaggio_calendar (enable, viaggio_id, calendar_id) VALUES (?, ?, ?)',
            'datetime' => new \DateTime,
            'extra' => array(),
            'context' => array(
                'foo' => 'bar',
                'baz' => 'qux',
            )
        ));
        $this->assertEquals('doctrine.DEBUG.INSERT-INTO', $message);
    }

    public function testDefKernelException()
    {
        $formatter = new ShortLineFormatter();
        $message = $formatter->format(array(
            'level_name' => 'DEBUG',
            'channel' => 'doctrine',
            'message' => 'Notified event "kernel.exception" to listener "Symfony\Component\HttpKernel\EventListener\ProfilerListener::onKernelException"',
            'datetime' => new \DateTime,
            'extra' => array(),
            'context' => array(
                'foo' => 'bar',
                'baz' => 'qux',
            )
        ));
        $this->assertEquals('doctrine.DEBUG.Notified-event', $message);
    }

    public function testDefRouteException()
    {
        $formatter = new ShortLineFormatter();
        $message = $formatter->format(array(
            'level_name' => 'DEBUG',
            'channel' => 'doctrine',
            'message' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException: No route found for "GET /ddd" (uncaught exception) at /xxxx/classes.php line 5062',
            'datetime' => new \DateTime,
            'extra' => array(),
        ));
        $this->assertEquals('doctrine.DEBUG.Symfony-Component-HttpKernel-Exception-NotFoundHttpException--No', $message);
    }

}

class TestFoo
{
    public $foo = 'foo';
}

class TestBar
{
    public function __toString()
    {
        return 'bar';
    }
}
