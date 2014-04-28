<?php

namespace Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Entity()
 * @ORM\Table(name="item")
 */
class BookableItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Booking", mappedBy="item")
     */
    protected $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function addBooking($bookings)
    {
        $this->bookings[] = $bookings;

        return $this;
    }

    public function removeBooking($booking)
    {
        $this->bookings->removeElement($booking);
    }

    public function getBookings()
    {
        return $this->bookings;
    }
}
