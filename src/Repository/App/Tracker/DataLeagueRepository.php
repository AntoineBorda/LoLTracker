<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\DataLeague;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataLeague>
 *
 * @method DataLeague|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataLeague|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataLeague[]    findAll()
 * @method DataLeague[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataLeagueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataLeague::class);
    }

    //    /**
    //     * @return DataLeague[] Returns an array of DataLeague objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DataLeague
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
