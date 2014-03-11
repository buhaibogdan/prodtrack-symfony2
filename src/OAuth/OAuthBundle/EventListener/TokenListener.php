<?php


namespace OAuth\OAuthBundle\EventListener;

use OAuth\OAuthBundle\Controller\ITokenAuthenticatedController;
use OAuth\OAuthBundle\Services\IClientAuthenticator;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TokenListener
{
    private $auth;

    public function __construct(IClientAuthenticator $auth)
    {
        $this->auth = $auth;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ITokenAuthenticatedController) {
            // get auth header
            // check token state
            // return message or throw exception
            throw new AccessDeniedHttpException("No token? :(");
        }
    }
}