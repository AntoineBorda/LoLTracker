<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\DataQueue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataQueue>
 *
 * @method DataQueue|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataQueue|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataQueue[]    findAll()
 * @method DataQueue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataQueueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataQueue::class);
    }
}
