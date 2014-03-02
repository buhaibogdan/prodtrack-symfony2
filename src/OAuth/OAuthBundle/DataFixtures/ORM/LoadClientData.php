<?php

namespace Prodtrack\Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use OAuth\OAuthBundle\Entity\Client;

class LoadClient extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $client1 = new Client();
        $client1->setClientId('a9df6c5b72622dbea463ad1a1ba774425efc7eea');
        $client1->setClientSecret('871c85109d7563735565d0b9c044432d3755c5c5');
        $client1->setName('Prodtrack client');
        $client1->setDefaultScope('read,create,edit,delete');
        $client1->setGrantTypes('password');
        $client1->setUserId(1);
        $client1->setRedirectUri('local.prodtrackclient.com/oauth/success');

        $manager->persist($client1);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}