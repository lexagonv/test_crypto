<?php

namespace App\Repository;

use App\Entity\History;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function getDataByDates(DateTime $from, DateTime $to, $pairName)
    {
        $em = $this->getEntityManager();
        return $em->createQueryBuilder()
            ->select('history')
            ->from(History::class, 'history')
            ->where('history.pairName = :pairName')
            ->andWhere('history.date >= :from')
            ->andWhere('history.date <= :to')
            ->setParameter('pairName', $pairName)
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->orderBy('history.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

}