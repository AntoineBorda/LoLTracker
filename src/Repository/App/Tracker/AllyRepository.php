<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\Ally;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ally>
 *
 * @method Ally|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ally|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ally[]    findAll()
 * @method Ally[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ally::class);
    }

    //    /**
    //     * @return Ally[] Returns an array of Ally objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ally
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
