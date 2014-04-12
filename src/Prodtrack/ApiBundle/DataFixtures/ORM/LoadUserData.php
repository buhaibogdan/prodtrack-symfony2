<?php

namespace Prodtrack\ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Prodtrack\ApiBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('bb');
        $user1->setEmail('bb@email.com');
        $user1->setPassword('bb');

        $user2 = new User();
        $user2->setUsername('john');
        $user2->setEmail('john@email.com');
        $user2->setPassword('john');

        $manager->persist($user1);
        $manager->persist($user2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}