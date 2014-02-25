<?php

namespace Prodtrack\Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Prodtrack\Bundle\Entity\Activity;


class LoadActivityData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     */
    function load(ObjectManager $manager)
    {
        $activity1 = new Activity();
        $activity1->setName('Learn about HATEOAS');
        $activity1->setDescription('Read some book and do some work.');

        $activity2 = new Activity();
        $activity2->setName('Cook');

        $activity3 = new Activity();
        $activity3->setName('Look at the stars');

        $manager->persist($activity1);
        $manager->persist($activity2);
        $manager->persist($activity3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}