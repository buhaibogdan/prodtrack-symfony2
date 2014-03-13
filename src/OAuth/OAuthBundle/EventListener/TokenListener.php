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

        if (!$controller[0] instanceof ITokenAuthenticatedController) {

            $authHeader = null;
            if (!$event->getRequest()->headers->has('Authorization') && function_exists('apache_request_headers')) {
                $all = apache_request_headers();
                if (isset($all['Authorization'])) {
                    $authHeader = $all['Authorization'];
                }
            }

            $validAuthorization = $this->auth->hasValidAuthorization($authHeader);

            // check token state
            // return message or throw exception

        } else {
            throw new AccessDeniedHttpException("No token? :(");
        }
    }
}