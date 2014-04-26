<?php

namespace Melifaro\BookingBundle\Helper;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\QueryBuilder;

class Booker
{
    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $repository;

    /**
     * @var string
     */
    private $entity;

    /**
     * @param string $entity
     * @param Registry $doctrine
     */
    public function __construct($entity, Registry $doctrine)
    {
        $this->entity = $entity;
        $this->doctrine = $doctrine;
        $this->repository = $doctrine->getRepository($entity);
    }

    /**
     * @param $item
     * @param \DateTime $start
     * @param \DateTime $end
     * @return bool
     */
    public function isAvailableForPeriod($item, \DateTime $start, \DateTime $end)
    {

        $qb = $this->repository->createQueryBuilder('b');
        $query = $qb->select('b.id')
            ->where('b.start <= :start AND b.end >= :end')
            ->orWhere('b.start >= :start AND b.end <= :end')
            ->orWhere('b.start >= :start AND b.end >= :end AND b.start <= :end')
            ->orWhere('b.start <= :start AND b.end <= :end AND b.end >= :start')

            ->andWhere('b.item = :item')
            ->setParameters(array(
                'start'=> $start,
                'end'  => $end,
                'item' => $item
            ))
            ;

        $results = $query->getQuery()->getResult();

        return count($results) === 0;
    }

    /**
     * @param $item
     * @param \DateTime $date
     * @return bool
     */
    public function isAvailableForDate($item, \DateTime $date)
    {
        $qb = $this->repository->createQueryBuilder('b');
        $results = $qb->select('b.id')
            ->where('b.start <= :date AND b.end >= :date')
            ->andWhere('b.item = :item')
            ->setParameter('item', $item)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();

        return count($results) === 0;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $join array(field, alias)
     * @param \DateTime $start
     * @param \DateTime $end
     */
    public function whereAvailableForPeriod(QueryBuilder $queryBuilder, $join, \DateTime $start, \DateTime $end)
    {
        $queryBuilder->leftJoin($join['field'], $join['alias'])
            ->where($join['alias'].'.start >= :start AND '.$join['alias'].'.end <= :end')
            ->orWhere($join['alias'].'.start <= :start AND '.$join['alias'].'.end >= :end')
            ->orWhere($join['alias'].'.start <= :start AND '.$join['alias'].'.end >= :end AND '.
                $join['alias'].'.start <= :end')
            ->orWhere($join['alias'].'.start >= :start AND '.$join['alias'].'.end <= :end AND '.
                $join['alias'].'.end >= :start')

            ->setParameters(array(
                'start'=> $start,
                'end'  => $end,
            ))
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $join
     * @param \DateTime $date
     */
    public function whereAvailableForDate(QueryBuilder $queryBuilder, $join, \DateTime $date)
    {
        $queryBuilder->leftJoin($join['field'], $join['alias'])
            ->where('b.start >= :date AND b.end <= :date')
            ->setParameter('date', $date)
        ;
    }

    public function book($item, \DateTime $start, \DateTime $end)
    {
        if($this->isAvailableForPeriod($item, $start, $end)) {

            $entity = new $this->entity;
            $entity->setStart($start);
            $entity->setEnd($end);
            $entity->setItem($item);

            $manager = $this->doctrine->getManager();
            $manager->persist($entity);
            $manager->flush();

            return $entity;
        }

        return false;
    }

} 