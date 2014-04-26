<?php
/**
 * Created by PhpStorm.
 * User: melifaro
 * Date: 4/26/14
 * Time: 6:20 PM
 */

namespace Melifaro\BookingBundle\Tests\Fixtures\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Entity()
 * @ORM\Table(name="booking")
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
} 