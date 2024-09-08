<?php

namespace App\Repository\App\Tracker;

use App\Entity\App\Tracker\Summoner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Summoner>
 *
 * @method Summoner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Summoner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Summoner[]    findAll()
 * @method Summoner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SummonerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Summoner::class);
    }

    //    /**
    //     * @return Summoner[] Returns an array of Summoner objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Summoner
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
