<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\Pick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pick>
 *
 * @method Pick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pick[]    findAll()
 * @method Pick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pick::class);
    }
}
