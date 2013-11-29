<?php

namespace Liuggio\StatsDClientBundle\EventListener;

use AdrienBrault\StatsDCollector\StatsDDataCollector;
use Liuggio\StatsdClient\StatsdClientInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author <liuggio@gmail.com>
 */
class StatsdListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::TERMINATE => array('onKernelTerminate'),
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

    public function onKernelTerminate(PostResponseEvent $event)
    {
        $statsData = $this->collector->collect();

        if (empty($statsData)) {
            return;
        }

        $this->client->send($statsData);
    }
}
