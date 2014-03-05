<?php

namespace OAuth\OAuthBundle\Tests\Services;

use OAuth\OAuthBundle\Entity\Client;
use OAuth\OAuthBundle\Services\AccessTokenService;

class AccessTokenServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $emMock = null;
    protected $validClient;
    protected $invalidClient = null;

    protected $clientId = 'a9df6c5b72622dbea463ad1a1ba774425efc7eea';
    protected $clientSecret = '871c85109d7563735565d0b9c044432d3755c5c5';
    protected $grantType = 'password';

    protected function setUp()
    {
        $validClient = new Client();
        $validClient->setUserId(1);
        $validClient->setClientId($this->clientId);
        $validClient->setClientSecret($this->clientSecret);
        $validClient->setName('Prodtrack Client');
        $validClient->setGrantTypes('password');
        $validClient->setDefaultScope('read,create,edit,delete');
        $validClient->setDefaultScope('local.prodtrackclient.com/oauth/success');
        $this->validClient = $validClient;
    }

    public function testTokenLengthAndType()
    {
        $emMock = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();

        $tokenGen = new AccessTokenService($emMock);
        $token = $tokenGen->getNewToken();

        $this->assertTrue(is_string($token));
    }

    public function testTokenDifferent()
    {
        $emMock = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();

        $tokenGen = new AccessTokenService($emMock);
        $token1 = $tokenGen->getNewToken();
        $token2 = $tokenGen->getNewToken();

        $this->assertNotEquals($token1, $token2);
    }

    public function testValidClient()
    {
        $accTokenRepoMock = $this->getMockBuilder('\OAuth\OAuthBundle\Repository\AccessTokenRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $accTokenRepoMock->expects($this->once())
            ->method('getClient')
            ->with(
                $this->clientId,
                $this->clientSecret,
                $this->grantType
            )
            ->will($this->returnValue($this->validClient));

        $emMock = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $emMock->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($accTokenRepoMock));

        $tokenService = new AccessTokenService($emMock);
        $client = $tokenService->handleResourceOwnerFlow(
            $this->clientId,
            $this->clientSecret,
            $this->grantType
        );

        $this->assertTrue($client instanceof Client);
    }
}