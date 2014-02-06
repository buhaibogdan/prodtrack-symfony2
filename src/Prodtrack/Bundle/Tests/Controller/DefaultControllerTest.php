<?php

namespace Prodtrack\Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexCorrectAcceptHeader()
    {
        $client = static::createClient();
        $client->request('GET', '/', array(), array(), array('HTTP_Accept' => 'application/hal+json'));
        $contentType = $client->getResponse()->headers->get('content-type');
        $this->assertEquals('application/hal+json', $contentType);
    }

    public function testIndexIncorrectAcceptHeaders()
    {
        $client = static::createClient();
        $client->request('GET', '/', array(), array(), array('HTTP_Accept' => 'text/html'));
        $status = $client->getResponse()->getStatusCode();

        $this->assertEquals(406, $status);
    }

    public function testIndexContainsEntryPoints()
    {
        $client = static::createClient();
        $client->request('GET', '/', array(), array(), array('HTTP_Accept' => 'application/hal+json'));
        //TODO: check for entry points, stats, history and activities
    }
}
