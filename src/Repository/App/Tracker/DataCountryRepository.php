<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\DataCountry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataCountry>
 *
 * @method DataCountry|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataCountry|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataCountry[]    findAll()
 * @method DataCountry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataCountryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataCountry::class);
    }

    //    /**
    //     * @return DataCountry[] Returns an array of DataCountry objects
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

    //    public function findOneBySomeField($value): ?DataCountry
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
