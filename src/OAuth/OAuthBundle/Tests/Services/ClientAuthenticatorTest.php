<?php


namespace OAuth\OAuthBundle\Tests\Services;


use OAuth\OAuthBundle\Entity\AccessToken;
use OAuth\OAuthBundle\Entity\Client;
use OAuth\OAuthBundle\Services\ClientAuthenticator;

class ClientAuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    protected $clientServiceMock;
    protected $tokenServiceMock;
    protected $validClient;
    protected $validAccessTokenRecord;

    protected $clientId = 'a9df6c5b72622dbea463ad1a1ba774425efc7eea';
    protected $clientSecret = '871c85109d7563735565d0b9c044432d3755c5c5';
    protected $grantType = 'password';

    public function setUp()
    {
        $this->tokenServiceMock = $this->getMockBuilder('\OAuth\OAuthBundle\Services\AccessTokenService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientServiceMock = $this->getMockBuilder('\OAuth\OAuthBundle\Services\ClientService')
            ->disableOriginalConstructor()
            ->getMock();

        $validClient = new Client();
        $validClient->setId(1);
        $validClient->setUserId(1);
        $validClient->setClientId($this->clientId);
        $validClient->setClientSecret($this->clientSecret);
        $validClient->setName('Prodtrack Client');
        $validClient->setGrantTypes('password');
        $validClient->setDefaultScope('read,create,edit,delete');
        $validClient->setDefaultScope('local.prodtrackclient.com/oauth/success');
        $this->validClient = $validClient;

        $validAccessTokenRecord = new AccessToken();
        $validAccessTokenRecord->setAccessToken('3b4b89cc13254d43775b0a3027fdae5cd721c98e');
        $validAccessTokenRecord->setExpiresIn(3600);
        $validAccessTokenRecord->setFkClientId(1);
        $validAccessTokenRecord->setTokenType('bearer');
        $validAccessTokenRecord->setRefreshToken('9d3792e447a515891dc9f02afa449b9237e3c9c6');
        $this->validAccessTokenRecord = $validAccessTokenRecord;
    }

    /**
     * @expectedException \OAuth\OAuthBundle\Exception\ClientNotFoundException
     */
    public function testGetTokenForClientNotFound()
    {
        $this->tokenServiceMock->expects($this->never())
            ->method('getAccessToken')
            ->will($this->returnValue(null));

        $this->clientServiceMock->expects($this->once())
            ->method('getClient')
            ->with('invalidid', 'invalidsecret', 'invalidtokentype')
            ->will($this->returnValue(null));

        $auth = new ClientAuthenticator($this->clientServiceMock, $this->tokenServiceMock);
        $auth->getTokenForClient('invalidid', 'invalidsecret', 'invalidtokentype');

        $this->assertTrue(false, 'Exception not thrown.');
    }

    public function testGetTokenForClientFound()
    {
        $this->tokenServiceMock->expects($this->once())
            ->method('getAccessToken')
            ->with(1)
            ->will($this->returnValue($this->validAccessTokenRecord));

        $this->clientServiceMock->expects($this->once())
            ->method('getClient')
            ->with($this->clientId, $this->clientSecret, $this->grantType)
            ->will($this->returnValue($this->validClient));

        $auth = new ClientAuthenticator($this->clientServiceMock, $this->tokenServiceMock);
        $token = $auth->getTokenForClient($this->clientId, $this->clientSecret, $this->grantType);

        $this->assertTrue(is_array($token), 'Token is not array.');
        $this->assertArrayHasKey('access_token', $token);
        $this->assertArrayHasKey('refresh_token', $token);
        $this->assertArrayHasKey('expires_in', $token);
    }
}