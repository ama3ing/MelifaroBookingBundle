<?php

namespace Cf\BookingBundle\Twig;

use Doctrine\Bundle\DoctrineBundle\Registry;

class CalendarExtension extends \Twig_Extension
{
    /**
     * Entity class
     * @var string
     */
    private $entity;

    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;

    /**
     * @var \Twig_Environment
     */
    private $environment;

    /**
     * @param string $entity
     * @param Registry $doctrine
     */
    public function __construct($entity, Registry $doctrine)
    {
        $this->entity   = $entity;
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('cf_booking_calendar', array($this, 'renderCalendar'), array('is_safe'=>array('html')))
        );
    }

    /**
     * @param $item
     * @param string $start
     * @param int $months
     * @return string
     * @throws \InvalidArgumentException
     */
    public function renderCalendar($item, $start = 'now', $months = 1)
    {
        if(intval($months) === 0) {
            throw new \InvalidArgumentException('Month number should be integer');
        }
        $now = new \DateTime($start);
        $end = new \DateTime();
        $end->add(new \DateInterval('P'.$months.'M'));

        $bookings = $this->doctrine->getRepository($this->entity)
            ->createQueryBuilder('b')
            ->select('b')
            ->where('b.start >= :now')
            ->orWhere('b.start <= :end')
            ->orWhere('b.end >= :now')
            ->andWhere('b.item = :item')
            ->orderBy('b.start', 'ASC')
            ->setParameters(array(
                'now' => $now,
                'end' => $end,
                'item'=> $item
            ))
            ->getQuery()
            ->getResult();
        ;

        return $this->environment->render('CfBookingBundle:Calendar:month.html.twig', array(
            'bookings'=>$bookings,
            'start' => $start,
            'months'=>$months
        ));
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getName()
    {
        return 'cf_booking_bundle_calendar';
    }
} 