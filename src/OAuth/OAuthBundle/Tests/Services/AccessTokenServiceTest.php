<?php

namespace OAuth\OAuthBundle\Tests\Services;

use OAuth\OAuthBundle\Entity\AccessToken;
use OAuth\OAuthBundle\Services\AccessTokenService;

class AccessTokenServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $clientId = 1;
    /** @var  \OAuth\OAuthBundle\Entity\AccessToken $validAccessTokenRecord */
    protected $validAccessTokenRecord;
    protected $nullAccessTokenRecord = null;

    protected function setUp()
    {
        $validAccessTokenRecord = new AccessToken();
        $validAccessTokenRecord->setAccessToken('3b4b89cc13254d43775b0a3027fdae5cd721c98e');
        $validAccessTokenRecord->setExpiresIn(3600);
        $validAccessTokenRecord->setFkClientId(1);
        $validAccessTokenRecord->setTokenType('bearer');
        $validAccessTokenRecord->setRefreshToken('9d3792e447a515891dc9f02afa449b9237e3c9c6');
        $this->validAccessTokenRecord = $validAccessTokenRecord;
    }


    public function testGetAccessTokenRecordExisting()
    {
        $tokenRepo = $this->getMockBuilder('\OAuth\OAuthBundle\Repository\AccessTokenRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $tokenRepo->expects($this->once())
            ->method('getRecordForClient')
            ->with($this->clientId)
            ->will($this->returnValue($this->validAccessTokenRecord));

        $em = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($tokenRepo));

        $tokenService = new AccessTokenService($em);
        $accessToken = $tokenService->getAccessToken($this->clientId);

        $this->assertTrue($accessToken instanceof AccessToken, 'getAccessToken did not return an entity.');
        $this->assertEquals($this->validAccessTokenRecord->getFkClientId(), $accessToken->getFkClientId());
        $this->assertEquals($this->validAccessTokenRecord->getExpiresIn(), $accessToken->getExpiresIn());
        $this->assertEquals($this->validAccessTokenRecord->getAccessToken(), $accessToken->getAccessToken());
        $this->assertEquals($this->validAccessTokenRecord->getId(), $accessToken->getId());
        $this->assertEquals($this->validAccessTokenRecord->getRefreshToken(), $accessToken->getRefreshToken());
        $this->assertEquals($this->validAccessTokenRecord->getTokenType(), $accessToken->getTokenType());
    }

    public function testGetAccessTokenNoRecord()
    {
        $tokenRepo = $this->getMockBuilder('\OAuth\OAuthBundle\Repository\AccessTokenRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $tokenRepo->expects($this->once())
            ->method('getRecordForClient')
            ->with($this->clientId)
            ->will($this->returnValue($this->nullAccessTokenRecord));

        $em = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($tokenRepo));

        $tokenService = new AccessTokenService($em);
        $accessToken = $tokenService->getAccessToken($this->clientId);

        $this->assertTrue($accessToken instanceof AccessToken, 'getAccessToken did not return an entity.');
        $this->assertNotEquals(
            $accessToken->getRefreshToken(),
            $accessToken->getAccessToken(),
            'refresh and access token can not be equal'
        );
        $this->assertTrue(is_string($accessToken->getAccessToken()), 'access token is not string');
        $this->assertTrue(is_string($accessToken->getRefreshToken()), 'refresh token is not string');
    }
}