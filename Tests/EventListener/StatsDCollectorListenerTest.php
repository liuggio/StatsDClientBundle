<?php

namespace Liuggio\StatsDClientBundle\Tests\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;

use Liuggio\StatsDClientBundle\Listener\StatsDCollectorListener;

/**
 *
 * @author liuggio <liuggio@gmail.com>
 */
class StatsDCollectorListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelException()
    {
        $this->markTestSkipped('-');
    }

//
//    protected function getActiveThemeStub()
//    {
//        $activeTheme = $this->getMockBuilder('Liip\ThemeBundle\ActiveTheme')
//            ->setConstructorArgs(array('desktop', array('desktop', 'tablet', 'mobile')))
//            ->getMock();
//        $activeTheme->expects($this->any())
//            ->method('getThemes')
//            ->will($this->returnValue(array('desktop', 'tablet', 'mobile')));
//        return $activeTheme;
//    }
//
//    protected function getResponseEventMock($cookieReturnValue = null, $userAgent = null)
//    {
//        $request = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
//            ->disableOriginalConstructor()
//            ->getMock();
//        $request->cookies = $this->getMockBuilder('Symfony\Component\HttpFoundation\ParameterBag')
//            ->disableOriginalConstructor()
//            ->getMock();
//        $request->cookies->expects($this->any())
//            ->method('get')
//            ->will($this->returnValue($cookieReturnValue));
//        $request->server = $this->getMockBuilder('Symfony\Component\HttpFoundation\ParameterBag')
//            ->disableOriginalConstructor()
//            ->getMock();
//        $request->server->expects($this->any())
//            ->method('get')
//            ->will($this->returnValue($cookieReturnValue, $userAgent));
//
//        $response = $this->getMockBuilder('Symfony\Component\HttpFoundation\Response')
//            ->disableOriginalConstructor()
//            ->getMock();
//        $response->headers = $this->getMockBuilder('Symfony\Component\HttpFoundation\ResponseHeaderBag')
//            ->disableOriginalConstructor()
//            ->getMock();
//
//        $event = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseEvent')
//            ->disableOriginalConstructor()
//            ->getMock();
//        $event->expects($this->any())
//            ->method('getRequest')
//            ->will($this->returnValue($request));
//        $event->expects($this->any())
//            ->method('getRequestType')
//            ->will($this->returnValue(HttpKernelInterface::MASTER_REQUEST));
//        $event->expects($this->any())
//            ->method('getResponse')
//            ->will($this->returnValue($response));
//
//        return $event;
//    }


}
