<?php

namespace Liuggio\StatsDClientBundle\EventListener;

use AdrienBrault\StatsDCollector\StatsDDataCollector;
use Liuggio\StatsdClient\StatsdClientInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author <liuggio@gmail.com>
 */
class ResponseListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse', -100),
        );
    }

    /**
     * @var StatsDDataCollector
     */
    private $collector;

    /**
     * @var StatsdClientInterface
     */
    private $client;

    public function __construct(StatsDDataCollector $collector, StatsdClientInterface $client)
    {
        $this->collector = $collector;
        $this->client = $client;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        // We only want to send collectors data on the last kernel response event
        if ($event->getRequestType() !== Kernel::MASTER_REQUEST) {
            return;
        }

        $statsData = $this->collector->collect();

        if (empty($statsData)) {
            return;
        }

        $this->client->send($statsData);
    }
}
