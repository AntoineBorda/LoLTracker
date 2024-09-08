<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\Opponent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Opponent>
 *
 * @method Opponent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opponent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opponent[]    findAll()
 * @method Opponent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpponentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opponent::class);
    }

    //    /**
    //     * @return Opponent[] Returns an array of Opponent objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Opponent
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
