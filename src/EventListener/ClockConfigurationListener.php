<?php

namespace IWF\ClockProviderBundle\EventListener;

use IWF\ClockProviderBundle\Service\ClockProvider;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ClockConfigurationListener
{
    private ClockProvider $clockProvider;

    public function __construct(ClockProvider $clockProvider)
    {
        $this->clockProvider = $clockProvider;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        if (!$event->getRequest()->hasSession()) {
            return;
        }
        if (!$this->clockProvider->canModifyTime()) {
            return;
        }

        $this->clockProvider->modifyOnRequestEvent();

    }
}