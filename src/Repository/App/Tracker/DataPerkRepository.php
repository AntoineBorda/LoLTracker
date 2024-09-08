<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\DataPerk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataPerk>
 *
 * @method DataPerk|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataPerk|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataPerk[]    findAll()
 * @method DataPerk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataPerkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataPerk::class);
    }

    //    /**
    //     * @return DataPerk[] Returns an array of DataPerk objects
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

    //    public function findOneBySomeField($value): ?DataPerk
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
