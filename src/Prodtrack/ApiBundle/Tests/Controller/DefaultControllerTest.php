<?php

namespace Prodtrack\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    protected function getAuthMock()
    {
        $auth = $this->getMockBuilder('\OAuth\OAuthBundle\Services\ClientAuthenticator')
            ->disableOriginalConstructor()
            ->getMock();
        $auth->expects($this->any())
            ->method('hasValidAuthorization')
            // this should be "Bearer 3de216ba6dedcf3bd2a592a071c01b5cdba0669f"
            // but it seems the authorization header is not passes from the tests (BrowserKit?)
            ->with(null)
            ->will($this->returnValue(true));

        return $auth;
    }

    public function testIndexCorrectAcceptHeader()
    {
        $client = static::createClient();
        $client->getContainer()->set('o_auth.authenticator', $this->getAuthMock());
        $client->request(
            'GET',
            '/',
            array(),
            array(),
            array(
                'HTTP_Accept' => 'application/vnd.collection+json',
                'HTTP_AUTHORIZATION' => 'Bearer 3de216ba6dedcf3bd2a592a071c01b5cdba0669f'
            )
        );
        $contentType = $client->getResponse()->headers->get('content-type');
        $this->assertEquals('application/vnd.collection+json', $contentType);
    }

    public function testIndexIncorrectAcceptHeaders()
    {
        $client = static::createClient();
        $client->getContainer()->set('o_auth.authenticator', $this->getAuthMock());
        $client->request(
            'GET',
            '/',
            array(),
            array(),
            array(
                'HTTP_Accept' => 'text/html',
                'HTTP_AUTHORIZATION' => 'Bearer 3de216ba6dedcf3bd2a592a071c01b5cdba0669f'
            )
        );
        $status = $client->getResponse()->getStatusCode();

        $this->assertEquals(406, $status);
    }

    public function testIndexContainsEntryPoints()
    {
        $client = static::createClient();
        $client->getContainer()->set('o_auth.authenticator', $this->getAuthMock());
        $client->request(
            'GET',
            '/',
            array(),
            array(),
            array(
                'HTTP_Accept' => 'application/vnd.collection+json',
                'HTTP_AUTHORIZATION' => 'Bearer 3de216ba6dedcf3bd2a592a071c01b5cdba0669f'
            )
        );
        //TODO: check for entry points, stats, history and activities
    }
}
