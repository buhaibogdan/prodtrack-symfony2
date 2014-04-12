<?php


namespace Prodtrack\ApiBundle\EventListener;


use Prodtrack\ApiBundle\Controller\ICollectionJsonController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class ContentNegotiator
{
    const CONTENT_COLLECTION_JSON = "application/vnd.collection+json";
    const CONTENT_JSON = "application/json";
    const CONTENT_ALL = "/*";

    protected $contentAccepted;

    public function __construct()
    {
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ICollectionJsonController) {
            $acceptHeader = $event->getRequest()->headers->get('Accept');
            $validAccept = strpos($acceptHeader, static::CONTENT_COLLECTION_JSON) !== false ||
                strpos($acceptHeader, static::CONTENT_ALL) !== false;
            if (!$validAccept) {
                throw new NotAcceptableHttpException();
            }
            $event->getRequest()->attributes->set('Content-Type', static::CONTENT_COLLECTION_JSON);
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $contentTypeHeader = $event->getRequest()->attributes->get('Content-Type');
        if (!$contentTypeHeader) {
            return;
        }

        $event->getResponse()->headers->set('Content-Type', $contentTypeHeader);
    }
}