<?php
namespace Melifaro\BookingBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class Booking
 * @package Melifaro\BookingBundle\Document
 * @codeCoverageIgnore
 * @ODM\MappedSuperClass
 */
abstract class Booking
{
    protected $id;

    /**
     * @var \DateTime
     *
     * @ODM\Date(name="start", type="date")
     */
    protected  $start;

    /**
     * @var \DateTime
     *
     * @ODM\Date(name="end", type="date")
     */
    protected $end;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     * @return Booking
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Booking
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }


    public abstract function getItem();

    public abstract function setItem($item);
} 