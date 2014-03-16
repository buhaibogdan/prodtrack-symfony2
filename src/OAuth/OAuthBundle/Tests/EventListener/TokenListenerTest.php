<?php
namespace OAuth\OAuthBundle\Tests\EventListener;

use OAuth\OAuthBundle\EventListener\TokenListener;

class TokenListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelController()
    {
        //TODO: I guess I'll test this on with controllers that need token validation
        // maybe not the best idea, but...yeah
        $this->assertTrue(true);
    }
}