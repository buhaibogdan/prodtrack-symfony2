<?php

namespace OAuth\OAuthBundle\Tests\Services;

use OAuth\OAuthBundle\Services\AccessTokenService;

class AccessTokenServiceTest extends \PHPUnit_Framework_TestCase
{

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
}