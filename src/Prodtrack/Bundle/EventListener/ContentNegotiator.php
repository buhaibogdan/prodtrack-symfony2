<?php


namespace Prodtrack\Bundle\EventListener;


use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ContentNegotiator
{
    protected $contentAccepted;

    public function __construct($contentAccepted)
    {
        $this->contentAccepted = $contentAccepted;
    }

    public function onKernelController(FilterControllerEvent $event)
    {

    }

    public function onKernelResponse(FilterResponseEvent $event)
    {

    }
}