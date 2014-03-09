<?php

namespace OAuth\OAuthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TokenControllerTest extends WebTestCase
{
    public function testTokenHttpMethodGetNotAllowed()
    {
        $client = static::createClient();
        $client->request('GET', '/oauth/token');
        $status = $client->getResponse()->getStatusCode();
        $this->assertEquals('405', $status);
    }

    public function testTokenHasNotRequiredParams()
    {
        $postParams = array(
            'username' => 'bb',
            'password' => '123456',
            'client_id' => 'sfjg3nl4knansd2'
            // client_secret and grant_type missing
        );

        $client = static::createClient();
        $client->request('POST', '/oauth/token', $postParams);
        $status = $client->getResponse()->getStatusCode();
        $response = $client->getResponse()->getContent();
        $this->assertEquals('400', $status);
        $this->assertEquals('Fields missing from request. Check documentation.', $response);
    }

    public function testTokenHasRequiredParamsInvalid()
    {
        $postParams = array(
            'username' => 'bb',
            'password' => 'wrong',
            'client_id' => 'a9df6c5b72622dbea463ad1a1ba774425efc7eea',
            'client_secret' => '871c85109d7563735565d0b9c044432d3755c5c5',
            'grant_type' => 'password'
        );

        $client = static::createClient();
        $client->request('POST', '/oauth/token', $postParams);
        $status = $client->getResponse()->getStatusCode();
        $this->assertEquals('401', $status);
    }

    public function testResponseWithToken()
    {
        $postParams = array(
            'username' => 'bb',
            'password' => 'bb',
            'client_id' => 'a9df6c5b72622dbea463ad1a1ba774425efc7eea',
            'client_secret' => '871c85109d7563735565d0b9c044432d3755c5c5',
            'grant_type' => 'password'
        );

        $client = static::createClient();
        $client->request('POST', '/oauth/token', $postParams);
        $status = $client->getResponse()->getStatusCode();
        $contentType = $client->getResponse()->headers->get('content-type');
        $content = $client->getResponse()->getContent();
        $content = json_decode($content, true);

        $this->assertEquals('200', $status);
        $this->assertEquals('application/json', $contentType);
        $this->assertTrue(is_array($content));
        $this->assertTrue(isset($content['access_token']));
        $this->assertTrue(isset($content['refresh_token']));
        $this->assertTrue(isset($content['expires_in']));
    }

    public function testInvalidClient()
    {
        $postParams = array(
            'username' => 'bb',
            'password' => 'bb',
            'client_id' => 'someinvalidid',
            'client_secret' => '871c85109d7563735565d0b9c044432d3755c5c5',
            'grant_type' => 'password'
        );

        $client = static::createClient();
        $client->request('POST', '/oauth/token', $postParams);
        $status = $client->getResponse()->getStatusCode();
        $this->assertEquals('401', $status);
    }
}
