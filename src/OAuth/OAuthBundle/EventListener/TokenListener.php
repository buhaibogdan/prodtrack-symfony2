<?php


namespace OAuth\OAuthBundle\EventListener;

use OAuth\OAuthBundle\Controller\ITokenAuthenticatedController;
use OAuth\OAuthBundle\Exception\InvalidTokenException;
use OAuth\OAuthBundle\Services\ErrorResponse;
use OAuth\OAuthBundle\Services\IClientAuthenticator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class TokenListener
{
    private $auth;
    private $errResp;

    public function __construct(IClientAuthenticator $auth, ErrorResponse $errResp)
    {
        $this->auth = $auth;
        $this->errResp = $errResp;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ITokenAuthenticatedController) {

            $authHeader = null;
            if (!$event->getRequest()->headers->has('Authorization') &&
                function_exists('apache_request_headers')
            ) {
                $all = apache_request_headers();
                if (isset($all['Authorization'])) {
                    $authHeader = $all['Authorization'];
                }
            }

            $validAuthorization = $this->auth->hasValidAuthorization($authHeader);

            if (!$validAuthorization) {
                throw new InvalidTokenException();
            }
        }
    }


    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception instanceof InvalidTokenException) {
            $event->setResponse($this->errResp->getInvalidClientResponse());
        }
    }

    /**
     * @return string
     */
    public function getTokenExpiredError()
    {
        return 'Bearer "prodTrack", ' .
        'error="invalid_token", error_description="Your token has expired."';
    }
}