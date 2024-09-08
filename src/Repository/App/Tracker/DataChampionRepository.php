<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\DataChampion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataChampion>
 *
 * @method DataChampion|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataChampion|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataChampion[]    findAll()
 * @method DataChampion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataChampionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataChampion::class);
    }

    //    /**
    //     * @return DataChampion[] Returns an array of DataChampion objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DataChampion
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
