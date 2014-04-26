<?php

namespace Melifaro\BookingBundle\Tests\Fixtures\Data\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity\BookableItem;

class LoadItemData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $item = new BookableItem();

        $manager->persist($item);
        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }
} 