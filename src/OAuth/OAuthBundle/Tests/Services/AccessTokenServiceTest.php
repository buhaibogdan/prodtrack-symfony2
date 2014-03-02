<?php

namespace OAuth\OAuthBundle\Tests\Services;

use OAuth\OAuthBundle\Services\AccessTokenService;

class AccessTokenServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $tokenRepo = null;

    protected function setUp()
    {
        $this->tokenRepo = $this->getMock('OAuth\OAuthBundle\Repository\AccessTokenRepository');
    }

    public function testTokenLengthAndType()
    {
        $tokenGen = new AccessTokenService($this->tokenRepo);
        $token = $tokenGen->getNewToken();

        $this->assertTrue(is_string($token));
    }

    public function testTokenDifferent()
    {
        $tokenGen = new AccessTokenService($this->tokenRepo);
        $token1 = $tokenGen->getNewToken();
        $token2 = $tokenGen->getNewToken();

        $this->assertNotEquals($token1, $token2);
    }
}