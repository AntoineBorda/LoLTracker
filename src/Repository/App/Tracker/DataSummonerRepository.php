<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\DataSummoner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataSummoner>
 *
 * @method DataSummoner|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataSummoner|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataSummoner[]    findAll()
 * @method DataSummoner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataSummonerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataSummoner::class);
    }

    //    /**
    //     * @return DataSummoner[] Returns an array of DataSummoner objects
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

    //    public function findOneBySomeField($value): ?DataSummoner
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
