<?php

namespace Liuggio\StatsDClientBundle\Listener;

use Liuggio\StatsDClientBundle\Service\StatsDCollectorService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * StatsDCollectorListener.
 *
 * @author <liuggio@gmail.com>
 */
class StatsDCollectorListener implements EventSubscriberInterface
{
    protected $collector;
    protected $exception;
    protected $children;
    protected $requests;
    protected $collectors;

    /**
     * Constructor.
     *
     * @param StatsDCollectorService $collector          A collector instance
     * @param bool                   $onlyException      true if the collector only collects data when an exception occurs, false otherwise
     * @param bool                   $onlyMasterRequests true if the collector only collects data when the request is a master request, false otherwise
     */
    public function __construct(StatsDCollectorService $collector, $onlyException = false, $onlyMasterRequests = false)
    {
        $this->collector = $collector;
        $this->onlyException = (bool) $onlyException;
        $this->onlyMasterRequests = (bool) $onlyMasterRequests;
        $this->collectors = [];
    }

    /**
     * Handles the onKernelException event.
     *
     * @param GetResponseForExceptionEvent $event A GetResponseForExceptionEvent instance
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($this->onlyMasterRequests && HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $this->exception = $event->getException();
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->requests[] = $event->getRequest();
    }

    /**
     * Handles the onKernelResponse event.
     *
     * @param FilterResponseEvent $event A FilterResponseEvent instance
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $master = HttpKernelInterface::MASTER_REQUEST === $event->getRequestType();
        if ($this->onlyMasterRequests && !$master) {
            return;
        }

        if ($this->onlyException && null === $this->exception) {
            return;
        }

        $request = $event->getRequest();
        $exception = $this->exception;
        $this->exception = null;

        $dataToSend = $this->collector->collect($master, $request, $event->getResponse(), $exception);

        if (null === $dataToSend || !\is_array($dataToSend) || \count($dataToSend) < 1) {
            return;
        }
        $this->collector->send($dataToSend);
    }

    public static function getSubscribedEvents()
    {
        return [
            // kernel.request must be registered as early as possible to not break
            // when an exception is thrown in any other kernel.request listener
            KernelEvents::REQUEST => ['onKernelRequest', 1024],
            KernelEvents::RESPONSE => ['onKernelResponse', -100],
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
