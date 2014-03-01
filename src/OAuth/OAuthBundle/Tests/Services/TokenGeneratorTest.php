<?php

namespace OAuth\OAuthBundle\Tests\Services;

use OAuth\OAuthBundle\Services\TokenGenerator;

class TokenGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testTokenLengthAndType()
    {
        $tokenGen = new TokenGenerator();
        $token = $tokenGen->getToken();

        $this->assertTrue(is_string($token));
    }

    public function testTokenDifferent()
    {
        $tokenGen = new TokenGenerator();
        $token1 = $tokenGen->getToken();
        $token2 = $tokenGen->getToken();

        $this->assertNotEquals($token1, $token2);
    }
}