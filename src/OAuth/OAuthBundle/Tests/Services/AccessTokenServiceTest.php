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
    protected $validRefreshToken = '7accc0764185a19ea4f7d20ae4053a5a467ef589';
    protected $invalidRefreshToken = 'invalid';

    protected function setUp()
    {
        $validAccessTokenRecord = new AccessToken();
        $validAccessTokenRecord->setAccessToken('3b4b89cc13254d43775b0a3027fdae5cd721c98e');
        $validAccessTokenRecord->setExpiresIn(3600);
        $validAccessTokenRecord->setFkClientId(1);
        $validAccessTokenRecord->setTokenType('bearer');
        $validAccessTokenRecord->setRefreshToken('9d3792e447a515891dc9f02afa449b9237e3c9c6');
        $validAccessTokenRecord->setCreatedOn(new \DateTime());
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

    public function testCheckTokenValid()
    {
        $tokenRepo = $this->getMockBuilder('\OAuth\OAuthBundle\Repository\AccessTokenRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $tokenRepo->expects($this->once())
            ->method('getAccessTokenByType')
            ->with('3b4b89cc13254d43775b0a3027fdae5cd721c98e', 'bearer')
            ->will($this->returnValue($this->validAccessTokenRecord));

        $em = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($tokenRepo));

        $tokenService = new AccessTokenService($em);
        $status = $tokenService->isTokenValid('3b4b89cc13254d43775b0a3027fdae5cd721c98e', 'bearer');

        $this->assertTrue($status, 'Token expired. Was not supposed to.');
    }

    public function testCheckTokenInvalid()
    {
        $tokenRepo = $this->getMockBuilder('\OAuth\OAuthBundle\Repository\AccessTokenRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $tokenRepo->expects($this->once())
            ->method('getAccessTokenByType')
            ->with('invalid', 'bearer')
            ->will($this->returnValue(null));

        $em = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($tokenRepo));

        $tokenService = new AccessTokenService($em);
        $status = $tokenService->isTokenValid('invalid', 'bearer');

        $this->assertFalse($status, 'Token found. Was not supposed to.');
    }

    public function testCheckTokenExpired()
    {
        $this->validAccessTokenRecord->setCreatedOn(new \DateTime('-2 hours'));
        $tokenRepo = $this->getMockBuilder('\OAuth\OAuthBundle\Repository\AccessTokenRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $tokenRepo->expects($this->once())
            ->method('getAccessTokenByType')
            ->with('3b4b89cc13254d43775b0a3027fdae5cd721c98e', 'bearer')
            ->will($this->returnValue($this->validAccessTokenRecord));

        $em = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($tokenRepo));

        $tokenService = new AccessTokenService($em);
        $status = $tokenService->isTokenValid('3b4b89cc13254d43775b0a3027fdae5cd721c98e', 'bearer');

        $this->assertFalse($status, 'Token should have expired');
    }

    public function testGetAccessTokenRefreshValid()
    {
        $tokenRepo = $this->getMockBuilder('\OAuth\OAuthBundle\Repository\AccessTokenRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $tokenRepo->expects($this->once())
            ->method('getRecordWithRefreshToken')
            ->with($this->validRefreshToken)
            ->will($this->returnValue($this->validAccessTokenRecord));

        $em = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($tokenRepo));

        $tokenService = new AccessTokenService($em);
        $accessToken = $tokenService->getAccessTokenForRefresh($this->validRefreshToken);

        $this->assertTrue($accessToken instanceof AccessToken, 'getAccessToken did not return an entity.');
        $this->assertEquals($this->validAccessTokenRecord->getFkClientId(), $accessToken->getFkClientId());
        $this->assertEquals($this->validAccessTokenRecord->getExpiresIn(), $accessToken->getExpiresIn());
        $this->assertEquals($this->validAccessTokenRecord->getAccessToken(), $accessToken->getAccessToken());
        $this->assertEquals($this->validAccessTokenRecord->getId(), $accessToken->getId());
        $this->assertEquals($this->validAccessTokenRecord->getRefreshToken(), $accessToken->getRefreshToken());
        $this->assertEquals($this->validAccessTokenRecord->getTokenType(), $accessToken->getTokenType());
    }

    public function testGetAccessTokenRefreshInValid()
    {
        $tokenRepo = $this->getMockBuilder('\OAuth\OAuthBundle\Repository\AccessTokenRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $tokenRepo->expects($this->once())
            ->method('getRecordWithRefreshToken')
            ->with($this->invalidRefreshToken)
            ->will($this->returnValue(null));

        $em = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($tokenRepo));

        $tokenService = new AccessTokenService($em);
        $accessToken = $tokenService->getAccessTokenForRefresh($this->invalidRefreshToken);

        $this->assertNull($accessToken, 'getAccessToken did not return null.');
    }
}