<?php


namespace OAuth\OAuthBundle\Tests\Services;


use OAuth\OAuthBundle\Services\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ErrorResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExpiredTokenResponse()
    {
        $errorMsg = 'Bearer "prodTrack", error="invalid_token", error_description="Your token has expired."';

        $err = new ErrorResponse();
        $invalidToken = $err->getExpiredTokenResponse();
        $status = $invalidToken->getStatusCode();
        $header = $invalidToken->headers->get('WWW-Authenticate');

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $invalidToken);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $status);
        $this->assertEmpty($invalidToken->getContent());
        $this->assertEquals($header, $errorMsg);
    }


    public function testGetInvalidRequest()
    {
        $errorMsg = 'Bearer "prodTrack", error="invalid_request", ' .
            'error_description="Some params might be missing. Check the docs"';

        $err = new ErrorResponse();
        $invalidToken = $err->getInvalidRequestResponse();
        $status = $invalidToken->getStatusCode();
        $header = $invalidToken->headers->get('WWW-Authenticate');

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $invalidToken);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $status);
        $this->assertEmpty($invalidToken->getContent());
        $this->assertEquals($header, $errorMsg);
    }

    public function testGetInvalidClientRequest()
    {
        $errorMsg =
            'Bearer "prodTrack", error="invalid_client", error_description="Client authentication failed."';

        $err = new ErrorResponse();
        $invalidToken = $err->getInvalidClientResponse();
        $status = $invalidToken->getStatusCode();
        $header = $invalidToken->headers->get('WWW-Authenticate');

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $invalidToken);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $status);
        $this->assertEmpty($invalidToken->getContent());
        $this->assertEquals($header, $errorMsg);
    }

    public function testGetUnsupportedGrantTypeRequest()
    {
        $errorMsg =
            'Bearer "prodTrack", error="unsupported_grant_type"';

        $err = new ErrorResponse();
        $invalidToken = $err->getUnsupportedGrantTypeRequest();
        $status = $invalidToken->getStatusCode();
        $header = $invalidToken->headers->get('WWW-Authenticate');

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $invalidToken);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $status);
        $this->assertEmpty($invalidToken->getContent());
        $this->assertEquals($header, $errorMsg);
    }

    public function testGetInvalidUserResponse()
    {
        $errorMsg =
            'Bearer "prodTrack, error="invalid_user", error_description="Username or password invalid."';

        $err = new ErrorResponse();
        $invalidToken = $err->getInvalidUserResponse();
        $status = $invalidToken->getStatusCode();
        $header = $invalidToken->headers->get('WWW-Authenticate');

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $invalidToken);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $status);
        $this->assertEmpty($invalidToken->getContent());
        $this->assertEquals($header, $errorMsg);
    }

}