<?php


namespace OAuth\OAuthBundle\Services;


use Symfony\Component\HttpFoundation\Response;

class ErrorResponse
{
    protected $invalidTokenMsg =
        'Bearer "prodTrack", error="invalid_token", error_description="Your token has expired."';

    protected $invalidRequestMsg =
        'Bearer "prodTrack", error="invalid_request", error_description="Some params might be missing. Check the docs"';

    protected $invalidClientMsg =
        'Bearer "prodTrack", error="invalid_client", error_description="Client authentication failed."';

    protected $unsupportedGrantType =
        'Bearer "prodTrack", error="unsupported_grant_type"';

    protected $invalidUser =
        'Bearer "prodTrack, error="invalid_user", error_description="Username or password invalid."';

    /**
     * @return Response
     */
    public function getExpiredTokenResponse()
    {
        return new Response(
            '',
            Response::HTTP_UNAUTHORIZED,
            array('WWW-Authenticate' => $this->invalidTokenMsg)
        );
    }

    public function getInvalidRequestResponse()
    {
        return new Response(
            '',
            Response::HTTP_BAD_REQUEST,
            array('WWW-Authenticate' => $this->invalidRequestMsg)
        );
    }

    public function getInvalidClientResponse()
    {
        return new Response(
            '',
            Response::HTTP_UNAUTHORIZED,
            array('WWW-Authenticate' => $this->invalidClientMsg)
        );
    }

    public function getUnsupportedGrantTypeRequest()
    {
        return new Response(
            '',
            Response::HTTP_BAD_REQUEST,
            array('WWW-Authenticate' => $this->unsupportedGrantType)
        );
    }

    public function getInvalidUserResponse()
    {
        return new Response(
            '',
            Response::HTTP_UNAUTHORIZED,
            array('WWW-Authenticate' => $this->invalidUser)
        );
    }

}