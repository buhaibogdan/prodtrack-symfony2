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

    public function testTokenHasRequiredParams()
    {
        $postParams = array(
            'username' => 'bb',
            'password' => '123456',
            'client_id' => 'sfjg3nl4knansd2',
            'client_secret' => 'fhbgkbk12kug312',
            'grant_type' => 'password'
        );

        $client = static::createClient();
        $client->request('POST', '/oauth/token', $postParams);
        $status = $client->getResponse()->getStatusCode();
        $this->assertEquals('200', $status);
    }
}
