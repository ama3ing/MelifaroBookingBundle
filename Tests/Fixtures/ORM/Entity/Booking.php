<?php

namespace Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity;

use Melifaro\BookingBundle\Entity\Booking as BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Entity()
 * @ORM\Table(name="booking")
 */
class Booking extends BaseClass
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
     * @var \Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity\BookableItem
     *
     * @ORM\ManyToOne(targetEntity="BookableItem", inversedBy="bookings")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    protected $item;

    /**
     * @param \Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity\BookableItem $item
     * @return $this
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return \Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity\BookableItem
     */
    public function getItem()
    {
        return $this->item;
    }
} 