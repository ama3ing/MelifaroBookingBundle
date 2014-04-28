<?php

namespace Melifaro\BookingBundle\Tests\Fixtures\Data\ORM;

namespace Melifaro\BookingBundle\Tests\Fixtures\Data\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity\Booking;

class LoadBookingData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $booking = new Booking();
        $item = $manager->getRepository('Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity\BookableItem')
            ->findOneBy(array());

        $booking->setItem($item);
        $booking->setStart(new \DateTime('2014-05-01'));
        $booking->setEnd(new \DateTime('2014-05-09'));

        $manager->persist($booking);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
